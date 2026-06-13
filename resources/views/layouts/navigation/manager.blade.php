<!-- Wrapper Utama Sidebar Manager -->
<div x-data="{ open: false }">
    
    <!-- SUNTIKAN CSS MURNI: Mengunci warna terang yang pekat, aktif merah, dan efek hover signout merah murni -->
    <style>
        .iai-bg-light-sidebar { 
            background-color: #e2e8f0 !important; 
        }
        .iai-border-light {
            border-color: #cbd5e1 !important;
        }
        .iai-menu-active { 
            background-color: #D1232A !important; 
            color: white !important;
            box-shadow: 0 10px 15px -3px rgba(209, 35, 42, 0.2) !important;
        }
        .iai-text-dark-menu {
            color: #334155 !important;
        }
        .iai-text-dark-menu:hover {
            background-color: rgba(15, 23, 42, 0.08) !important;
            color: #0f172a !important;
        }
        /* Mengunci efek hover tombol Sign Out agar pasti berwarna Merah IAI */
        .iai-btn-signout {
            background-color: #cbd5e1 !important;
            color: #1e293b !important;
            border-color: #94a3b8 !important;
            transition: all 0.2s ease-in-out;
        }
        .iai-btn-signout:hover {
            background-color: #D1232A !important;
            color: #ffffff !important;
            border-color: #b01b21 !important;
        }
    </style>
    
    <!-- 1. DESKTOP SIDEBAR -->
    <nav class="iai-bg-light-sidebar iai-border-light border-r fixed left-0 top-0 h-screen w-64 flex flex-col justify-between z-50 hidden lg:flex">
        
        <div>
            <!-- Header Area (Logo & Brand) -->
            <div class="flex items-center gap-3 px-6 h-24">
                <div class="flex items-center justify-center overflow-hidden rounded-lg">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo PerformPT" class="w-16 h-16 object-contain">
                </div>
                <div>
                    <h1 class="text-[#0f172a] font-bold text-lg leading-none tracking-tight">IAI JAKARTA</h1>
                    <p class="font-bold text-[10px] mt-1 uppercase tracking-wider" style="color: #D1232A;">Manager</p>
                </div>
            </div>

            <!-- Menu Links (Manager Specific) -->
            <div class="px-4 py-4">
                <p class="text-slate-500 text-[10px] uppercase tracking-[0.2em] font-bold px-4 mb-4">Manager Menu</p>
                
                <div class="space-y-2">
                    <!-- Dashboard -->
                    <a href="{{ route('manager.dashboard') }}" 
                        class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('manager.dashboard') ? 'iai-menu-active' : 'iai-text-dark-menu' }}">
                        <i class="fas fa-th-large w-5 text-center"></i>
                        <span class="text-sm font-semibold">Dashboard</span>
                    </a>

                    <!-- Evaluation -->
                    <a href="{{ route('evaluations.index') }}" 
                        class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->is('evaluations*') ? 'iai-menu-active' : 'iai-text-dark-menu' }}">
                        <i class="fas fa-clipboard-check w-5 text-center"></i>
                        <span class="text-sm font-semibold">Evaluation</span>
                    </a>

                    <!-- Ranking -->
                    <a href="{{ route('analytics.index') }}" 
                        class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->is('analytics*') ? 'iai-menu-active' : 'iai-text-dark-menu' }}">
                        <i class="fas fa-chart-line w-5 text-center"></i>
                        <span class="text-sm font-semibold">Analytics</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Bagian Bawah: Profil Manager & Sign Out -->
        <div class="p-4 bg-slate-300/60 iai-border-light border-t">
            <div class="flex items-center gap-3 px-2 mb-4">
                <!-- Avatar Inisial -->
                <div class="h-10 w-10 shrink-0 rounded-full flex items-center justify-center text-white font-bold text-xs border-2 border-white shadow-inner" style="background-color: #D1232A;">
                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                </div>
                <div class="flex-1 overflow-hidden text-left">
                    <p class="text-[#0f172a] text-sm font-bold truncate leading-tight">{{ Auth::user()->name }}</p>
                    <p class="font-bold text-[9px] uppercase mt-0.5" style="color: #D1232A;">Manager</p>
                </div>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="iai-btn-signout w-full py-2.5 rounded-lg text-xs font-bold border uppercase tracking-widest">
                    Sign out
                </button>
            </form>
        </div>
    </nav>

    <!-- 2. MOBILE HEADER -->
    <div class="lg:hidden fixed top-0 left-0 w-full iai-bg-light-sidebar iai-border-light border-b z-[60] h-16 flex items-center justify-between px-4">
        <div class="flex items-center gap-3">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-12 h-12 object-contain">
            <span class="font-bold text-[#0f172a] tracking-tight">IAI JAKARTA</span>
        </div>
        
        <!-- Hamburger Button -->
        <button @click="open = !open" 
                class="p-2 focus:outline-none"
                style="color: #0f172a !important;">
            <i class="fas fa-bars text-xl" x-show="!open" style="display: block;"></i>
            <i class="fas fa-times text-xl" x-show="open" x-cloak style="display: block;"></i>
        </button>
    </div>

    <!-- 3. MOBILE SIDEBAR OVERLAY (Off-canvas) -->
    <div x-show="open" 
         x-cloak
         class="fixed inset-0 z-[70] lg:hidden" 
         style="display: none;">
        
        <div class="fixed inset-0 bg-black/40 backdrop-blur-sm" @click="open = false"></div>

        <div x-show="open"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="-translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in duration-200 transform"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="-translate-x-full"
             class="fixed inset-y-0 left-0 w-64 iai-bg-light-sidebar shadow-2xl flex flex-col justify-between">
            
            <div class="flex flex-col h-full">
                <div class="px-6 h-16 flex items-center border-b border-slate-300 bg-slate-300/40">
                    <span class="text-[#0f172a] font-bold uppercase tracking-widest text-xs">Manager Menu</span>
                </div>

                <div class="flex-1 overflow-y-auto px-4 py-6 space-y-2">
                    <a href="{{ route('manager.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('manager.dashboard') ? 'iai-menu-active' : 'iai-text-dark-menu' }}">
                        <i class="fas fa-th-large w-5 text-center"></i>
                        <span class="text-sm font-semibold">Dashboard</span>
                    </a>
                    <a href="{{ route('evaluations.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->is('evaluations*') ? 'iai-menu-active' : 'iai-text-dark-menu' }}">
                        <i class="fas fa-clipboard-check w-5 text-center"></i>
                        <span class="text-sm font-semibold">Evaluation</span>
                    </a>
                    <a href="{{ route('analytics.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->is('analytics*') ? 'iai-menu-active' : 'iai-text-dark-menu' }}">
                        <i class="fas fa-chart-line w-5 text-center"></i>
                        <span class="text-sm font-semibold">Analytics</span>
                    </a>
                </div>

                <div class="p-4 bg-slate-300/50 border-t border-slate-300">
                    <div class="flex items-center gap-3 px-2 mb-4">
                        <div class="h-10 w-10 shrink-0 rounded-full flex items-center justify-center text-white font-bold text-xs border-2 border-white/10" style="background-color: #D1232A;">
                            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                        </div>
                        <div class="flex-1 overflow-hidden text-left">
                            <p class="text-[#0f172a] text-sm font-bold truncate">{{ Auth::user()->name }}</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="iai-btn-signout w-full py-2.5 rounded-lg text-xs font-bold border">
                            Sign out
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>