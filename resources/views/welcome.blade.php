<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Employee Performance System</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
            <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
            <style>
                :root {
                    --brand-navy: #1e293b; 
                    --brand-navy-light: #334155;
                }
                [x-cloak] { display: none !important; }
            </style>
        @endif
    </head>
    <body class="bg-[#F8FAFC] text-[#1e293b] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col font-sans" x-data="{ open: false }">
        
        <header class="w-full lg:max-w-4xl max-w-[335px] text-sm mb-6 relative">
            @if (Route::has('login'))
                <nav class="flex items-center justify-between lg:justify-end">
                    <div class="lg:hidden font-bold text-[#1e293b] tracking-tight">
                        EPS Dashboard
                    </div>

                    <div class="lg:hidden">
                        <button @click="open = !open" class="p-2 text-[#1e293b] focus:outline-none">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                                <path x-show="open" x-cloak stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="hidden lg:flex items-center gap-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="inline-block px-5 py-1.5 text-[#1e293b] border-[#1e293b]/20 hover:border-[#1e293b] border rounded-md text-sm font-medium transition-all">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="inline-block px-5 py-1.5 bg-[#1e293b] rounded-md text text-white font-medium transition-all">
                                Log in
                            </a>
                        @endauth
                    </div>
                </nav>

                <div x-show="open" 
                     x-cloak
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     class="absolute top-full left-0 right-0 mt-2 p-4 bg-white shadow-xl rounded-lg border border-slate-100 lg:hidden z-50">
                    <div class="flex flex-col gap-3">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="block px-4 py-2 text-center text-[#1e293b] font-medium border border-slate-200 rounded-md">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="block px-4 py-2 text-center bg-[#1e293b] text-white rounded-md font-medium">Log in</a>
                        @endauth
                    </div>
                </div>
            @endif
        </header>

        <div class="flex items-center justify-center w-full transition-opacity opacity-100 duration-750 lg:grow">
            <main class="flex max-w-[335px] w-full flex-col-reverse lg:max-w-4xl lg:flex-row shadow-2xl rounded-xl overflow-hidden border border-[#1e293b]/10 bg-white">
                <div class="flex-1 p-8 pb-12 lg:p-16 bg-white text-[#1e293b]">
                    <div class="mb-8">
                        <span class="px-3 py-1 rounded-full bg-[#1e293b]/5 text-[#1e293b] font-semibold text-[10px] uppercase tracking-[0.1em]">Management Suite</span>
                    </div>
                    
                    <h1 class="mb-3 text-3xl font-bold tracking-tight">Employee <span class="text-[#1e293b]/70 font-light">Performance</span></h1>
                    <p class="mb-8 text-slate-500 leading-relaxed text-sm lg:text-base">
                        Optimize your team's productivity with a criteria-based evaluation system that is transparent, accurate, and real-time.
                    </p>

                    <div class="grid grid-cols-1 gap-6 mb-10">
                        <div class="flex items-start gap-4">
                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-[#1e293b]/5 text-[#1e293b]">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04M12 10.122V21m0-10.878a7.44 7.44 0 00-7.5 7.5M12 10.122a7.44 7.44 0 017.5 7.5" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-sm">Centralized Evaluation Workflow</h3>
                                <p class="text-xs text-slate-400 mt-1">Seamless synchronization of evaluation criteria, manager assessments, and employee reports.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-[#1e293b]/5 text-[#1e293b]">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-sm">Performance Analytics</h3>
                                <p class="text-xs text-slate-400 mt-1">Interactive KPI tracking dashboards with historical and periodic performance trends.</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('login') }}" class="w-full lg:w-auto px-8 py-3 bg-[#1e293b] text-white rounded-lg font-semibold hover:bg-[#334155] transition-all shadow-lg shadow-[#1e293b]/20 text-center">
                            Access the System
                        </a>
                    </div>
                </div>

                <div class="bg-[#1e293b] relative w-full lg:w-[380px] shrink-0 flex items-center justify-center p-12 overflow-hidden min-h-[240px] lg:min-h-full">
                    <div class="absolute w-64 h-64 border border-white/10 rounded-full -top-20 -right-20"></div>
                    <div class="absolute w-40 h-40 border border-white/5 rounded-full bottom-10 -left-10"></div>
                    
                    <div class="relative z-10 text-center">
                        <div class="mx-auto mb-6 flex h-20 w-20 items-center justify-center rounded-2xl bg-white/10 backdrop-blur-sm border border-white/20">
                            <svg class="h-10 w-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <h2 class="text-white font-medium tracking-wide">Evaluation Portal</h2>
                        <div class="mt-4 flex gap-1 justify-center">
                            <div class="h-1 w-8 bg-white/40 rounded-full"></div>
                            <div class="h-1 w-4 bg-white/20 rounded-full"></div>
                        </div>
                    </div>
                </div>
            </main>
        </div>

        <footer class="py-8 text-center text-slate-400 text-[10px] lg:text-[11px] font-medium tracking-widest uppercase mt-auto">
            &copy; {{ date('Y') }} PT. XYZ &bull; PERFORMANCE DASHBOARD
        </footer>
    </body>
</html>