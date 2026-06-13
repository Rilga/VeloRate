<!-- Wrapper Utama Sidebar User / Employee -->
<div x-data="{ open: false }">
    
    <!-- SUNTIKAN CSS MURNI: Mengunci warna terang pekat, aktif merah, dan efek hover signout merah murni -->
    <style>
        /* Background navigasi dibuat abu-abu terang yang tegas dan pekat */
        .iai-bg-light-sidebar { 
            background-color: #e2e8f0 !important; 
        }
        /* Border pembatas dibuat lebih gelap sedikit agar kontras */
        .iai-border-light {
            border-color: #cbd5e1 !important;
        }
        /* Menu Utama yang Sedang Aktif (Merah IAI) */
        .iai-menu-active { 
            background-color: #D1232A !important; 
            color: white !important;
            box-shadow: 0 10px 15px -3px rgba(209, 35, 42, 0.2) !important;
        }
        /* Menu Utama Non-Aktif (Teks Gelap Pekat agar sangat kontras di bg terang) */
        .iai-text-dark-menu {
            color: #334155 !important;
        }
        .iai-text-dark-menu:hover {
            background-color: rgba(15, 23, 42, 0.08) !important;
            color: #0f172a !important;
        }
        /* Efek hover tombol Sign Out agar pasti berwarna Merah IAI */
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
    
    <!-- Desktop Sidebar (Hidden on Mobile) -->
    <nav class="iai-bg-light-sidebar iai-border-light border-r fixed left-0 top-0 h-screen w-64 flex flex-col justify-between z-50 hidden lg:flex">
        
        <div>
            <div class="flex items-center gap-3 px-6 h-24">
                <div class="flex items-center justify-center overflow-hidden rounded-lg">
                    <img src="{{ asset('images/logo.png') }}" alt="PerformPT Logo" class="w-16 h-16 object-contain">
                </div>
                <div>
                    <h1 class="text-[#0f172a] font-bold text-lg leading-none tracking-tight">IAI JAKARTA</h1>
                    <p class="text-slate-600 text-[10px] mt-1 font-medium uppercase tracking-wider">Employee Portal</p>
                </div>
            </div>

            <div class="px-4 py-4">
                <p class="text-slate-500 text-[10px] uppercase tracking-[0.2em] font-bold px-4 mb-4">Main Menu</p>
                
                <div class="space-y-2">
                    <!-- My Performance -->
                    <a href="{{ route('user.dashboard') }}" 
                        class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('user.dashboard') ? 'iai-menu-active' : 'iai-text-dark-menu' }}">
                        <i class="fas fa-chart-pie w-5 text-center"></i>
                        <span class="text-sm font-semibold">My Performance</span>
                    </a>

                    <!-- Performance Trends -->
                    <a href="{{ route('user.trend') }}" 
                        class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('user.trend') ? 'iai-menu-active' : 'iai-text-dark-menu' }}">
                        <i class="fas fa-chart-line w-5 text-center"></i>
                        <span class="text-sm font-semibold">Performance Trends</span>
                    </a>

                    <!-- Feedback & Remarks -->
                    <a href="{{ route('user.feedback') }}" 
                        class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('user.feedback') ? 'iai-menu-active' : 'iai-text-dark-menu' }}">
                        <i class="fas fa-comment-dots w-5 text-center"></i>
                        <span class="text-sm font-semibold">Feedback & Remarks</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="p-4 bg-slate-300/60 iai-border-light border-t">
            <div class="flex items-center gap-3 px-2 mb-4">
                <div class="h-10 w-10 shrink-0 rounded-full flex items-center justify-center text-white font-bold text-xs border-2 border-white shadow-inner" style="background-color: #D1232A;">
                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                </div>
                <div class="flex-1 overflow-hidden text-left">
                    <p class="text-[#0f172a] text-sm font-bold truncate leading-tight">{{ Auth::user()->name }}</p>
                    <p class="text-slate-600 text-[9px] font-bold uppercase mt-0.5">Employee</p>
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

    <!-- Mobile Header -->
    <div class="lg:hidden fixed top-0 left-0 w-full iai-bg-light-sidebar iai-border-light border-b z-[60] h-16 flex items-center justify-between px-4">
        <div class="flex items-center gap-3">
            <img src="{{ asset('images/logo.png') }}" alt="PerformPT Logo" class="w-12 h-12 object-contain">
            <span class="font-bold text-[#0f172a] tracking-tight">IAI JAKARTA</span>
        </div>
        
        <button @click="open = !open" class="p-2 focus:outline-none" style="color: #0f172a !important;">
            <i class="fas fa-bars text-xl" x-show="!open" style="display: block;"></i>
            <i class="fas fa-times text-xl" x-show="open" x-cloak style="display: block;"></i>
        </button>
    </div>

    <!-- Mobile Sidebar Panel -->
    <div x-show="open" x-cloak class="fixed inset-0 z-[70] lg:hidden" style="display: none;">
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
                    <span class="text-[#0f172a] font-bold uppercase tracking-widest text-xs">Employee Menu</span>
                </div>

                <div class="flex-1 overflow-y-auto px-4 py-6 space-y-2">
                    <a href="{{ route('user.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('user.dashboard') ? 'iai-menu-active' : 'iai-text-dark-menu' }}">
                        <i class="fas fa-chart-pie w-5 text-center"></i>
                        <span class="text-sm font-semibold">My Performance</span>
                    </a>
                    
                    <a href="{{ route('user.trend') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('user.trend') ? 'iai-menu-active' : 'iai-text-dark-menu' }}">
                        <i class="fas fa-chart-line w-5 text-center"></i>
                        <span class="text-sm font-semibold">Performance Trends</span>
                    </a>

                    <a href="{{ route('user.feedback') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('user.feedback') ? 'iai-menu-active' : 'iai-text-dark-menu' }}">
                        <i class="fas fa-comment-dots w-5 text-center"></i>
                        <span class="text-sm font-semibold">Feedback & Remarks</span>
                    </a>
                </div>

                <div class="p-4 bg-slate-300/50 border-t border-slate-300">
                    <div class="flex items-center gap-3 px-2 mb-4">
                        <div class="h-10 w-10 shrink-0 rounded-full flex items-center justify-center text-white font-bold text-xs border-2 border-white shadow-inner" style="background-color: #D1232A;">
                            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                        </div>
                        <div class="flex-1 overflow-hidden text-left">
                            <p class="text-[#0f172a] text-sm font-bold truncate">{{ Auth::user()->name }}</p>
                            <p class="text-slate-600 text-[9px] font-bold uppercase">Employee</p>
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