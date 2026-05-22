<?php

use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\PerformanceController;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CriteriaController;
use App\Http\Controllers\Admin\EmployeeController;

use App\Http\Controllers\Manager\ManagerController;
use App\Http\Controllers\Manager\EvaluationController;

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

//User Route
Route::middleware(['auth', 'userMiddleware'])->group(function (){

    Route::get('dashboard',[UserController::class, 'index'])->name('user.dashboard');

    Route::get('/trend', [UserController::class, 'trend'])->name('user.trend');
    Route::get('/feedback', [UserController::class, 'feedback'])->name('user.feedback');
    Route::get('/export-pdf', [UserController::class, 'exportPdf'])->name('export.pdf');  

});

//Admin Route
Route::middleware(['auth', 'adminMiddleware'])->group(function (){
 
    Route::get('/admin/dashboard',[AdminController::class, 'index'])->name('admin.dashboard');

    // Rute menambahkan kriteria penilaian
    Route::get('/criteria', [CriteriaController::class, 'index'])->name('criteria.index');
    Route::get('/criteria/create', [CriteriaController::class, 'create'])->name('criteria.create');
    Route::post('/criteria', [CriteriaController::class, 'store'])->name('criteria.store');
    Route::get('/criteria/{criterion}/edit', [CriteriaController::class, 'edit'])->name('criteria.edit');
    Route::put('/criteria/{criterion}', [CriteriaController::class, 'update'])->name('criteria.update');
    Route::delete('/criteria/{criterion}', [CriteriaController::class, 'destroy'])->name('criteria.destroy');

    // Rute menambahkan user/karyawan
    Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');
    Route::get('/employees/create', [EmployeeController::class, 'create'])->name('employees.create');
    Route::post('/employees', [EmployeeController::class, 'store'])->name('employees.store');
    Route::get('/employees/{employee}', [EmployeeController::class, 'show'])->name('employees.show');
    Route::get('/employees/{employee}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');
    Route::put('/employees/{employee}', [EmployeeController::class, 'update'])->name('employees.update');
    Route::delete('/employees/{employee}', [EmployeeController::class, 'destroy'])->name('employees.destroy');

});

//Manager Route
Route::middleware(['auth', 'managerMiddleware'])->group(function (){

    Route::get('/manager/dashboard',[ManagerController::class, 'index'])->name('manager.dashboard');

    // Rute menambahkan nilai
    Route::get('/evaluations', [EvaluationController::class, 'index'])->name('evaluations.index');
    Route::get('/evaluations/create/{employee}', [EvaluationController::class, 'create'])->name('evaluations.create');
    Route::post('/evaluations/store', [EvaluationController::class, 'store'])->name('evaluations.store');
    Route::get('/evaluation/history', [EvaluationController::class, 'history'])->name('evaluation.history');

    // Rute analytics
    Route::get('/analytics', [ManagerController::class, 'analytics'])->name('analytics.index');

});