<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AssessmentCriteria;
use Illuminate\Http\Request;

class CriteriaController extends Controller
{
    /**
     * Menampilkan daftar kriteria dan total bobot saat ini.
     */
    public function index() 
    {
        $criteria = AssessmentCriteria::orderBy('created_at', 'desc')->get();
        $totalWeight = $criteria->sum('weight');
        return view('admin.criteria.index', compact('criteria', 'totalWeight'));
    }

    /**
     * Menyimpan kriteria baru dengan pengecekan kuota maksimal 100%.
     */
    public function store(Request $request)
    {
        // Menambahkan 'description' ke dalam aturan validasi
        $request->validate([
            'name' => 'required|string|max:255',
            'weight' => 'required|numeric|min:1|max:100',
            'description' => 'nullable|string', 
        ]);

        $currentTotal = AssessmentCriteria::sum('weight');
        $availableQuota = 100 - $currentTotal;

        if ($request->weight > $availableQuota) {
            return back()
                ->withInput()
                ->with('error', "Gagal! Sisa kuota bobot hanya {$availableQuota}%. Anda mencoba memasukkan {$request->weight}%.");
        }

        // Otomatis menyimpan description karena menggunakan $request->all()
        AssessmentCriteria::create($request->all());

        return redirect()->route('criteria.index')
            ->with('success', 'Kriteria berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit untuk kriteria tertentu.
     */
    public function edit(AssessmentCriteria $criterion)
    {
        return view('admin.criteria.edit', compact('criterion'));
    }

    /**
     * Memperbarui kriteria dengan memastikan total bobot tetap maksimal 100%.
     */
    public function update(Request $request, AssessmentCriteria $criterion)
    {
        // Menambahkan 'description' ke dalam aturan validasi
        $request->validate([
            'name' => 'required|string|max:255',
            'weight' => 'required|numeric|min:1|max:100',
            'description' => 'nullable|string',
        ]);

        // Hitung total bobot kriteria LAIN (selain yang sedang diedit)
        $otherTotal = AssessmentCriteria::where('id', '!=', $criterion->id)->sum('weight');
        
        if (($otherTotal + $request->weight) > 100) {
            $maxAllowed = 100 - $otherTotal;
            return back()
                ->withInput()
                ->with('error', "Gagal! Maksimal bobot yang diperbolehkan untuk kriteria ini adalah {$maxAllowed}%.");
        }

        // Otomatis memperbarui description karena menggunakan $request->all()
        $criterion->update($request->all());

        return redirect()->route('criteria.index')
            ->with('success', 'Kriteria berhasil diperbarui.');
    }

    /**
     * Menghapus kriteria.
     */
    public function destroy(AssessmentCriteria $criterion) 
    {
        $criterion->delete();
        return back()->with('success', 'Kriteria berhasil dihapus.');
    }
}