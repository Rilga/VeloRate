<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Evaluation;
use App\Models\AssessmentCriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ManagerController extends Controller
{
    public function index(Request $request) {
        // 1. Tentukan Periode Aktif (Default ke Tahun-Kuartal Sekarang)
        $currentYear = date('Y');
        $selectedPeriod = $request->get('period', "{$currentYear}-Q1");

        // 2. Data Statistik Counter Utama
        $totalEmployees = User::where('role', 'user')->count();
        
        $subQueryLatest = Evaluation::select('employee_id', DB::raw('MAX(id) as max_id'))
            ->groupBy('employee_id');

        $latestEvaluations = Evaluation::joinSub($subQueryLatest, 'latest', function ($join) {
                $join->on('evaluations.id', '=', 'latest.max_id');
            })->get();

        $superstars = $latestEvaluations->where('final_score', '>', 80)->count();
        $underperform = $latestEvaluations->where('final_score', '<', 40)->count();
        $averagePerform = $latestEvaluations->whereBetween('final_score', [40, 80])->count();

        // 3. Data Peringkat Karyawan Berdasarkan Periode Terpilih
        $rankings = User::where('role', 'user')
            ->join('evaluations', 'users.id', '=', 'evaluations.employee_id')
            ->select('users.name', 'users.position', 'users.division', 'evaluations.final_score', 'evaluations.period')
            ->where('evaluations.period', $selectedPeriod)
            ->orderBy('evaluations.final_score', 'desc')
            ->get();

        // 4. Data Grafik: Perbandingan Nilai Rata-rata per Divisi Berdasarkan Periode Terpilih
        $divisionStats = User::where('role', 'user')
            ->join('evaluations', 'users.id', '=', 'evaluations.employee_id')
            ->select('users.division', DB::raw('ROUND(AVG(evaluations.final_score), 1) as avg_score'))
            ->where('evaluations.period', $selectedPeriod)
            ->groupBy('users.division')
            ->get();

        $divisionLabels = $divisionStats->pluck('division')->toArray();
        $divisionData = $divisionStats->pluck('avg_score')->toArray();

        // 5. Data Grafik: Tren Performa Organisasi Keseluruhan (Tetap Sepanjang Waktu)
        $trendStats = Evaluation::select('period', DB::raw('ROUND(AVG(final_score), 1) as avg_score'))
            ->groupBy('period')
            ->orderBy('period', 'asc')
            ->get();

        $trendLabels = $trendStats->pluck('period')->toArray();
        $trendData = $trendStats->pluck('avg_score')->toArray();

        return view('manager.dashboard', compact(
            'totalEmployees',
            'superstars',
            'underperform',
            'averagePerform',
            'rankings',
            'selectedPeriod',
            'divisionLabels',
            'divisionData',
            'trendLabels',
            'trendData'
        ));
    }

    public function analytics()
    {
        // ==========================================
        // 1. KPI CATEGORY AVERAGES (DATA RIIL)
        // ==========================================
        // Kita ambil semua kriteria aktif, lalu hitung rata-rata nilai kriteria tersebut 
        // dari kolom JSON 'scores' yang ada di tabel evaluations.
        $criteria = AssessmentCriteria::all();
        $kpiCategoryAverages = [];

        // Ambil semua data skor evaluasi dari database
        $allEvaluations = Evaluation::all();

        foreach ($criteria as $criterion) {
            $totalScoreForCriterion = 0;
            $evaluationCount = 0;

            foreach ($allEvaluations as $eval) {
                // Pastikan kolom scores berwujud array (karena cast array di model)
                if (is_array($eval->scores)) {
                    foreach ($eval->scores as $scoreDetail) {
                        if ($scoreDetail['criteria_id'] == $criterion->id) {
                            $totalScoreForCriterion += $scoreDetail['score'];
                            $evaluationCount++;
                        }
                    }
                }
            }

            // Hitung rata-rata kriteria, jika belum ada nilai default ke 0
            $kpiCategoryAverages[$criterion->name] = $evaluationCount > 0 
                ? round($totalScoreForCriterion / $evaluationCount, 1) 
                : 0;
        }


        // ==========================================
        // 2. SCORE DISTRIBUTION (DATA RIIL LATEST)
        // ==========================================
        // Mengambil evaluasi terbaru dari setiap karyawan unik
        $subQueryLatest = Evaluation::select('employee_id', DB::raw('MAX(id) as max_id'))
            ->groupBy('employee_id');

        $latestEvaluations = Evaluation::joinSub($subQueryLatest, 'latest', function ($join) {
                $join->on('evaluations.id', '=', 'latest.max_id');
            })->get();

        // Ambil total baris data yang ada di list rankings kuartal berjalan
        // Di halaman dashboard, penerima bonus dibatasi hanya untuk TOP 3 teratas
        $totalRanked = $latestEvaluations->count();
        
        // Aturan: Top 3 otomatis Bonus Eligible, sisanya Retain (jika >= 40) atau Warning (jika < 40)
        // Kita urutkan dulu data evaluasi terbaru dari nilai tertinggi ke terendah
        $sortedEvaluations = $latestEvaluations->sortByDesc('final_score')->values();

        $bonusCount = 0;
        $retainCount = 0;
        $warningCount = 0;

        foreach ($sortedEvaluations as $index => $eval) {
            if ($index < 3 && $eval->final_score > 70) {
                $bonusCount++; // Top 3 berhak mendapat bonus sesuai logika dashboard kita
            } elseif ($eval->final_score < 40) {
                $warningCount++; // Di bawah 40 masuk kategori Warning
            } else {
                $retainCount++; // Sisanya masuk kategori Retain
            }
        }

        $distribution = [
            'bonus'   => $bonusCount,
            'retain'  => $retainCount,
            'warning' => $warningCount
        ];


        // ==========================================
        // 3. MULTI-PERIOD TREND BY DIVISION (DATA RIIL)
        // ==========================================
        // Kita ambil daftar semua divisi unik yang ada di sistem
        $divisions = User::where('role', 'user')->pluck('division')->unique()->toArray();
        
        // Kita buat daftar periode kuartal yang teratur (riil dari database atau kuartal berjalan)
        $trendLabels = Evaluation::orderBy('period', 'asc')->pluck('period')->unique()->values()->toArray();
        
        // Jika belum ada data sama sekali di database, set label default kuartal tahun ini
        if (empty($trendLabels)) {
            $y = date('Y');
            $trendLabels = ["{$y}-Q1", "{$y}-Q2", "{$y}-Q3", "{$y}-Q4"];
        }

        $divisionTrends = [];
        foreach ($divisions as $div) {
            $divisionTrends[$div] = [];
            foreach ($trendLabels as $period) {
                // Hitung rata-rata nilai akhir (final_score) per divisi pada periode kuartal tertentu
                $avgScore = User::where('role', 'user')
                    ->where('division', $div)
                    ->join('evaluations', 'users.id', '=', 'evaluations.employee_id')
                    ->where('evaluations.period', $period)
                    ->avg('evaluations.final_score');

                // Masukkan nilai rata-rata, jika kosong atau tidak ada penilaian di kuartal itu set ke 0
                $divisionTrends[$div][] = $avgScore ? round($avgScore, 1) : 0;
            }
        }

        return view('manager.analytics.analytics', compact('kpiCategoryAverages', 'distribution', 'trendLabels', 'divisionTrends'));
    }
}
