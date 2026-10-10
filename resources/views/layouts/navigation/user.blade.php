<!-- Wrapper Utama Sidebar User / Employee -->
<div x-data="{ open: false }">
    
    <!-- =========================================================
         CSS SIDEBAR - IAI CORPORATE STYLE
         ========================================================= -->
    <style>
        /* =====================================================
           BACKGROUND SIDEBAR
           Off-white netral, konsisten dengan Admin Sidebar
           ===================================================== */
        .iai-bg-light-sidebar { 
            background-color: #F5F5F3 !important; 
        }

        /* =====================================================
           BORDER
           Border dibuat halus dan netral
           ===================================================== */
        .iai-border-light {
            border-color: #E3E3E0 !important;
        }

        /* =====================================================
           MENU AKTIF
           Merah IAI
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
           Merah lembut agar konsisten dengan brand
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

        /* =====================================================
           SIGN OUT HOVER
           ===================================================== */
        .iai-btn-signout:hover {
            background-color: #D1232A !important;
            color: #FFFFFF !important;
            border-color: #B91C23 !important;
        }
    </style>
    
    
    <!-- =========================================================
         DESKTOP SIDEBAR
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
             BAGIAN ATAS
             ===================================================== -->
        <div>

            <!-- Header Logo & Brand -->
            <div class="flex items-center gap-3 px-6 h-24">

                <!-- Logo -->
                <div class="
                    flex 
                    items-center 
                    justify-center 
                    overflow-hidden 
                    rounded-lg
                ">
                    <img 
                        src="{{ asset('images/logo.png') }}" 
                        alt="IAI Jakarta Logo" 
                        class="w-16 h-16 object-contain"
                    >
                </div>

                <!-- Brand -->
                <div>

                    <h1 class="
                        text-[#0f172a] 
                        font-bold 
                        text-lg 
                        leading-none 
                        tracking-tight
                    ">
                        IAI JAKARTA
                    </h1>

                    <p class="
                        text-slate-600 
                        text-[10px] 
                        mt-1 
                        font-medium 
                        uppercase 
                        tracking-wider
                    ">
                        Employee Portal
                    </p>

                </div>

            </div>


            <!-- =================================================
                 MAIN MENU
                 ================================================= -->
            <div class="px-4 py-4">

                <!-- Menu Label -->
                <p class="
                    text-slate-500 
                    text-[10px] 
                    uppercase 
                    tracking-[0.2em] 
                    font-bold 
                    px-4 
                    mb-4
                ">
                    Main Menu
                </p>


                <div class="space-y-2">

                    <!-- =========================================
                         MY PERFORMANCE
                         ========================================= -->
                    <a 
                        href="{{ route('user.dashboard') }}" 
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
                            {{ request()->routeIs('user.dashboard') 
                                ? 'iai-menu-active' 
                                : 'iai-text-dark-menu' 
                            }}
                        "
                    >

                        <i class="
                            fas 
                            fa-chart-pie 
                            w-5 
                            text-center
                        "></i>

                        <span class="text-sm font-semibold">
                            My Performance
                        </span>

                    </a>


                    <!-- =========================================
                         PERFORMANCE TRENDS
                         ========================================= -->
                    <a 
                        href="{{ route('user.trend') }}" 
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
                            {{ request()->routeIs('user.trend') 
                                ? 'iai-menu-active' 
                                : 'iai-text-dark-menu' 
                            }}
                        "
                    >

                        <i class="
                            fas 
                            fa-chart-line 
                            w-5 
                            text-center
                        "></i>

                        <span class="text-sm font-semibold">
                            Performance Trends
                        </span>

                    </a>


                    <!-- =========================================
                         FEEDBACK & REMARKS
                         ========================================= -->
                    <a 
                        href="{{ route('user.feedback') }}" 
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
                            {{ request()->routeIs('user.feedback') 
                                ? 'iai-menu-active' 
                                : 'iai-text-dark-menu' 
                            }}
                        "
                    >

                        <i class="
                            fas 
                            fa-comment-dots 
                            w-5 
                            text-center
                        "></i>

                        <span class="text-sm font-semibold">
                            Feedback & Remarks
                        </span>

                    </a>

                </div>
            </div>

        </div>


        <!-- =====================================================
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
                        leading-tight
                    ">
                        {{ Auth::user()->name }}
                    </p>

                    <p class="
                        text-slate-600 
                        text-[9px] 
                        font-bold 
                        uppercase 
                        mt-0.5
                    ">
                        Employee
                    </p>

                </div>

            </div>


            <!-- Sign Out -->
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
                alt="IAI Jakarta Logo" 
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
                p-2 
                focus:outline-none 
                text-[#0f172a] 
                hover:text-[#D1232A] 
                transition-colors
            "
        >

            <!-- Hamburger -->
            <i 
                class="fas fa-bars text-xl" 
                x-show="!open" 
                style="display: block;"
            ></i>

            <!-- Close -->
            <i 
                class="fas fa-times text-xl" 
                x-show="open" 
                x-cloak 
                style="display: block;"
            ></i>

        </button>

    </div>


    <!-- =========================================================
         MOBILE SIDEBAR PANEL
         ========================================================= -->
    <div 
        x-show="open" 
        x-cloak 
        class="
            fixed 
            inset-0 
            z-[70] 
            lg:hidden
        " 
        style="display: none;"
    >

        <!-- Overlay -->
        <div 
            class="
                fixed 
                inset-0 
                bg-black/40 
                backdrop-blur-sm
            "
            @click="open = false"
        ></div>


        <!-- Mobile Sidebar -->
        <div 
            x-show="open"

            x-transition:enter="
                transition 
                ease-out 
                duration-300 
                transform
            "

            x-transition:enter-start="-translate-x-full"

            x-transition:enter-end="translate-x-0"

            x-transition:leave="
                transition 
                ease-in 
                duration-200 
                transform
            "

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
                     MOBILE HEADER
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
                        Employee Menu
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

                    <!-- My Performance -->
                    <a 
                        href="{{ route('user.dashboard') }}" 
                        class="
                            flex 
                            items-center 
                            gap-3 
                            px-4 
                            py-3 
                            rounded-xl 
                            {{ request()->routeIs('user.dashboard') 
                                ? 'iai-menu-active' 
                                : 'iai-text-dark-menu' 
                            }}
                        "
                    >

                        <i class="
                            fas 
                            fa-chart-pie 
                            w-5 
                            text-center
                        "></i>

                        <span class="text-sm font-semibold">
                            My Performance
                        </span>

                    </a>


                    <!-- Performance Trends -->
                    <a 
                        href="{{ route('user.trend') }}" 
                        class="
                            flex 
                            items-center 
                            gap-3 
                            px-4 
                            py-3 
                            rounded-xl 
                            {{ request()->routeIs('user.trend') 
                                ? 'iai-menu-active' 
                                : 'iai-text-dark-menu' 
                            }}
                        "
                    >

                        <i class="
                            fas 
                            fa-chart-line 
                            w-5 
                            text-center
                        "></i>

                        <span class="text-sm font-semibold">
                            Performance Trends
                        </span>

                    </a>


                    <!-- Feedback & Remarks -->
                    <a 
                        href="{{ route('user.feedback') }}" 
                        class="
                            flex 
                            items-center 
                            gap-3 
                            px-4 
                            py-3 
                            rounded-xl 
                            {{ request()->routeIs('user.feedback') 
                                ? 'iai-menu-active' 
                                : 'iai-text-dark-menu' 
                            }}
                        "
                    >

                        <i class="
                            fas 
                            fa-comment-dots 
                            w-5 
                            text-center
                        "></i>

                        <span class="text-sm font-semibold">
                            Feedback & Remarks
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


                        <!-- User Information -->
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

                            <p class="
                                text-slate-600 
                                text-[9px] 
                                font-bold 
                                uppercase
                            ">
                                Employee
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
