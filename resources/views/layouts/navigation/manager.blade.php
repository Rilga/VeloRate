
<!-- Wrapper Utama Sidebar Manager -->
<div x-data="{ open: false }">

    <!-- CSS SIDEBAR - IAI CORPORATE STYLE -->
    <style>
        /* Background utama sidebar */
        .iai-bg-light-sidebar {
            background-color: #F5F5F3 !important;
        }

        /* Border sidebar */
        .iai-border-light {
            border-color: #E3E3E0 !important;
        }

        /* Menu aktif */
        .iai-menu-active {
            background-color: #D1232A !important;
            color: #FFFFFF !important;
            box-shadow: 0 6px 12px -4px rgba(209, 35, 42, 0.18) !important;
        }

        /* Menu normal */
        .iai-text-dark-menu {
            color: #334155 !important;
        }

        /* Hover menu */
        .iai-text-dark-menu:hover {
            background-color: #FBEDEE !important;
            color: #D1232A !important;
        }

        /* Tombol Sign Out */
        .iai-btn-signout {
            background-color: #EEEEEC !important;
            color: #334155 !important;
            border-color: #D6D6D2 !important;
            transition: all 0.2s ease-in-out;
        }

        /* Hover Sign Out */
        .iai-btn-signout:hover {
            background-color: #D1232A !important;
            color: #FFFFFF !important;
            border-color: #B91C23 !important;
        }
    </style>


    <!-- =====================================================
         1. DESKTOP SIDEBAR
         ===================================================== -->
    <nav class="iai-bg-light-sidebar iai-border-light border-r fixed left-0 top-0 h-screen w-64 flex flex-col justify-between z-50 hidden lg:flex">

        <div>

            <!-- Header Logo & Brand -->
            <div class="flex items-center gap-3 px-6 h-24">

                <div class="flex items-center justify-center overflow-hidden rounded-lg">
                    <img
                        src="{{ asset('images/logo.png') }}"
                        alt="IAI Jakarta Logo"
                        class="w-16 h-16 object-contain"
                    >
                </div>

                <div>
                    <h1 class="text-[#0f172a] font-bold text-lg leading-none tracking-tight">
                        IAI JAKARTA
                    </h1>

                    <p class="font-bold text-[10px] mt-1 uppercase tracking-wider" style="color: #D1232A;">
                        Manager
                    </p>
                </div>

            </div>


            <!-- Menu Links -->
            <div class="px-4 py-4">

                <p class="text-slate-500 text-[10px] uppercase tracking-[0.2em] font-bold px-4 mb-4">
                    Manager Menu
                </p>

                <div class="space-y-2">

                    <!-- Dashboard -->
                    <a
                        href="{{ route('manager.dashboard') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('manager.dashboard') ? 'iai-menu-active' : 'iai-text-dark-menu' }}"
                    >
                        <i class="fas fa-th-large w-5 text-center"></i>
                        <span class="text-sm font-semibold">Dashboard</span>
                    </a>

                    <!-- Evaluation -->
                    <a
                        href="{{ route('evaluations.index') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->is('evaluations*') ? 'iai-menu-active' : 'iai-text-dark-menu' }}"
                    >
                        <i class="fas fa-clipboard-check w-5 text-center"></i>
                        <span class="text-sm font-semibold">Evaluation</span>
                    </a>

                    <!-- Analytics -->
                    <a
                        href="{{ route('analytics.index') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->is('analytics*') ? 'iai-menu-active' : 'iai-text-dark-menu' }}"
                    >
                        <i class="fas fa-chart-line w-5 text-center"></i>
                        <span class="text-sm font-semibold">Analytics</span>
                    </a>

                </div>
            </div>

        </div>


        <!-- =================================================
             BAGIAN BAWAH: PROFIL MANAGER & SIGN OUT
             ================================================= -->
        <div class="p-4 bg-[#EEEEEC] iai-border-light border-t">

            <!-- Profil Manager -->
            <div class="flex items-center gap-3 px-2 mb-4">

                <!-- Avatar -->
                <div
                    class="h-10 w-10 shrink-0 rounded-full flex items-center justify-center text-white font-bold text-xs border-2 border-white shadow-inner"
                    style="background-color: #D1232A;"
                >
                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                </div>

                <!-- Informasi Pengguna -->
                <div class="flex-1 overflow-hidden text-left">

                    <p class="text-[#0f172a] text-sm font-bold truncate leading-tight">
                        {{ Auth::user()->name }}
                    </p>

                    <p class="font-bold text-[9px] uppercase mt-0.5" style="color: #D1232A;">
                        Manager
                    </p>

                </div>

            </div>


            <!-- Sign Out -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button
                    type="submit"
                    class="iai-btn-signout w-full py-2.5 rounded-lg text-xs font-bold border uppercase tracking-widest"
                >
                    Sign out
                </button>
            </form>

        </div>

    </nav>


    <!-- =====================================================
         2. MOBILE HEADER
         ===================================================== -->
    <div class="lg:hidden fixed top-0 left-0 w-full iai-bg-light-sidebar iai-border-light border-b z-[60] h-16 flex items-center justify-between px-4">

        <!-- Logo & Brand -->
        <div class="flex items-center gap-3">
            <img
                src="{{ asset('images/logo.png') }}"
                alt="IAI Jakarta Logo"
                class="w-12 h-12 object-contain"
            >

            <span class="font-bold text-[#0f172a] tracking-tight">
                IAI JAKARTA
            </span>
        </div>

        <!-- Hamburger Button -->
        <button
            @click="open = !open"
            class="p-2 focus:outline-none text-[#0f172a] hover:text-[#D1232A] transition-colors"
            aria-label="Toggle navigation"
        >
            <i class="fas fa-bars text-xl" x-show="!open"></i>
            <i class="fas fa-times text-xl" x-show="open" x-cloak></i>
        </button>

    </div>


    <!-- =====================================================
         3. MOBILE SIDEBAR OVERLAY
         ===================================================== -->
    <div
        x-show="open"
        x-cloak
        class="fixed inset-0 z-[70] lg:hidden"
        style="display: none;"
    >

        <!-- Overlay -->
        <div
            class="fixed inset-0 bg-black/40 backdrop-blur-sm"
            @click="open = false"
        ></div>


        <!-- Mobile Sidebar Panel -->
        <div
            x-show="open"
            x-transition:enter="transition ease-out duration-300 transform"
            x-transition:enter-start="-translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in duration-200 transform"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full"
            class="fixed inset-y-0 left-0 w-64 iai-bg-light-sidebar shadow-2xl flex flex-col justify-between"
        >

            <div class="flex flex-col h-full">

                <!-- Mobile Menu Header -->
                <div class="px-6 h-16 flex items-center border-b iai-border-light bg-[#EEEEEC]">
                    <span class="text-[#0f172a] font-bold uppercase tracking-widest text-xs">
                        Manager Menu
                    </span>
                </div>


                <!-- Mobile Menu Links -->
                <div class="flex-1 overflow-y-auto px-4 py-6 space-y-2">

                    <!-- Dashboard -->
                    <a
                        href="{{ route('manager.dashboard') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('manager.dashboard') ? 'iai-menu-active' : 'iai-text-dark-menu' }}"
                    >
                        <i class="fas fa-th-large w-5 text-center"></i>
                        <span class="text-sm font-semibold">Dashboard</span>
                    </a>

                    <!-- Evaluation -->
                    <a
                        href="{{ route('evaluations.index') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->is('evaluations*') ? 'iai-menu-active' : 'iai-text-dark-menu' }}"
                    >
                        <i class="fas fa-clipboard-check w-5 text-center"></i>
                        <span class="text-sm font-semibold">Evaluation</span>
                    </a>

                    <!-- Analytics -->
                    <a
                        href="{{ route('analytics.index') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->is('analytics*') ? 'iai-menu-active' : 'iai-text-dark-menu' }}"
                    >
                        <i class="fas fa-chart-line w-5 text-center"></i>
                        <span class="text-sm font-semibold">Analytics</span>
                    </a>

                </div>


                <!-- Mobile User Profile & Sign Out -->
                <div class="p-4 bg-[#EEEEEC] iai-border-light border-t">

                    <div class="flex items-center gap-3 px-2 mb-4">

                        <!-- Avatar -->
                        <div
                            class="h-10 w-10 shrink-0 rounded-full flex items-center justify-center text-white font-bold text-xs border-2 border-white shadow-inner"
                            style="background-color: #D1232A;"
                        >
                            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                        </div>

                        <!-- User Name -->
                        <div class="flex-1 overflow-hidden text-left">
                            <p class="text-[#0f172a] text-sm font-bold truncate">
                                {{ Auth::user()->name }}
                            </p>

                            <p class="font-bold text-[9px] uppercase mt-0.5" style="color: #D1232A;">
                                Manager
                            </p>
                        </div>

                    </div>


                    <!-- Mobile Sign Out -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <button
                            type="submit"
                            class="iai-btn-signout w-full py-2.5 rounded-lg text-xs font-bold border"
                        >
                            Sign out
                        </button>
                    </form>

                </div>

            </div>

        </div>

    </div>

</div>
