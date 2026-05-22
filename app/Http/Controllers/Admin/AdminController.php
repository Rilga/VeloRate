<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\AssessmentCriteria;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index() {
        // 1. Fetch system metrics counters
        $totalEmployees = User::where('role', 'user')->count();
        $totalManagers = User::where('role', 'manager')->count();
        
        // 2. Fetch KPI configuration benchmarks
        $criteria = AssessmentCriteria::orderBy('created_at', 'desc')->get();
        $totalWeight = $criteria->sum('weight');
        $remainingWeight = 100 - $totalWeight;

        // 3. Fetch recent registrations for the activity feed card
        $recentAccounts = User::whereIn('role', ['user', 'manager'])
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();

        return view('admin.dashboard', compact(
            'totalEmployees',
            'totalManagers',
            'criteria',
            'totalWeight',
            'remainingWeight',
            'recentAccounts'
        ));
    }
}
