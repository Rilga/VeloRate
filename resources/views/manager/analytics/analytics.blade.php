<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="p-4 lg:p-8 text-slate-800">
        <div class="max-w-7xl mx-auto space-y-6">
            
            {{-- Main Header --}}
            <div class="mb-2">
                <h1 class="text-2xl font-black text-slate-900">Manager Analytics</h1>
                <p class="text-sm text-slate-500">Analyze real-time performance distributions, criteria category averages, and multi-period division trends.</p>
            </div>

            {{-- TOP ROW: KPI AVERAGES & SCORE DISTRIBUTION --}}
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                <div class="lg:col-span-7 bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex flex-col justify-between">
                    <div class="mb-4">
                        <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider">KPI Category Averages</h3>
                    </div>
                    <div class="h-52 relative">
                        <canvas id="kpiAveragesChart"></canvas>
                    </div>
                </div>

                <div class="lg:col-span-5 bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex flex-col justify-between">
                    <div class="mb-2">
                        <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider">Score Distribution</h3>
                    </div>
                    <div class="h-52 relative flex items-center justify-center">
                        <canvas id="scoreDistributionChart"></canvas>
                    </div>
                </div>
            </div>

            {{-- BOTTOM ROW: MULTI-PERIOD TREND BY DIVISION --}}
            <div class="w-full bg-white p-5 rounded-2xl border border-slate-100 shadow-sm">
                <div class="mb-4">
                    <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider">Multi-Period Trend By Division</h3>
                </div>
                <div class="h-64 relative">
                    <canvas id="multiPeriodTrendChart"></canvas>
                </div>
            </div>

        </div>
    </div>

    {{-- CHART.JS PRESENTATION ENGINE --}}
    <script>
        // 1. KPI Category Averages Chart Config
        const ctxKpi = document.getElementById('kpiAveragesChart').getContext('2d');
        new Chart(ctxKpi, {
            type: 'bar',
            data: {
                labels: {!! json_encode(array_keys($kpiCategoryAverages)) !!},
                datasets: [{
                    data: {!! json_encode(array_values($kpiCategoryAverages)) !!},
                    backgroundColor: '#1e293b', 
                    barThickness: 35,
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { min: 0, max: 100, ticks: { stepSize: 20, color: '#94a3b8', font: { size: 10 } }, grid: { color: '#f1f5f9' } },
                    x: { ticks: { color: '#64748b', font: { size: 10 } }, grid: { display: false } }
                }
            }
        });

        // 2. Score Distribution Doughnut Chart Config
        const ctxDist = document.getElementById('scoreDistributionChart').getContext('2d');
        new Chart(ctxDist, {
            type: 'doughnut',
            data: {
                labels: ['Bonus ({{ $distribution["bonus"] }})', 'Retain ({{ $distribution["retain"] }})', 'Warning ({{ $distribution["warning"] }})'],
                datasets: [{
                    data: [{{ $distribution['bonus'] }}, {{ $distribution['retain'] }}, {{ $distribution['warning'] }}],
                    backgroundColor: ['#10b981', '#1e293b', '#e11d48'], 
                    borderWidth: 4,
                    borderColor: '#ffffff',
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%', 
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { boxWidth: 10, padding: 15, font: { size: 11, weight: '600' }, color: '#334155', usePointStyle: true }
                    }
                }
            }
        });

        // 3. Multi-Period Trend By Division Multi-line Config
        const ctxTrend = document.getElementById('multiPeriodTrendChart').getContext('2d');
        const trendLabels = {!! json_encode($trendLabels) !!};
        const divisionTrends = {!! json_encode($divisionTrends) !!};
        
        // Generate warna acak atau tetap untuk tiap divisi secara dinamis
        const borderColors = ['#10b981', '#1e293b', '#b45309', '#64748b', '#e11d48', '#6366f1', '#a855f7'];

        const datasets = Object.keys(divisionTrends).map((divName, index) => {
            const chosenColor = borderColors[index % borderColors.length];
            return {
                label: divName,
                data: divisionTrends[divName],
                borderColor: chosenColor,
                borderWidth: index === 0 ? 2.5 : 1.5,
                borderDash: index === 0 ? [] : [4, 4], 
                tension: 0.1,
                fill: false,
                pointBackgroundColor: chosenColor,
                pointRadius: 3
            };
        });

        new Chart(ctxTrend, {
            type: 'line',
            data: { labels: trendLabels, datasets: datasets },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { 
                        display: true,
                        position: 'top',
                        labels: { boxWidth: 12, font: { size: 10, weight: '600' }, color: '#475569' }
                    }
                },
                scales: {
                    y: { 
                        min: 0, 
                        max: 100, 
                        ticks: { stepSize: 20, color: '#94a3b8', font: { size: 10 } }, 
                        grid: { color: '#f8fafc' } 
                    },
                    x: { ticks: { color: '#64748b', font: { size: 11 } }, grid: { display: false } }
                }
            }
        });
    </script>
</x-app-layout>