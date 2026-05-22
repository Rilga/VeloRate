<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\AssessmentCriteria;
use App\Models\Evaluation;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class EvaluationController extends Controller
{
    public function index(Request $request)
    {
        // Mengambil tahun saat ini secara dinamis (cth: 2026) dan kuartal default Q1
        $currentYear = date('Y');
        $selectedPeriod = $request->get('period', "{$currentYear}-Q1");

        // Ambil karyawan beserta evaluasi khusus pada periode tahun-kuartal tersebut
        $employees = User::where('role', 'user')
            ->with(['evaluations' => function($query) use ($selectedPeriod) {
                $query->where('period', $selectedPeriod);
            }])
            ->get();
        
        return view('manager.evaluations.index', compact('employees', 'selectedPeriod'));
    }

    public function create(Request $request, User $employee)
    {
        $criteria = AssessmentCriteria::all();
        
        if ($criteria->sum('weight') != 100) {
            return redirect()->route('manager.evaluations.index')
                ->with('error', 'Total bobot kriteria belum 100%. Hubungi Admin.');
        }

        $chosenPeriod = $request->get('period', date('Y') . '-Q1');

        // Cari tahu apakah karyawan ini sudah punya nilai di periode tersebut
        $existingEvaluation = Evaluation::where('employee_id', $employee->id)
                                        ->where('period', $chosenPeriod)
                                        ->first();

        return view('manager.evaluations.create', compact('employee', 'criteria', 'chosenPeriod', 'existingEvaluation'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:users,id',
            'period' => 'required|string',
            'scores' => 'required|array',
            'notes' => 'nullable|string',
        ]);

        $criteria = AssessmentCriteria::all();
        $finalScore = 0;
        $scoreDetails = [];

        foreach ($criteria as $criterion) {
            $inputScore = $request->scores[$criterion->id] ?? 0;
            $calculated = ($inputScore * $criterion->weight) / 100;
            $finalScore += $calculated;

            $scoreDetails[] = [
                'criteria_id' => $criterion->id,
                'name' => $criterion->name,
                'weight' => $criterion->weight,
                'score' => (int)$inputScore // Pastikan disimpan sebagai angka
            ];
        }

        // LOGIKA UPSERT: Cari berdasarkan employee_id dan period. 
        // Jika ketemu -> UPDATE data lainnya. Jika tidak ketemu -> INSERT baru.
        Evaluation::updateOrCreate(
            [
                'employee_id' => $request->employee_id,
                'period' => $request->period,
            ],
            [
                'manager_id' => auth()->id(),
                'scores' => $scoreDetails,
                'final_score' => $finalScore,
                'notes' => $request->notes,
            ]
        );

        return redirect()->route('evaluations.index')
            ->with('success', 'Evaluasi berhasil disimpan/diperbarui.');
    }
}