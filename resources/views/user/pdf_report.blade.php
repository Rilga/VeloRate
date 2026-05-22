<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Performance Evaluation Report</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #1e293b; padding: 20px; line-height: 1.5; }
        .header-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        .logo-title { font-size: 24px; font-weight: bold; color: #0f172a; margin: 0; }
        .subtitle { font-size: 11px; color: #64748b; text-transform: uppercase; tracking: 1px; margin-top: 5px; }
        .period-badge { background-color: #0f172a; color: #ffffff; padding: 6px 12px; font-size: 11px; font-weight: bold; border-radius: 6px; text-align: right; inline-block: true; }
        
        /* Profile Banner Styling */
        .hero-banner { background-color: #1e293b; color: #ffffff; padding: 24px; border-radius: 12px; margin-bottom: 30px; }
        .emp-name { font-size: 18px; font-weight: bold; margin: 0 0 5px 0; }
        .emp-details { font-size: 12px; color: #94a3b8; margin: 0 0 15px 0; }
        .badge-bonus { background-color: rgba(16, 185, 129, 0.15); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.3); padding: 4px 10px; border-radius: 6px; font-size: 10px; font-weight: bold; text-transform: uppercase; }
        .badge-retain { background-color: #334155; color: #cbd5e1; padding: 4px 10px; border-radius: 6px; font-size: 10px; font-weight: bold; text-transform: uppercase; }
        
        /* Stats Grid Simulation */
        .stats-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        .stat-card { background-color: #ffffff; border: 1px solid #e2e8f0; padding: 15px; border-radius: 12px; width: 48%; }
        .stat-label { font-size: 10px; font-weight: bold; color: #64748b; text-transform: uppercase; }
        .stat-value { font-size: 28px; font-weight: black; color: #0f172a; margin-top: 5px; }
        
        /* Matrix Table Style */
        .section-title { font-size: 12px; font-weight: bold; color: #475569; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 12px; border-left: 3px solid #10b981; padding-left: 8px; }
        .data-table { width: 100%; border-collapse: collapse; margin-bottom: 35px; }
        .data-table th { background-color: #f8fafc; border-bottom: 1px solid #e2e8f0; padding: 12px; font-size: 11px; font-weight: bold; color: #64748b; text-transform: uppercase; text-align: left; }
        .data-table td { padding: 12px; font-size: 12px; border-bottom: 1px solid #f1f5f9; color: #334155; }
        .score-box { font-weight: bold; color: #0f172a; background-color: #f1f5f9; padding: 4px 8px; border-radius: 6px; font-size: 11px; display: inline-block; text-align: center; width: 25px; }
        
        /* Feedback Container Style */
        .feedback-box { background-color: #f8fafc; border: 1px solid #e2e8f0; padding: 20px; border-radius: 12px; font-size: 13px; color: #334155; font-style: italic; line-height: 1.6; }
        .footer-note { text-align: center; font-size: 10px; color: #94a3b8; margin-top: 60px; border-t: 1px solid #e2e8f0; padding-top: 15px; text-transform: uppercase; letter-spacing: 1px; }
    </style>
</head>
<body>

    <table class="header-table">
        <tr>
            <td>
                <h1 class="logo-title">PerformPT</h1>
                <div class="subtitle">Official Performance Report Document</div>
            </td>
            <td style="text-align: right; vertical-align: middle;">
                <span class="period-badge">Evaluation Period: {{ $selectedPeriod }}</span>
            </td>
        </tr>
    </table>

    <div class="hero-banner">
        <h2 class="emp-name">{{ $user->name }}</h2>
        <p class="emp-details">{{ $user->division }} Division &bull; {{ $user->position }} Account Holder</p>
        <div>
            @if($isBonusEligible)
                <span class="badge-bonus">🎁 Bonus Eligible Standing</span>
            @else
                <span class="badge-retain">Retain Status Standard</span>
            @endif
        </div>
    </div>

    <table class="stats-table">
        <tr>
            <td class="stat-card" style="margin-right: 4%;">
                <div class="stat-label">Your Final Metrics Score</div>
                <div class="stat-value" style="color: #10b981;">{{ $evaluation->final_score }}</div>
            </td>
            <td class="stat-card">
                <div class="stat-label">Company Team Baseline Average</div>
                <div class="stat-value" style="color: #475569;">{{ round($teamAverage, 1) }}</div>
            </td>
        </tr>
    </table>

    <div class="section-title">KPI Evaluation Breakdown Matrix</div>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 45%;">Assessment Parameter</th>
                <th style="width: 15%;">Weight Quota</th>
                <th style="width: 20%;">Your Raw Score</th>
                <th style="width: 20%;">Team Average</th>
            </tr>
        </thead>
        <tbody>
            @foreach($scoreVsAverage as $row)
            <tr>
                <td style="font-weight: bold; color: #0f172a;">{{ $row['name'] }}</td>
                <td>{{ $row['weight'] }}%</td>
                <td><span class="score-box">{{ $row['user_score'] }}</span></td>
                <td style="color: #64748b; font-weight: 500;">{{ $row['team_avg'] }} / 100</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="section-title">Manager Remarks & Feedback Comments</div>
    <div class="feedback-box">
        @if($evaluation->notes)
            "{{ $evaluation->notes }}"
        @else
            "No formal narrative comments or custom improvement directions submitted by supervisors for this evaluation cycle block."
        @endif
    </div>

    <div class="footer-note">
        &copy; {{ date('Y') }} PT. XYZ &bull; CONFIDENTIAL PERFORMANCE DOSSIER &bull; GENERATED REAL-TIME
    </div>

</body>
</html>