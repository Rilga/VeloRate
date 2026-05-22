<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Evaluation;
use App\Models\AssessmentCriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class UserController extends Controller
{
    public function index(Request $request) {
        $user = Auth::user();
        
        // Get available periods for this user to filter dropdown
        $periods = Evaluation::where('employee_id', $user->id)->orderBy('period', 'desc')->pluck('period');
        $selectedPeriod = $request->get('period', $periods->first() ?: date('Y') . '-Q1');

        // Target evaluation row
        $evaluation = Evaluation::where('employee_id', $user->id)
            ->where('period', $selectedPeriod)
            ->first();

        // Calculate Team Averages for the selected period
        $teamAverage = Evaluation::where('period', $selectedPeriod)->avg('final_score') ?: 0;

        // Compare category scores vs team averages
        $criteria = AssessmentCriteria::all();
        $scoreVsAverage = [];

        foreach ($criteria as $c) {
            // Get employee's raw score for this criterion
            $userScore = 0;
            if ($evaluation && is_array($evaluation->scores)) {
                foreach ($evaluation->scores as $s) {
                    if ($s['criteria_id'] == $c->id) {
                        $userScore = $s['score'];
                        break;
                    }
                }
            }

            // Calculate overall company/team average for this exact criterion
            $allEvaluationsInPeriod = Evaluation::where('period', $selectedPeriod)->get();
            $totalCriterionScore = 0;
            $criterionCount = 0;

            foreach ($allEvaluationsInPeriod as $ev) {
                if (is_array($ev->scores)) {
                    foreach ($ev->scores as $s) {
                        if ($s['criteria_id'] == $c->id) {
                            $totalCriterionScore += $s['score'];
                            $criterionCount++;
                        }
                    }
                }
            }

            $avgCriterionScore = $criterionCount > 0 ? ($totalCriterionScore / $criterionCount) : 0;

            $scoreVsAverage[] = [
                'name' => $c->name,
                'weight' => $c->weight,
                'user_score' => $userScore,
                'team_avg' => round($avgCriterionScore, 1)
            ];
        }

        $rankIndex = Evaluation::where('period', $selectedPeriod)
        ->orderBy('final_score', 'desc')
        ->pluck('employee_id')
        ->search($user->id);

        return view('user.dashboard', compact('user', 'periods', 'selectedPeriod', 'evaluation', 'teamAverage', 'scoreVsAverage', 'rankIndex'));
    }

    public function trend()
    {
        $user = Auth::user();

        // 1. Fetch all chronological evaluations for this employee
        $evaluations = Evaluation::where('employee_id', $user->id)
            ->orderBy('period', 'asc')
            ->get();

        $trendLabels = $evaluations->pluck('period')->toArray();
        $trendScores = $evaluations->pluck('final_score')->toArray();

        // 2. Generate Team/Company Averages for the exact same periods to match the dotted baseline chart
        $teamAverageScores = [];
        foreach ($trendLabels as $period) {
            $teamAverageScores[] = round(Evaluation::where('period', $period)->avg('final_score') ?: 0, 1);
        }

        // 3. Process KPI Progress Over Time (Delta between earliest and latest score)
        $kpiProgress = [];
        $strongestGrowthStrings = [];

        if ($evaluations->count() > 0) {
            $firstEval = $evaluations->first();
            $latestEval = $evaluations->last();
            
            $allCriteria = \App\Models\AssessmentCriteria::all();

            foreach ($allCriteria as $c) {
                $initialScore = 0;
                $currentScore = 0;

                // Extract initial score
                if (is_array($firstEval->scores)) {
                    foreach ($firstEval->scores as $s) {
                        if ($s['criteria_id'] == $c->id) { $initialScore = $s['score']; break; }
                    }
                }

                // Extract current score
                if (is_array($latestEval->scores)) {
                    foreach ($latestEval->scores as $s) {
                        if ($s['criteria_id'] == $c->id) { $currentScore = $s['score']; break; }
                    }
                }

                $growth = $currentScore - $initialScore;

                $kpiProgress[] = [
                    'name' => $c->name,
                    'initial' => $initialScore,
                    'current' => $currentScore,
                    'growth' => $growth
                ];
            }

            // Sort descending by growth to highlight strongest fields
            usort($kpiProgress, fn($a, $b) => $b['growth'] <=> $a['growth']);
            
            // Take top 2 for the header subtitle string
            $growthHighlights = array_slice($kpiProgress, 0, 2);
            foreach ($growthHighlights as $g) {
                if ($g['growth'] > 0) {
                    $strongestGrowthStrings[] = $g['name'] . ' (+' . $g['growth'] . ' pts)';
                }
            }
        }

        $growthSummaryText = !empty($strongestGrowthStrings) 
            ? 'Strongest growth: ' . implode(', ', $strongestGrowthStrings) 
            : 'Consistent stability across assessment tracking blocks';

        return view('user.trend', compact('trendLabels', 'trendScores', 'teamAverageScores', 'kpiProgress', 'growthSummaryText', 'evaluations'));
    }

    public function feedback()
    {
        $user = Auth::user();
        
        // 1. Fetch chronological manager feedback logs
        $feedbacks = Evaluation::where('employee_id', $user->id)
            ->whereNotNull('notes')
            ->orderBy('period', 'desc')
            ->get();

        $latestEval = $feedbacks->first();

        // 2. Prepare dynamic improvement recommendations based on latest category scores
        $recommendations = [];
        if ($latestEval && is_array($latestEval->scores)) {
            $allCriteria = \App\Models\AssessmentCriteria::all();

            foreach ($latestEval->scores as $s) {
                $criterion = $allCriteria->firstWhere('id', $s['criteria_id']);
                if (!$criterion) continue;

                $score = $s['score'];
                $name = $criterion->name;

                // Generate contextual advice dynamically depending on the score tier
                if ($score < 79) {
                    $recommendations[] = [
                        'category' => $name,
                        'score' => $score,
                        'badge' => '',
                        'suggestion' => 'Practice leading team discussions. Join cross-division meetings to improve alignment.',
                        'style' => 'bg-emerald-50/40 border-slate-100', // Light teal row
                        'icon' => 'fa-comments text-emerald-500'
                    ];
                } elseif ($score >= 79 && $score <= 84) {
                    $recommendations[] = [
                        'category' => $name,
                        'score' => $score,
                        'badge' => '',
                        'suggestion' => 'Volunteer for cross-team projects to further build collaboration scores.',
                        'style' => 'bg-white border-slate-100', // Plain white row
                        'icon' => 'fa-handshake text-amber-500'
                    ];
                } else {
                    $recommendations[] = [
                        'category' => $name,
                        'score' => $score,
                        'badge' => ' — Keep it up!',
                        'suggestion' => 'Top performer in this category. Maintain this proactive approach.',
                        'style' => 'bg-emerald-50 border-emerald-200/60 ring-1 ring-emerald-500/5', // Highlighted row
                        'icon' => 'fa-star text-amber-400'
                    ];
                }
            }
        }

        return view('user.feedback', compact('feedbacks', 'latestEval', 'recommendations'));
    }

    public function exportPdf(Request $request)
    {
        $user = Auth::user();
        
        // Ambil periode yang dipilih atau default ke periode terbaru
        $periods = Evaluation::where('employee_id', $user->id)->orderBy('period', 'desc')->pluck('period');
        $selectedPeriod = $request->get('period', $periods->first() ?: date('Y') . '-Q1');

        // Ambil data evaluasi utama
        $evaluation = Evaluation::where('employee_id', $user->id)
            ->where('period', $selectedPeriod)
            ->first();

        if (!$evaluation) {
            return redirect()->back()->with('error', 'No evaluation record found to export.');
        }

        // Hitung rata-rata tim untuk pembanding di PDF
        $teamAverage = Evaluation::where('period', $selectedPeriod)->avg('final_score') ?: 0;

        // Susun struktur detail skor per KPI
        $criteria = AssessmentCriteria::all();
        $scoreVsAverage = [];

        foreach ($criteria as $c) {
            $userScore = 0;
            if (is_array($evaluation->scores)) {
                foreach ($evaluation->scores as $s) {
                    if ($s['criteria_id'] == $c->id) { $userScore = $s['score']; break; }
                }
            }

            // Hitung rata-rata kriteria di tim
            $allEvals = Evaluation::where('period', $selectedPeriod)->get();
            $totalCrit = 0; $countCrit = 0;
            foreach ($allEvals as $ev) {
                if (is_array($ev->scores)) {
                    foreach ($ev->scores as $s) {
                        if ($s['criteria_id'] == $c->id) { $totalCrit += $s['score']; $countCrit++; }
                    }
                }
            }
            $avgCrit = $countCrit > 0 ? ($totalCrit / $countCrit) : 0;

            $scoreVsAverage[] = [
                'name' => $c->name,
                'weight' => $c->weight,
                'user_score' => $userScore,
                'team_avg' => round($avgCrit, 1)
            ];
        }

        // Tentukan peringkat karyawan saat ini untuk menentukan badge status kelulusan di dokumen PDF
        $rankIndex = Evaluation::where('period', $selectedPeriod)
            ->orderBy('final_score', 'desc')
            ->pluck('employee_id')
            ->search($user->id);

        $isBonusEligible = ($rankIndex !== false && $rankIndex < 3);

        // Load view khusus PDF dan set ukuran kertas/orientasi ke A4 Portrait
        $pdf = Pdf::loadView('user.pdf_report', compact(
            'user', 'selectedPeriod', 'evaluation', 'teamAverage', 'scoreVsAverage', 'isBonusEligible'
        ))->setPaper('a4', 'portrait');

        // Unduh PDF otomatis dengan nama file teratur
        return $pdf->download("Performance_Report_{$user->name}_{$selectedPeriod}.pdf");
    }
}
