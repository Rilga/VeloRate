<!-- Wrapper Utama Sidebar Manager -->
<div x-data="{ open: false }">
    
    <!-- 1. DESKTOP SIDEBAR -->
    <nav class="bg-[#1e293b] border-r border-white/10 fixed left-0 top-0 h-screen w-64 flex flex-col justify-between z-50 hidden lg:flex">
        
        <div>
            <!-- Header Area (Logo & Brand) -->
            <div class="flex items-center gap-3 px-6 h-24">
                <div class="flex items-center justify-center overflow-hidden rounded-lg">
                    <img src="{{ asset('images/logo2.png') }}" alt="Logo PerformPT" class="w-10 h-10 object-contain">
                </div>
                <div>
                    <h1 class="text-white font-bold text-lg leading-none tracking-tight">PerformPT</h1>
                    <p class="text-emerald-400 text-[10px] mt-1 font-medium uppercase tracking-wider">Manager</p>
                </div>
            </div>

            <!-- Menu Links (Manager Specific) -->
            <div class="px-4 py-4">
                <p class="text-gray-500 text-[10px] uppercase tracking-[0.2em] font-bold px-4 mb-4">Manager Menu</p>
                
                <div class="space-y-2">
                    <!-- Dashboard -->
                    <a href="{{ route('manager.dashboard') }}" 
                        class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('manager.dashboard') ? 'bg-[#10b981] text-white shadow-lg shadow-emerald-500/20' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                        <i class="fas fa-th-large w-5 text-center"></i>
                        <span class="text-sm font-semibold">Dashboard</span>
                    </a>

                    <!-- Evaluation -->
                    <a href="{{ route('evaluations.index') }}" 
                        class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->is('evaluations*') ? 'bg-[#10b981] text-white shadow-lg shadow-emerald-500/20' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                        <i class="fas fa-clipboard-check w-5 text-center"></i>
                        <span class="text-sm font-semibold">Evaluation</span>
                    </a>

                    <!-- Ranking -->
                    <a href="{{ route('analytics.index') }}" 
                        class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->is('analytics*') ? 'bg-[#10b981] text-white shadow-lg shadow-emerald-500/20' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                        <i class="fas fa-chart-line w-5 text-center"></i>
                        <span class="text-sm font-semibold">Analytics</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Bagian Bawah: Profil Manager & Sign Out -->
        <div class="p-4 bg-black/10 border-t border-white/5">
            <div class="flex items-center gap-3 px-2 mb-4">
                <!-- Avatar Inisial (Warna Navy menyesuaikan brand) -->
                <div class="h-10 w-10 shrink-0 rounded-full bg-[#10b981] flex items-center justify-center text-white font-bold text-xs border-2 border-white/10 shadow-inner">
                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                </div>
                <div class="flex-1 overflow-hidden text-left">
                    <p class="text-white text-sm font-bold truncate leading-tight">{{ Auth::user()->name }}</p>
                    <p class="text-emerald-500 text-[9px] font-bold uppercase mt-0.5">Manager</p>
                </div>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full py-2.5 rounded-lg bg-white/5 text-gray-300 text-xs font-bold border border-white/5 uppercase tracking-widest hover:bg-red-500/10 hover:text-red-400 transition-all">
                    Sign out
                </button>
            </form>
        </div>
    </nav>

    <!-- 2. MOBILE HEADER (Sama persis dengan Admin untuk konsistensi) -->
    <div class="lg:hidden fixed top-0 left-0 w-full bg-[#1e293b] border-b border-white/10 z-[60] h-16 flex items-center justify-between px-4">
        <div class="flex items-center gap-3">
            <img src="{{ asset('images/logo2.png') }}" alt="Logo" class="w-8 h-8 object-contain">
            <span class="font-bold text-white tracking-tight">PerformPT</span>
        </div>
        
        <!-- Hamburger Button -->
        <button @click="open = !open" 
                class="p-2 focus:outline-none"
                style="color: white !important;">
            <i class="fas fa-bars text-xl" x-show="!open" style="display: block;"></i>
            <i class="fas fa-times text-xl" x-show="open" x-cloak style="display: block;"></i>
        </button>
    </div>

    <!-- 3. MOBILE SIDEBAR OVERLAY (Off-canvas) -->
    <div x-show="open" 
         x-cloak
         class="fixed inset-0 z-[70] lg:hidden" 
         style="display: none;">
        
        <div class="fixed inset-0 bg-black/80 backdrop-blur-sm" @click="open = false"></div>

        <div x-show="open"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="-translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in duration-200 transform"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="-translate-x-full"
             class="fixed inset-y-0 left-0 w-64 bg-[#1e293b] shadow-2xl flex flex-col justify-between">
            
            <div class="flex flex-col h-full">
                <div class="px-6 h-16 flex items-center border-b border-white/5 bg-black/10">
                    <span class="text-white font-bold uppercase tracking-widest text-xs">Manager Menu</span>
                </div>

                <div class="flex-1 overflow-y-auto px-4 py-6 space-y-2">
                    <a href="{{ route('manager.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('manager.dashboard') ? 'bg-[#10b981] text-white' : 'text-gray-400' }}">
                        <i class="fas fa-th-large w-5 text-center"></i>
                        <span class="text-sm font-semibold">Dashboard</span>
                    </a>
                    <a href="{{ route('evaluations.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-400">
                        <i class="fas fa-clipboard-check w-5 text-center"></i>
                        <span class="text-sm font-semibold">Evaluation</span>
                    </a>
                    <a href="{{ route('analytics.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-400">
                        <i class="fas fa-chart-line w-5 text-center"></i>
                        <span class="text-sm font-semibold">Analytics</span>
                    </a>
                </div>

                <div class="p-4 bg-black/10 border-t border-white/5">
                    <div class="flex items-center gap-3 px-2 mb-4">
                        <div class="h-10 w-10 shrink-0 rounded-full bg-[#10b981] flex items-center justify-center text-white font-bold text-xs border-2 border-white/10">
                            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                        </div>
                        <div class="flex-1 overflow-hidden text-left">
                            <p class="text-white text-sm font-bold truncate">{{ Auth::user()->name }}</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full py-2.5 rounded-lg bg-white/5 text-gray-300 text-xs font-bold border border-white/5">
                            Sign out
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>