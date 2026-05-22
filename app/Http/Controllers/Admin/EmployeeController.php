<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Evaluation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    // Tampilkan Daftar
    public function index()
    {
        // 1. Mengambil nilai evaluasi paling baru untuk setiap employee_id
        $subQueryLatest = Evaluation::select('employee_id', DB::raw('MAX(id) as max_id'))
            ->groupBy('employee_id');

        // 2. Mengambil user dengan role 'user' beserta nilai terakhirnya secara riil
        $employees = User::where('role', 'user')
            ->leftJoinSub($subQueryLatest, 'latest_eval', function ($join) {
                $join->on('users.id', '=', 'latest_eval.employee_id');
            })
            ->leftJoin('evaluations', 'latest_eval.max_id', '=', 'evaluations.id')
            ->select('users.*', 'evaluations.final_score as last_score')
            ->get();
        
        // 3. Mengambil user dengan role 'manager'
        $managers = User::where('role', 'manager')->get();

        return view('admin.employees.index', compact('employees', 'managers'));
    }

    // Tampilkan Form Tambah
    public function create() {
        return view('admin.employees.create');
    }

    // Proses Simpan Data Baru
    public function store(Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'role' => 'required|in:manager,user',
            'division' => 'required',
            'position' => 'required',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'division' => $request->division,
            'position' => $request->position,
        ]);

        return redirect()->route('employees.index')->with('success', 'Karyawan berhasil ditambahkan.');
    }

    // Tampilkan Form Edit
    public function edit(User $employee) {
        return view('admin.employees.edit', compact('employee'));
    }

    // Proses Update Data
    public function update(Request $request, User $employee) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $employee->id,
            'role' => 'required|in:manager,user',
            'division' => 'required',
            'position' => 'required',
            'password' => 'nullable|min:8',
        ]);

        $data = $request->only(['name', 'email', 'role', 'division', 'position']);
        
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $employee->update($data);

        return redirect()->route('employees.index')->with('success', 'Data berhasil diperbarui.');
    }

    // Proses Hapus
    public function destroy(User $employee) {
        $employee->delete();
        return back()->with('success', 'Karyawan berhasil dihapus.');
    }
}