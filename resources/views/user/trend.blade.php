<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="p-4 lg:p-8 text-slate-800">
        <div class="max-w-7xl mx-auto space-y-6">
            
            {{-- Main Top Header --}}
            <div class="mb-2">
                <h1 class="text-xl font-bold text-slate-900">Performance Trend</h1>
                <p class="text-xs text-slate-400">My score history across evaluation periods</p>
            </div>

            {{-- 1. FULL-WIDTH SCORE TIMELINE PANEL --}}
            <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm">
                <div class="mb-4">
                    <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider">Score Timeline</h3>
                </div>
                <div class="h-60 relative">
                    @if(empty($trendLabels))
                        <div class="absolute inset-0 flex items-center justify-center text-xs text-slate-400 italic">No historical data records yet.</div>
                    @else
                        <canvas id="scoreTimelineChart"></canvas>
                    @endif
                </div>
            </div>

            {{-- 2. LOWER BLOCK: KPI PROGRESS & PERIOD COMPARISON --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                
                {{-- Left Container: KPI Progress Over Time Bars --}}
                <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex flex-col justify-between">
                    <div class="mb-5">
                        <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider">KPI Progress Over Time</h3>
                        <p class="text-[11px] text-slate-400 mt-1 font-medium">{{ $growthSummaryText }}</p>
                    </div>
                    
                    <div class="space-y-4 grow justify-center flex flex-col">
                        @forelse(array_slice($kpiProgress, 0, 4) as $kpi) {{-- Showing top 4 KPIs like the image --}}
                            <div class="flex items-center text-xs text-slate-600 font-medium">
                                <span class="w-28 font-semibold truncate text-left">{{ $kpi['name'] }}</span>
                                <span class="w-8 text-center text-slate-400 text-[11px]">{{ $kpi['initial'] }}</span>
                                
                                {{-- Elegant Emerald Performance Metric Bar --}}
                                <div class="flex-1 bg-slate-50 h-1.5 rounded-full overflow-hidden mx-2 border border-slate-100">
                                    <div class="h-full bg-[#10b981] rounded-full" style="width: {{ $kpi['current'] }}%"></div>
                                </div>
                                
                                <span class="w-6 text-right font-bold text-slate-900">{{ $kpi['current'] }}</span>
                                <span class="w-8 text-right text-[10px] {{ $kpi['growth'] >= 0 ? 'text-emerald-500' : 'text-rose-500' }} font-bold ml-1">
                                    {{ $kpi['growth'] >= 0 ? '+'.$kpi['growth'] : $kpi['growth'] }}
                                </span>
                            </div>
                        @empty
                            <p class="text-xs text-slate-400 text-center py-6 italic">No evaluation breakdowns available.</p>
                        @endforelse
                    </div>
                </div>

                {{-- Right Container: Period Comparison Clean Matrix Table --}}
                <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm overflow-hidden flex flex-col justify-between">
                    <div class="mb-4">
                        <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider">Period Comparison</h3>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse text-xs">
                            <thead>
                                <tr class="border-b border-slate-100 text-slate-400 font-bold uppercase tracking-wider">
                                    <th class="py-3 font-medium">Period</th>
                                    <th class="py-3 text-center font-medium">Score</th>
                                    <th class="py-3 text-center font-medium">Change</th>
                                    <th class="py-3 text-right font-medium">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50 font-medium text-slate-700">
                                @foreach($evaluations as $index => $eval)
                                <tr class="hover:bg-slate-50/40 transition-colors">
                                    <td class="py-3.5 text-slate-600 font-bold">{{ $eval->period }}</td>
                                    <td class="py-3.5 text-center font-bold text-slate-900">{{ $eval->final_score }}</td>
                                    <td class="py-3.5 text-center font-semibold">
                                        @if($index === 0)
                                            <span class="text-slate-300">—</span>
                                        @else
                                            @php 
                                                $prevScore = $evaluations[$index - 1]->final_score;
                                                $change = $eval->final_score - $prevScore;
                                            @endphp
                                            <span class="{{ $change >= 0 ? 'text-emerald-500' : 'text-rose-500' }}">
                                                {!! $change >= 0 ? '↑ +'.$change : '↓ '.$change !!}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-3.5 text-right">
                                        @if($eval->final_score >= 80)
                                            <span class="px-2 py-0.5 bg-emerald-50 text-emerald-700 border border-emerald-100 rounded-md text-[10px] font-bold">Bonus</span>
                                        @else
                                            <span class="px-2 py-0.5 bg-slate-50 text-slate-600 border border-slate-200 rounded-md text-[10px] font-bold">Retain</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>
    </div>

    @if(!empty($trendLabels))
    <script>
        const ctxTimeline = document.getElementById('scoreTimelineChart').getContext('2d');
        
        new Chart(ctxTimeline, {
            type: 'line',
            data: {
                labels: {!! json_encode($trendLabels) !!},
                datasets: [
                    {
                        // 1. Solid green upper line representation (Your Actual Score)
                        label: 'My Score',
                        data: {!! json_encode($trendScores) !!},
                        borderColor: '#10b981',
                        backgroundColor: 'rgba(16, 185, 129, 0.04)',
                        borderWidth: 2.5,
                        tension: 0.1,
                        fill: true,
                        pointBackgroundColor: '#10b981',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 1.5,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    },
                    {
                        // 2. Gray dotted lower baseline line representation (Team Averages)
                        label: 'Team Average',
                        data: {!! json_encode($teamAverageScores) !!},
                        borderColor: '#94a3b8',
                        borderWidth: 1.5,
                        borderDash: [3, 3], // Renders the exact custom crisp dash pattern
                        tension: 0.1,
                        fill: false,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#94a3b8',
                        pointBorderWidth: 1.5,
                        pointRadius: 3,
                        pointHoverRadius: 4
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } }, // Cleared for direct minimal representation matching picture layout
                scales: {
                    y: { 
                        min: 55, 
                        max: 95, 
                        ticks: { stepSize: 5, color: '#94a3b8', font: { size: 10 } }, 
                        grid: { color: '#f1f5f9' } 
                    },
                    x: { 
                        ticks: { color: '#64748b', font: { size: 10, weight: '500' } }, 
                        grid: { display: false } 
                    }
                }
            }
        });
    </script>
    @endif
</x-app-layout>