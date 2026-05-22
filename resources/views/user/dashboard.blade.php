<x-app-layout>
    {{-- Mengaktifkan Chart.js via CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="p-4 lg:p-8 text-slate-800">
        <div class="max-w-7xl mx-auto space-y-6">
            
            {{-- HEADER & FORM ACTIONS ROW --}}
            <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4">
                <div>
                    <h1 class="text-xl font-bold text-slate-900">My Performance</h1>
                    <p class="text-xs text-slate-400">Personal KPI scores and evaluation history</p>
                </div>
                
                {{-- Actions Container: Tempat Tombol Export & Dropdown Filter --}}
                <div class="flex items-center gap-3 self-start sm:self-auto">
                    
                    {{-- Tombol Export PDF (Hanya muncul jika data evaluasi pada periode tersebut ada) --}}
                    @if($evaluation)
                        <a href="{{ route('export.pdf', ['period' => $selectedPeriod]) }}" 
                           class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold transition-all shadow-md shadow-emerald-600/10 active:scale-[0.98]">
                            <i class="fas fa-file-pdf"></i> Export PDF
                        </a>
                    @endif

                    {{-- Dropdown Filter Periode Evaluasi --}}
                    <form method="GET" action="{{ route('user.dashboard') }}" id="periodForm">
                        <select name="period" onchange="document.getElementById('periodForm').submit()"
                                class="px-3 py-1.5 bg-white border border-slate-200 rounded-xl text-xs font-bold text-slate-700 shadow-sm focus:border-slate-400 focus:ring-0 cursor-pointer">
                            @forelse($periods as $p)
                                <option value="{{ $p }}" {{ $selectedPeriod == $p ? 'selected' : '' }}>{{ $p }}</option>
                            @empty
                                <option value="">No Active Periods</option>
                            @endforelse
                        </select>
                    </form>
                </div>
            </div>

            {{-- JIKA DATA EVALUASI BELUM TERSEDIA --}}
            @if(!$evaluation)
                <div class="bg-white p-12 text-center rounded-2xl border border-slate-100 shadow-sm text-slate-400">
                    <i class="fas fa-folder-open text-3xl mb-2 text-slate-200 block"></i>
                    <p class="font-medium text-xs">No evaluation record found for the period {{ $selectedPeriod }}.</p>
                </div>
            @else
                
                {{-- 1. HERO BANNER NAVY DENGAN METRIC LINGKARAN (CIRCULAR METER) --}}
                <div class="bg-[#1e293b] p-6 rounded-2xl border border-slate-800 shadow-sm flex items-center gap-6 text-white relative overflow-hidden">
                    
                    {{-- Sisi Kiri: SVG Radial Circular Progress Score --}}
                    <div class="relative h-20 w-20 flex-shrink-0 flex items-center justify-center">
                        <svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
                            <path class="text-slate-700" stroke-width="2.5" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                            <path class="text-[#10b981]" stroke-dasharray="{{ $evaluation->final_score }}, 100" stroke-width="2.5" stroke-linecap="round" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                        </svg>
                        <div class="absolute flex flex-col items-center justify-center text-center">
                            <span class="text-xl font-black tracking-tight">{{ $evaluation->final_score }}</span>
                            <span class="text-[8px] font-bold uppercase text-slate-400 tracking-wider">Score</span>
                        </div>
                    </div>

                    {{-- Sisi Kanan: Blok Identitas & Badge Kelulusan --}}
                    <div class="space-y-2 text-left">
                        <div>
                            <h2 class="text-base font-bold tracking-tight">{{ $user->name }}</h2>
                            <p class="text-xs text-slate-400 font-medium">{{ $user->division }} Division • {{ $user->position }}</p>
                        </div>
                        
                        <div>
                            {{-- Aturan Bisnis: Status Bonus Valid Jika Akun Masuk Kedalam Top 3 Teratas Manajer --}}
                            @if($rankIndex !== false && $rankIndex < 3)
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-500/10 text-[#10b981] border border-emerald-500/20 font-bold rounded-lg text-[10px] tracking-wide uppercase">
                                    🎁 Bonus Eligible
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-slate-700 text-slate-300 font-bold rounded-lg text-[10px] tracking-wide uppercase">
                                    Retain
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- 2. LOWER DATA COLUMNS (Layout Kolom Berdampingan Berdasarkan Gambar) --}}
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    
                    {{-- Sisi Kiri: Garis Progress Bar Horizontal per Nilai KPI --}}
                    <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex flex-col justify-between">
                        <div class="mb-4">
                            <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider">My KPI Scores — {{ $selectedPeriod }}</h3>
                        </div>
                        
                        <div class="space-y-3.5">
                            @foreach($scoreVsAverage as $row)
                                <div class="flex items-center justify-between text-xs gap-4">
                                    <span class="w-24 text-slate-600 font-bold text-left truncate">{{ $row['name'] }}</span>
                                    
                                    {{-- Jalur Track Progress Bar Kustom --}}
                                    <div class="flex-1 bg-slate-50 h-1.5 rounded-full overflow-hidden border border-slate-100/50">
                                        {{-- Warna hijau jika nilai melampaui rata-rata tim, warna navy jika sebaliknya --}}
                                        <div class="h-full rounded-full {{ $row['user_score'] >= $row['team_avg'] ? 'bg-[#10b981]' : 'bg-slate-800' }}" 
                                             style="width: {{ $row['user_score'] }}%"></div>
                                    </div>
                                    
                                    <span class="w-6 text-right font-black text-slate-900">{{ $row['user_score'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Sisi Kanan: Grafik Batang Ganda Pembanding (Score vs Team Average) --}}
                    <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex flex-col justify-between">
                        <div class="mb-4">
                            <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider">Score vs Team Average</h3>
                        </div>
                        <div class="h-56 relative">
                            <canvas id="scoreVsAverageChart"></canvas>
                        </div>
                    </div>

                </div>
            @endif

        </div>
    </div>

    {{-- CONFIG ENGINE CHART.JS --}}
    @if($evaluation)
    <script>
        const ctxSva = document.getElementById('scoreVsAverageChart').getContext('2d');
        const chartData = {!! json_encode($scoreVsAverage) !!};

        new Chart(ctxSva, {
            type: 'bar',
            data: {
                // Label dipotong 5 huruf saja ('Produ', 'Quali') agar presisi meniru visual gambar mockup
                labels: chartData.map(r => r.name.substring(0, 5)), 
                datasets: [
                    {
                        label: 'Your Score',
                        data: chartData.map(r => r.user_score),
                        backgroundColor: '#1e293b', // Warna Hitam/Navy Tua
                        borderRadius: 4,
                        barThickness: 18
                    },
                    {
                        label: 'Team Average',
                        data: chartData.map(r => r.team_avg),
                        backgroundColor: '#10b981', // Warna Hijau Emerald
                        borderRadius: 4,
                        barThickness: 18
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false } // Legend disembunyikan agar bersih dan rapi
                },
                scales: {
                    y: { 
                        min: 0, 
                        max: 100, 
                        ticks: { stepSize: 20, color: '#94a3b8', font: { size: 10 } }, 
                        grid: { color: '#f8fafc' } 
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