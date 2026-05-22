<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="p-4 lg:p-8 text-slate-800">
        <div class="max-w-7xl mx-auto space-y-6">
            
            {{-- Main Header --}}
            <div class="mb-2">
                <h1 class="text-2xl font-black text-slate-900">Manager Dashboard</h1>
                <p class="text-sm text-slate-500">Monitor assessment metrics and analyze team performance achievements.</p>
            </div>

            {{-- 1. TOP STATS COUNTER BAR --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex flex-col justify-between">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Total Staff</span>
                    <h3 class="text-xl font-black text-slate-900 mt-1">{{ $totalEmployees }} <span class="text-xs text-slate-400 font-normal">People</span></h3>
                </div>
                <div class="bg-white p-4 rounded-2xl border border-l-4 border-l-emerald-500 border-slate-100 shadow-sm flex flex-col justify-between">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Superstar (>80)</span>
                    <h3 class="text-xl font-black text-emerald-600 mt-1">{{ $superstars }} <span class="text-xs text-slate-400 font-normal">People</span></h3>
                </div>
                <div class="bg-white p-4 rounded-2xl border border-l-4 border-l-slate-700 border-slate-100 shadow-sm flex flex-col justify-between">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Average (40-80)</span>
                    <h3 class="text-xl font-black text-slate-700 mt-1">{{ $averagePerform }} <span class="text-xs text-slate-400 font-normal">People</span></h3>
                </div>
                <div class="bg-white p-4 rounded-2xl border border-l-4 border-l-rose-500 border-slate-100 shadow-sm flex flex-col justify-between">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Underperform (<40)</span>
                    <h3 class="text-xl font-black text-rose-600 mt-1">{{ $underperform }} <span class="text-xs text-slate-400 font-normal">People</span></h3>
                </div>
            </div>

            {{-- 2. GRAPHICS ROW (Two Column Grid) --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm">
                    <div class="mb-4">
                        <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider">Performance Trend</h3>
                    </div>
                    <div class="h-48 relative">
                        <canvas id="perfTrendChart"></canvas>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm">
                    <div class="mb-4">
                        <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider">Division Comparison (<span class="text-emerald-500">{{ $selectedPeriod }}</span>)</h3>
                    </div>
                    <div class="h-48 relative">
                        <canvas id="divCompChart"></canvas>
                    </div>
                </div>
            </div>

            {{-- 3. EMPLOYEE RANKINGS SECTION (Full Width with Dynamic Filtering) --}}
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden" x-data="{ bonusFilter: 'all' }">
                <div class="p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-slate-50/40">
                    <div>
                        <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider">Employee Rankings</h3>
                    </div>
                    
                    {{-- Search & Period Filter Group --}}
                    <div class="flex flex-wrap items-center gap-3">
                        <select x-model="bonusFilter" class="px-3 py-1.5 bg-white border border-slate-200 rounded-xl text-xs font-semibold text-slate-600 focus:border-[#10b981]">
                            <option value="all">All Employees</option>
                            <option value="bonus">🎁 Bonus Recipients Only (Top 3)</option>
                        </select>

                        <form method="GET" action="{{ route('manager.dashboard') }}" id="periodDashboardForm">
                            @php $y = date('Y'); @endphp
                            <select name="period" onchange="document.getElementById('periodDashboardForm').submit()"
                                    class="px-3 py-1.5 bg-slate-950 text-white border-0 rounded-xl text-xs font-bold cursor-pointer focus:ring-0">
                                <option value="{{ $y }}-Q1" {{ $selectedPeriod == "$y-Q1" ? 'selected' : '' }}>{{ $y }} — Q1</option>
                                <option value="{{ $y }}-Q2" {{ $selectedPeriod == "$y-Q2" ? 'selected' : '' }}>{{ $y }} — Q2</option>
                                <option value="{{ $y }}-Q3" {{ $selectedPeriod == "$y-Q3" ? 'selected' : '' }}>{{ $y }} — Q3</option>
                                <option value="{{ $y }}-Q4" {{ $selectedPeriod == "$y-Q4" ? 'selected' : '' }}>{{ $y }} — Q4</option>
                            </select>
                        </form>
                    </div>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="bg-slate-50/50 border-b border-slate-100 text-slate-400 font-bold uppercase tracking-wider">
                                <th class="px-6 py-4 w-12 text-center">#</th>
                                <th class="px-6 py-4">Employee</th>
                                <th class="px-6 py-4">Division</th>
                                <th class="px-6 py-4 text-center">Score</th>
                                <th class="px-6 py-4 w-1/4">Progress</th>
                                <th class="px-6 py-4 text-center">Status</th>
                                <th class="px-6 py-4 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50 font-medium text-slate-700">
                            @forelse($rankings as $index => $rank)
                            @php 
                                // Only top 3 index ranks (0, 1, 2) qualify for the bonus incentive
                                $isBonusWinner = $index < 3; 
                            @endphp
                            <tr class="hover:bg-slate-50/40 transition-colors" 
                                x-show="bonusFilter === 'all' || (bonusFilter === 'bonus' && {{ $isBonusWinner ? 'true' : 'false' }})">
                                <td class="px-6 py-4 text-center font-bold {{ $isBonusWinner ? 'text-amber-500 text-sm' : 'text-slate-400' }}">
                                    @if($index == 0) 🥇 @elseif($index == 1) 🥈 @elseif($index == 2) 🥉 @else {{ $index + 1 }} @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="h-8 w-8 rounded-full font-bold text-[11px] flex items-center justify-center border uppercase
                                            {{ $isBonusWinner ? 'bg-amber-50 text-amber-600 border-amber-200' : 'bg-slate-50 text-slate-500 border-slate-200' }}">
                                            {{ substr($rank->name, 0, 2) }}
                                        </div>
                                        <div>
                                            <p class="font-bold text-slate-900">{{ $rank->name }}</p>
                                            <p class="text-[10px] text-slate-400 font-normal">{{ $rank->position }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-slate-500">{{ $rank->division }}</td>
                                <td class="px-6 py-4 text-center font-black text-sm text-slate-900">{{ $rank->final_score }}</td>
                                <td class="px-6 py-4">
                                    <div class="w-full bg-slate-100 h-1.5 rounded-full overflow-hidden">
                                        <div class="h-full rounded-full {{ $isBonusWinner ? 'bg-gradient-to-r from-amber-400 to-[#10b981]' : 'bg-slate-800' }}" 
                                             style="width: {{ $rank->final_score }}%"></div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($isBonusWinner)
                                        <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 border border-emerald-100 rounded-md text-[10px] font-black tracking-wide uppercase">
                                            🎁 Bonus Eligible
                                        </span>
                                    @else
                                        <span class="px-2.5 py-1 bg-slate-50 text-slate-500 border border-slate-200 rounded-md text-[10px] font-bold">
                                            Retain
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="#" class="inline-flex items-center justify-center border border-slate-200 bg-white hover:bg-slate-50 px-3 py-1.5 rounded-xl font-bold text-[11px] text-slate-600 shadow-sm transition-all">
                                        View
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-slate-400 italic">No evaluation data available for the period {{ $selectedPeriod }}.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    {{-- CHART.JS VISUALIZATION CONFIGURATIONS --}}
    <script>
        // 1. Line Chart: Performance Trend (Y-Axis scaled dynamically to 100)
        const ctxTrend = document.getElementById('perfTrendChart').getContext('2d');
        new Chart(ctxTrend, {
            type: 'line',
            data: {
                labels: {!! json_encode($trendLabels) !!},
                datasets: [{
                    data: {!! json_encode($trendData) !!},
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16, 185, 129, 0.02)',
                    borderWidth: 2.5,
                    tension: 0.1,
                    fill: true,
                    pointBackgroundColor: '#10b981',
                    pointRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { 
                        min: 0,
                        max: 100,
                        ticks: { stepSize: 20 }, 
                        grid: { color: '#f8fafc' } 
                    },
                    x: { grid: { display: false } }
                }
            }
        });

        // 2. Bar Chart: Division Comparison
        const ctxDiv = document.getElementById('divCompChart').getContext('2d');
        const divisionScores = {!! json_encode($divisionData) !!};
        const barColors = divisionScores.map((score, idx) => {
            if (idx < 3 && score > 70) return '#10b981'; // Emerald Green
            if (score < 40) return '#e11d48'; // Rose Red
            return '#1e293b'; // Dark Navy
        });

        new Chart(ctxDiv, {
            type: 'bar',
            data: {
                labels: {!! json_encode($divisionLabels) !!},
                datasets: [{
                    data: divisionScores,
                    backgroundColor: barColors,
                    barThickness: 40,
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { min: 0, max: 100, ticks: { stepSize: 20 }, grid: { color: '#f8fafc' } },
                    x: { grid: { display: false } }
                }
            }
        });
    </script>
</x-app-layout>