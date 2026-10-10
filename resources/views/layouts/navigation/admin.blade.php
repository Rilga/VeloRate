<!-- Wrapper Utama dengan State Open Alpine.js untuk Mobile -->
<div x-data="{ open: false }">
    
    <!-- =========================================================
         CSS SIDEBAR - IAI CORPORATE STYLE
         ========================================================= -->
    <style>
        /* =====================================================
           BACKGROUND SIDEBAR
           Off-white netral agar tidak terlalu biru/abu
           ===================================================== */
        .iai-bg-light-sidebar { 
            background-color: #F5F5F3 !important; 
        }

        /* =====================================================
           BORDER
           ===================================================== */
        .iai-border-light {
            border-color: #E3E3E0 !important;
        }

        /* =====================================================
           MENU AKTIF
           Tetap menggunakan merah IAI
           ===================================================== */
        .iai-menu-active { 
            background-color: #D1232A !important; 
            color: #FFFFFF !important;
            box-shadow: 0 6px 12px -4px rgba(209, 35, 42, 0.18) !important;
        }

        /* =====================================================
           MENU NORMAL
           ===================================================== */
        .iai-text-dark-menu {
            color: #334155 !important;
        }

        /* =====================================================
           HOVER MENU
           Merah sangat lembut agar tetap satu identitas
           ===================================================== */
        .iai-text-dark-menu:hover {
            background-color: #FBEDEE !important;
            color: #D1232A !important;
        }

        /* =====================================================
           SIGN OUT BUTTON
           ===================================================== */
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
    
    
    <!-- =========================================================
         DESKTOP SIDEBAR
         Hidden on Mobile
         ========================================================= -->
    <nav class="
        iai-bg-light-sidebar 
        iai-border-light 
        border-r 
        fixed 
        left-0 
        top-0 
        h-screen 
        w-64 
        flex 
        flex-col 
        justify-between 
        z-50 
        hidden 
        lg:flex
    ">
        
        <!-- =====================================================
             BAGIAN ATAS SIDEBAR
             ===================================================== -->
        <div>

            <!-- Header Area: Logo & Brand -->
            <div class="flex items-center gap-3 px-6 h-24">
                
                <!-- Logo -->
                <div class="flex items-center justify-center overflow-hidden rounded-lg">
                    <img 
                        src="{{ asset('images/logo.png') }}" 
                        alt="Logo IAI Jakarta" 
                        class="w-16 h-16 object-contain"
                    >
                </div>

                <!-- Brand -->
                <div>
                    <h1 class="text-[#0f172a] font-bold text-lg leading-none tracking-tight">
                        IAI JAKARTA
                    </h1>

                    <p class="text-slate-600 text-[10px] mt-1 font-semibold uppercase tracking-wider">
                        Admin
                    </p>
                </div>
            </div>


            <!-- =================================================
                 MENU LINKS
                 ================================================= -->
            <div class="px-4 py-4">

                <!-- Menu Title -->
                <p class="
                    text-slate-500 
                    text-[10px] 
                    uppercase 
                    tracking-[0.2em] 
                    font-bold 
                    px-4 
                    mb-4
                ">
                    Admin Menu
                </p>

                <div class="space-y-2">

                    <!-- =========================================
                         DASHBOARD
                         ========================================= -->
                    <a 
                        href="{{ route('admin.dashboard') }}" 
                        class="
                            flex 
                            items-center 
                            gap-3 
                            px-4 
                            py-3 
                            rounded-xl 
                            transition-all 
                            duration-200 
                            group 
                            {{ request()->routeIs('admin.dashboard') 
                                ? 'iai-menu-active' 
                                : 'iai-text-dark-menu' 
                            }}
                        "
                    >
                        <i class="fas fa-th-large w-5 text-center"></i>

                        <span class="text-sm font-semibold">
                            Dashboard
                        </span>
                    </a>


                    <!-- =========================================
                         EMPLOYEES
                         ========================================= -->
                    <a 
                        href="{{ route('employees.index') }}" 
                        class="
                            flex 
                            items-center 
                            gap-3 
                            px-4 
                            py-3 
                            rounded-xl 
                            transition-all 
                            duration-200 
                            group 
                            {{ request()->is('employees*') 
                                ? 'iai-menu-active' 
                                : 'iai-text-dark-menu' 
                            }}
                        "
                    >
                        <i class="fas fa-users w-5 text-center"></i>

                        <span class="text-sm font-semibold">
                            Employees
                        </span>
                    </a>


                    <!-- =========================================
                         KPI CONFIG
                         ========================================= -->
                    <a 
                        href="{{ route('criteria.index') }}" 
                        class="
                            flex 
                            items-center 
                            gap-3 
                            px-4 
                            py-3 
                            rounded-xl 
                            transition-all 
                            duration-200 
                            group 
                            {{ request()->is('criteria*') 
                                ? 'iai-menu-active' 
                                : 'iai-text-dark-menu' 
                            }}
                        "
                    >
                        <i class="
                            fas 
                            fa-cog 
                            w-5 
                            text-center 
                            group-hover:rotate-45 
                            transition-transform
                        "></i>

                        <span class="text-sm font-semibold">
                            KPI Config
                        </span>
                    </a>

                </div>
            </div>
        </div>


        <!-- =====================================================
             BAGIAN BAWAH
             USER PROFILE + SIGN OUT
             ===================================================== -->
        <div class="
            p-4 
            bg-[#EEEEEC] 
            iai-border-light 
            border-t
        ">

            <!-- User Profile -->
            <div class="
                flex 
                items-center 
                gap-3 
                px-2 
                mb-4
            ">

                <!-- Avatar -->
                <div 
                    class="
                        h-10 
                        w-10 
                        shrink-0 
                        rounded-full 
                        flex 
                        items-center 
                        justify-center 
                        text-white 
                        font-bold 
                        text-xs 
                        border-2 
                        border-white 
                        shadow-inner
                    "
                    style="background-color: #D1232A;"
                >
                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                </div>

                <!-- User Information -->
                <div class="flex-1 overflow-hidden">

                    <p class="
                        text-[#0f172a] 
                        text-sm 
                        font-bold 
                        truncate 
                        leading-tight
                    ">
                        {{ Auth::user()->name }}
                    </p>

                    <p class="
                        text-slate-600 
                        text-[10px] 
                        truncate
                    ">
                        {{ Auth::user()->email }}
                    </p>

                </div>
            </div>


            <!-- =================================================
                 SIGN OUT
                 ================================================= -->
            <form 
                method="POST" 
                action="{{ route('logout') }}"
            >
                @csrf

                <button 
                    type="submit" 
                    class="
                        iai-btn-signout 
                        w-full 
                        py-2.5 
                        rounded-lg 
                        text-xs 
                        font-bold 
                        border 
                        uppercase 
                        tracking-widest
                    "
                >
                    Sign out
                </button>
            </form>

        </div>

    </nav>


    <!-- =========================================================
         MOBILE HEADER
         ========================================================= -->
    <div class="
        lg:hidden 
        fixed 
        top-0 
        left-0 
        w-full 
        iai-bg-light-sidebar 
        iai-border-light 
        border-b 
        z-[60] 
        h-16 
        flex 
        items-center 
        justify-between 
        px-4
    ">

        <!-- Logo + Brand -->
        <div class="flex items-center gap-3">

            <img 
                src="{{ asset('images/logo.png') }}" 
                alt="Logo IAI Jakarta" 
                class="w-12 h-12 object-contain"
            >

            <span class="
                font-bold 
                text-[#0f172a] 
                tracking-tight
            ">
                IAI JAKARTA
            </span>

        </div>


        <!-- Mobile Menu Button -->
        <button 
            @click="open = !open" 
            class="
                text-slate-800 
                hover:text-[#D1232A] 
                p-2 
                focus:outline-none 
                transition-colors
            "
        >

            <!-- Hamburger -->
            <i 
                class="fas fa-bars text-xl" 
                x-show="!open"
            ></i>

            <!-- Close -->
            <i 
                class="fas fa-times text-xl" 
                x-show="open" 
                style="display: none;"
            ></i>

        </button>

    </div>


    <!-- =========================================================
         MOBILE SIDEBAR PANEL / OFF-CANVAS
         ========================================================= -->
    <div 
        x-show="open" 
        x-cloak

        x-transition:enter="transition ease-in-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"

        x-transition:leave="transition ease-in-out duration-300"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"

        class="
            fixed 
            inset-0 
            z-[70] 
            lg:hidden
        "

        style="display: none;"
    >

        <!-- =====================================================
             OVERLAY
             ===================================================== -->
        <div 
            class="
                fixed 
                inset-0 
                bg-black/40 
                backdrop-blur-sm
            "
            @click="open = false"
        ></div>


        <!-- =====================================================
             MOBILE SIDEBAR
             ===================================================== -->
        <div 
            x-show="open"

            x-transition:enter="transition ease-out duration-300 transform"
            x-transition:enter-start="-translate-x-full"
            x-transition:enter-end="translate-x-0"

            x-transition:leave="transition ease-in duration-200 transform"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full"

            class="
                fixed 
                inset-y-0 
                left-0 
                w-64 
                iai-bg-light-sidebar 
                shadow-2xl 
                flex 
                flex-col 
                justify-between
            "
        >

            <div class="flex flex-col h-full">

                <!-- =============================================
                     MOBILE NAVIGATION HEADER
                     ============================================= -->
                <div class="
                    px-6 
                    h-16 
                    flex 
                    items-center 
                    border-b 
                    iai-border-light 
                    bg-[#EEEEEC]
                ">

                    <span class="
                        text-[#0f172a] 
                        font-bold 
                        uppercase 
                        tracking-widest 
                        text-xs
                    ">
                        Navigation
                    </span>

                </div>


                <!-- =============================================
                     MOBILE MENU
                     ============================================= -->
                <div class="
                    flex-1 
                    overflow-y-auto 
                    px-4 
                    py-6 
                    space-y-2
                ">

                    <!-- Dashboard -->
                    <a 
                        href="{{ route('admin.dashboard') }}" 
                        class="
                            flex 
                            items-center 
                            gap-3 
                            px-4 
                            py-3 
                            rounded-xl 
                            {{ request()->routeIs('admin.dashboard') 
                                ? 'iai-menu-active' 
                                : 'iai-text-dark-menu' 
                            }}
                        "
                    >

                        <i class="fas fa-th-large w-5 text-center"></i>

                        <span class="text-sm font-semibold">
                            Dashboard
                        </span>

                    </a>


                    <!-- Employees -->
                    <a 
                        href="{{ route('employees.index') }}" 
                        class="
                            flex 
                            items-center 
                            gap-3 
                            px-4 
                            py-3 
                            rounded-xl 
                            {{ request()->is('employees*') 
                                ? 'iai-menu-active' 
                                : 'iai-text-dark-menu' 
                            }}
                        "
                    >

                        <i class="fas fa-users w-5 text-center"></i>

                        <span class="text-sm font-semibold">
                            Employees
                        </span>

                    </a>


                    <!-- KPI Config -->
                    <a 
                        href="{{ route('criteria.index') }}" 
                        class="
                            flex 
                            items-center 
                            gap-3 
                            px-4 
                            py-3 
                            rounded-xl 
                            {{ request()->is('criteria*') 
                                ? 'iai-menu-active' 
                                : 'iai-text-dark-menu' 
                            }}
                        "
                    >

                        <i class="fas fa-cog w-5 text-center"></i>

                        <span class="text-sm font-semibold">
                            KPI Config
                        </span>

                    </a>

                </div>


                <!-- =============================================
                     MOBILE USER PROFILE
                     ============================================= -->
                <div class="
                    p-4 
                    bg-[#EEEEEC] 
                    iai-border-light 
                    border-t
                ">

                    <!-- User -->
                    <div class="
                        flex 
                        items-center 
                        gap-3 
                        px-2 
                        mb-4
                    ">

                        <!-- Avatar -->
                        <div 
                            class="
                                h-10 
                                w-10 
                                shrink-0 
                                rounded-full 
                                flex 
                                items-center 
                                justify-center 
                                text-white 
                                font-bold 
                                text-xs 
                                border-2 
                                border-white 
                                shadow-inner
                            "
                            style="background-color: #D1232A;"
                        >
                            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                        </div>


                        <!-- Name -->
                        <div class="
                            flex-1 
                            overflow-hidden 
                            text-left
                        ">

                            <p class="
                                text-[#0f172a] 
                                text-sm 
                                font-bold 
                                truncate
                            ">
                                {{ Auth::user()->name }}
                            </p>

                        </div>

                    </div>


                    <!-- Mobile Sign Out -->
                    <form 
                        method="POST" 
                        action="{{ route('logout') }}"
                    >
                        @csrf

                        <button 
                            type="submit" 
                            class="
                                iai-btn-signout 
                                w-full 
                                py-2.5 
                                rounded-lg 
                                text-xs 
                                font-bold 
                                border
                            "
                        >
                            Sign out
                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>
