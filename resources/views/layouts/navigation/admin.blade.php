<!-- Wrapper Utama dengan State Open Alpine.js untuk Mobile -->
<div x-data="{ open: false }">
    
    <!-- Desktop Sidebar (Hidden on Mobile) -->
    <nav class="bg-[#1e293b] border-r border-white/10 fixed left-0 top-0 h-screen w-64 flex flex-col justify-between z-50 hidden lg:flex">
        
        <div>
            <!-- Header Area (Logo & Brand) - UPDATE LOGO DISINI -->
            <div class="flex items-center gap-3 px-6 h-24">
                <div class="flex items-center justify-center overflow-hidden rounded-lg">
                    <!-- Menggunakan logo dari public/images/logo.png -->
                    <img src="{{ asset('images/logo.png') }}" alt="Logo PerformPT" class="w-16 h-16 object-contain">
                </div>
                <div>
                    <h1 class="text-white font-bold text-lg leading-none tracking-tight">IAI JAKARTA</h1>
                    <p class="text-gray-400 text-[10px] mt-1 font-medium uppercase tracking-wider">Admin</p>
                </div>
            </div>

            <!-- Menu Links -->
            <div class="px-4 py-4">
                <p class="text-gray-500 text-[10px] uppercase tracking-[0.2em] font-bold px-4 mb-4">Admin Menu</p>
                
                <div class="space-y-2">
                    <!-- Dashboard Link -->
                    <a href="{{ route('admin.dashboard') }}" 
                        class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('admin.dashboard') ? 'bg-[#10b981] text-white shadow-lg shadow-emerald-500/20' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                        <i class="fas fa-th-large w-5 text-center"></i>
                        <span class="text-sm font-semibold">Dashboard</span>
                    </a>

                    <!-- Employees Link -->
                    <a href="{{ route('employees.index') }}" 
                        class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->is('employees*') ? 'bg-[#10b981] text-white shadow-lg shadow-emerald-500/20' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                        <i class="fas fa-users w-5 text-center"></i>
                        <span class="text-sm font-semibold">Employees</span>
                    </a>

                    <!-- KPI Config -->
                    <a href="{{ route('criteria.index') }}" 
                        class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->is('criteria*') ? 'bg-[#10b981] text-white shadow-lg shadow-emerald-500/20' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                        <i class="fas fa-cog w-5 text-center group-hover:rotate-45 transition-transform"></i>
                        <span class="text-sm font-semibold">KPI Config</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Bagian Bawah: Profil User & Sign Out -->
        <div class="p-4 bg-black/10 border-t border-white/5">
            <div class="flex items-center gap-3 px-2 mb-4">
                <div class="h-10 w-10 shrink-0 rounded-full bg-[#10b981] flex items-center justify-center text-white font-bold text-xs border-2 border-white/10 shadow-inner">
                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                </div>
                <div class="flex-1 overflow-hidden">
                    <p class="text-white text-sm font-bold truncate leading-tight">{{ Auth::user()->name }}</p>
                    <p class="text-gray-500 text-[10px] truncate">{{ Auth::user()->email }}</p>
                </div>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full py-2.5 rounded-lg bg-white/5 text-gray-300 text-xs font-bold hover:bg-red-500/10 hover:text-red-400 transition-all border border-white/5 uppercase tracking-widest">
                    Sign out
                </button>
            </form>
        </div>
    </nav>

    <!-- Mobile Header - UPDATE LOGO DISINI JUGA -->
    <div class="lg:hidden fixed top-0 left-0 w-full bg-[#1e293b] border-b border-white/10 z-[60] h-16 flex items-center justify-between px-4">
        <div class="flex items-center gap-3">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-12 h-12 object-contain">
            <span class="font-bold text-white tracking-tight">IAI JAKARTA</span>
        </div>
        <button @click="open = !open" class="text-white hover:text-emerald-400 p-2 focus:outline-none transition-colors">
            <i class="fas fa-bars text-xl" x-show="!open"></i>
            <i class="fas fa-times text-xl" x-show="open" style="display: none;"></i>
        </button>
    </div>

    <!-- Mobile Sidebar Panel (Off-canvas) -->
    <div x-show="open" 
          x-cloak
          x-transition:enter="transition ease-in-out duration-300"
          x-transition:enter-start="opacity-0"
          x-transition:enter-end="opacity-100"
          x-transition:leave="transition ease-in-out duration-300"
          x-transition:leave-start="opacity-100"
          x-transition:leave-end="opacity-0"
          class="fixed inset-0 z-[70] lg:hidden" style="display: none;">
        
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" @click="open = false"></div>

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
                    <span class="text-white font-bold uppercase tracking-widest text-xs">Navigation</span>
                </div>

                <div class="flex-1 overflow-y-auto px-4 py-6 space-y-2">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.dashboard') ? 'bg-[#10b981] text-white' : 'text-gray-400' }}">
                        <i class="fas fa-th-large w-5 text-center"></i>
                        <span class="text-sm font-semibold">Dashboard</span>
                    </a>
                    <a href="{{ route('employees.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('employees.index') ? 'bg-[#10b981] text-white' : 'text-gray-400' }}">
                        <i class="fas fa-users w-5 text-center"></i>
                        <span class="text-sm font-semibold">Employees</span>
                    </a>
                    <a href="{{ route('criteria.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('criteria.index') ? 'bg-[#10b981] text-white' : 'text-gray-400' }}">
                        <i class="fas fa-cog w-5 text-center"></i>
                        <span class="text-sm font-semibold">KPI Config</span>
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