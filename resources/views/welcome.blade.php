<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>AIA | Employee Performance System</title>

    {{-- Font --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link
        href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700"
        rel="stylesheet"
    />

    {{-- Laravel Vite --}}
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))

        @vite(['resources/css/app.css', 'resources/js/app.js'])

    @else

        {{-- Tailwind fallback --}}
        <script src="https://unpkg.com/@tailwindcss/browser@4"></script>

        {{-- Alpine.js --}}
        <script
            defer
            src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"
        ></script>

    @endif


    {{-- =========================================================
        CUSTOM STYLE
    ========================================================== --}}

    <style>

        :root {

            /* AIA BRAND */
            --aia-red: #D71920;
            --aia-red-dark: #B9141A;
            --aia-red-soft: #FEF2F2;

            /* TEXT */
            --ink: #1F1F1F;
            --text: #333333;
            --muted: #737373;

            /* BACKGROUND */
            --surface: #F7F7F7;
            --white: #FFFFFF;

            /* BORDER */
            --border: #E6E6E6;
        }


        /* Alpine */
        [x-cloak] {
            display: none !important;
        }


        /* Full viewport */
        html,
        body {

            width: 100%;
            height: 100%;

            margin: 0;

            overflow: hidden;
        }


        body {

            font-family: 'Instrument Sans', sans-serif;

            background: var(--surface);

            color: var(--text);

        }


        /*
        ==========================================================
        MOBILE HEIGHT ADJUSTMENT
        ==========================================================
        */

        @media (max-width: 640px) {

            html,
            body {
                overflow: hidden;
            }

        }

    </style>

</head>



<body
    x-data="{ open: false }"
    class="flex h-dvh flex-col overflow-hidden bg-[#F7F7F7]"
>


    {{-- =========================================================
        HEADER
    ========================================================== --}}

    <header
        class="h-[64px] shrink-0 border-b border-[#E6E6E6] bg-white"
    >

        <div
            class="mx-auto flex h-full max-w-6xl items-center justify-between px-5 sm:px-6 lg:px-8"
        >


            {{-- =================================================
                AIA LOGO
            ================================================== --}}

            <a
                href="/"
                aria-label="AIA"
                class="flex items-center"
            >

                <img
                    src="{{ asset('images/logo.png') }}"
                    alt="AIA"
                    class="h-12 w-auto object-contain"
                >

            </a>



            {{-- =================================================
                DESKTOP NAVIGATION
            ================================================== --}}

            <nav class="hidden items-center gap-3 lg:flex">

                @auth

                    <a
                        href="{{ url('/dashboard') }}"
                        class="
                            rounded-md
                            border border-[#D9D9D9]
                            px-5 py-2
                            text-sm
                            font-medium
                            text-[#333333]
                            transition
                            hover:border-[#1F1F1F]
                            hover:text-[#1F1F1F]
                        "
                    >
                        Dashboard
                    </a>

                @else

                    <a
                        href="{{ route('login') }}"
                        class="
                            rounded-md
                            bg-[#D71920]
                            px-5 py-2.5
                            text-sm
                            font-semibold
                            text-white
                            transition
                            hover:bg-[#B9141A]
                        "
                    >
                        Log in
                    </a>

                @endauth

            </nav>



            {{-- =================================================
                MOBILE MENU BUTTON
            ================================================== --}}

            <button
                type="button"
                @click="open = !open"
                aria-label="Toggle navigation"
                class="
                    flex
                    h-9
                    w-9
                    items-center
                    justify-center
                    rounded-md
                    border
                    border-[#E0E0E0]
                    text-[#333333]
                    lg:hidden
                "
            >

                {{-- MENU --}}
                <svg
                    x-show="!open"
                    class="h-5 w-5"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1.8"
                        d="M4 6h16M4 12h16M4 18h16"
                    />

                </svg>


                {{-- CLOSE --}}
                <svg
                    x-show="open"
                    x-cloak
                    class="h-5 w-5"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1.8"
                        d="M6 6l12 12M6 18L18 6"
                    />

                </svg>

            </button>

        </div>



        {{-- =================================================
            MOBILE NAVIGATION
        ================================================== --}}

        <div
            x-show="open"
            x-cloak
            x-transition
            class="
                border-t
                border-[#E6E6E6]
                bg-white
                px-5
                py-4
                lg:hidden
            "
        >

            @auth

                <a
                    href="{{ url('/dashboard') }}"
                    class="
                        block
                        rounded-md
                        border
                        border-[#DDDDDD]
                        px-4
                        py-3
                        text-center
                        text-sm
                        font-medium
                        text-[#333333]
                    "
                >
                    Dashboard
                </a>

            @else

                <a
                    href="{{ route('login') }}"
                    class="
                        block
                        rounded-md
                        bg-[#D71920]
                        px-4
                        py-3
                        text-center
                        text-sm
                        font-semibold
                        text-white
                    "
                >
                    Log in
                </a>

            @endauth

        </div>

    </header>



    {{-- =========================================================
        MAIN CONTENT
    ========================================================== --}}

    <main
        class="min-h-0 flex-1 overflow-hidden"
    >


        {{-- =====================================================
            HERO SECTION
        ====================================================== --}}

        <section
            class="
                mx-auto
                flex
                h-full
                max-w-6xl
                items-center
                px-5
                py-5
                sm:px-6
                lg:px-8
                lg:py-7
            "
        >

            <div
                class="
                    grid
                    w-full
                    items-center
                    gap-7
                    lg:grid-cols-[1.08fr_0.92fr]
                    lg:gap-12
                "
            >


                {{-- =================================================
                    LEFT CONTENT
                ================================================== --}}

                <div>


                    {{-- EYEBROW --}}

                    <div class="mb-5 flex items-center gap-3">

                        <span
                            class="h-[2px] w-7 bg-[#D71920]"
                        ></span>

                        <span
                            class="
                                text-[10px]
                                font-bold
                                uppercase
                                tracking-[0.18em]
                                text-[#D71920]
                            "
                        >
                            Employee Management
                        </span>

                    </div>



                    {{-- TITLE --}}

                    <h1
                        class="
                            max-w-2xl
                            text-4xl
                            font-bold
                            leading-[1.05]
                            tracking-[-0.035em]
                            text-[#1F1F1F]
                            sm:text-5xl
                            lg:text-[54px]
                        "
                    >

                        Employee

                        <span class="text-[#D71920]">
                            Performance
                        </span>

                        System

                    </h1>



                    {{-- DESCRIPTION --}}

                    <p
                        class="
                            mt-5
                            max-w-xl
                            text-sm
                            leading-6
                            text-[#737373]
                            lg:text-base
                        "
                    >

                        A centralized platform for managing employee
                        evaluations, performance criteria, and reporting
                        through a clear, structured, and measurable process.

                    </p>



                    {{-- CTA --}}

                    <div
                        class="
                            mt-7
                            flex
                            flex-col
                            gap-2.5
                            sm:flex-row
                        "
                    >

                        @auth

                            <a
                                href="{{ url('/dashboard') }}"
                                class="
                                    inline-flex
                                    items-center
                                    justify-center
                                    gap-2
                                    rounded-md
                                    bg-[#D71920]
                                    px-6
                                    py-3
                                    text-sm
                                    font-semibold
                                    text-white
                                    transition
                                    hover:bg-[#B9141A]
                                "
                            >

                                Open Dashboard

                                <svg
                                    class="h-4 w-4"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M5 12h14M13 6l6 6-6 6"
                                    />

                                </svg>

                            </a>

                        @else

                            <a
                                href="{{ route('login') }}"
                                class="
                                    inline-flex
                                    items-center
                                    justify-center
                                    gap-2
                                    rounded-md
                                    bg-[#D71920]
                                    px-6
                                    py-3
                                    text-sm
                                    font-semibold
                                    text-white
                                    transition
                                    hover:bg-[#B9141A]
                                "
                            >

                                Access the System

                                <svg
                                    class="h-4 w-4"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M5 12h14M13 6l6 6-6 6"
                                    />

                                </svg>

                            </a>

                        @endauth

                    </div>



                    {{-- TRUST LINE --}}

                    <div
                        class="
                            mt-7
                            flex
                            items-center
                            gap-2.5
                            text-[10px]
                            text-[#999999]
                        "
                    >

                        <span
                            class="h-1.5 w-1.5 rounded-full bg-[#D71920]"
                        ></span>

                        <span>
                            Structured
                            <span class="mx-1">•</span>
                            Transparent
                            <span class="mx-1">•</span>
                            Data-driven
                        </span>

                    </div>

                </div>



                {{-- =================================================
                    RIGHT DASHBOARD PREVIEW
                ================================================== --}}

                <div class="relative">


                    {{-- DASHBOARD CARD --}}

                    <div
                        class="
                            overflow-hidden
                            rounded-xl
                            border
                            border-[#E3E3E3]
                            bg-white
                        "
                    >


                        {{-- CARD HEADER --}}

                        <div
                            class="
                                flex
                                items-center
                                justify-between
                                border-b
                                border-[#E8E8E8]
                                px-5
                                py-4
                            "
                        >

                            <div>

                                <p
                                    class="
                                        text-[9px]
                                        font-semibold
                                        uppercase
                                        tracking-[0.15em]
                                        text-[#999999]
                                    "
                                >
                                    Performance Overview
                                </p>

                                <p
                                    class="
                                        mt-1
                                        text-base
                                        font-bold
                                        text-[#1F1F1F]
                                    "
                                >
                                    Evaluation Dashboard
                                </p>

                            </div>


                            {{-- ICON --}}

                            <div
                                class="
                                    flex
                                    h-9
                                    w-9
                                    items-center
                                    justify-center
                                    rounded-md
                                    bg-[#FEF2F2]
                                "
                            >

                                <svg
                                    class="h-5 w-5 text-[#D71920]"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.7"
                                        d="M9 19V6m0 0L6 9m3-3l3 3M15 5v13m0 0l-3-3m3 3l3-3"
                                    />

                                </svg>

                            </div>

                        </div>



                        {{-- SCORE AREA --}}

                        <div class="px-5 py-5">


                            {{-- SCORE --}}

                            <div
                                class="flex items-end justify-between"
                            >

                                <div>

                                    <p
                                        class="text-[11px] text-[#999999]"
                                    >
                                        Average Performance
                                    </p>

                                    <p
                                        class="
                                            mt-0.5
                                            text-4xl
                                            font-bold
                                            tracking-tight
                                            text-[#1F1F1F]
                                        "
                                    >
                                        87.4
                                    </p>

                                </div>


                                {{-- PERCENTAGE --}}

                                <div
                                    class="
                                        mb-1
                                        rounded-full
                                        bg-[#FEF2F2]
                                        px-3
                                        py-1
                                        text-[10px]
                                        font-semibold
                                        text-[#D71920]
                                    "
                                >
                                    +8.2%
                                </div>

                            </div>



                            {{-- PROGRESS --}}

                            <div class="mt-5">

                                <div
                                    class="
                                        mb-2
                                        flex
                                        justify-between
                                        text-[9px]
                                        text-[#999999]
                                    "
                                >

                                    <span>
                                        Performance score
                                    </span>

                                    <span>
                                        87%
                                    </span>

                                </div>


                                <div
                                    class="
                                        h-1.5
                                        overflow-hidden
                                        rounded-full
                                        bg-[#EEEEEE]
                                    "
                                >

                                    <div
                                        class="
                                            h-full
                                            rounded-full
                                            bg-[#D71920]
                                        "
                                        style="width: 87%"
                                    ></div>

                                </div>

                            </div>



                            {{-- STATISTICS --}}

                            <div
                                class="
                                    mt-6
                                    grid
                                    grid-cols-3
                                    gap-3
                                "
                            >


                                {{-- EMPLOYEES --}}

                                <div
                                    class="
                                        border-l-2
                                        border-[#D71920]
                                        pl-3
                                    "
                                >

                                    <p
                                        class="
                                            text-lg
                                            font-bold
                                            text-[#1F1F1F]
                                        "
                                    >
                                        128
                                    </p>

                                    <p
                                        class="
                                            mt-0.5
                                            text-[9px]
                                            text-[#999999]
                                        "
                                    >
                                        Employees
                                    </p>

                                </div>



                                {{-- EVALUATED --}}

                                <div
                                    class="
                                        border-l-2
                                        border-[#E5E5E5]
                                        pl-3
                                    "
                                >

                                    <p
                                        class="
                                            text-lg
                                            font-bold
                                            text-[#1F1F1F]
                                        "
                                    >
                                        94%
                                    </p>

                                    <p
                                        class="
                                            mt-0.5
                                            text-[9px]
                                            text-[#999999]
                                        "
                                    >
                                        Evaluated
                                    </p>

                                </div>



                                {{-- CRITERIA --}}

                                <div
                                    class="
                                        border-l-2
                                        border-[#E5E5E5]
                                        pl-3
                                    "
                                >

                                    <p
                                        class="
                                            text-lg
                                            font-bold
                                            text-[#1F1F1F]
                                        "
                                    >
                                        12
                                    </p>

                                    <p
                                        class="
                                            mt-0.5
                                            text-[9px]
                                            text-[#999999]
                                        "
                                    >
                                        Criteria
                                    </p>

                                </div>

                            </div>

                        </div>



                        {{-- SYSTEM STATUS --}}

                        <div
                            class="
                                border-t
                                border-[#E8E8E8]
                                bg-[#FAFAFA]
                                px-5
                                py-3.5
                            "
                        >

                            <div
                                class="
                                    flex
                                    items-center
                                    justify-between
                                "
                            >

                                <div
                                    class="
                                        flex
                                        items-center
                                        gap-2
                                    "
                                >

                                    <span
                                        class="
                                            h-2
                                            w-2
                                            rounded-full
                                            bg-[#22A06B]
                                        "
                                    ></span>

                                    <span
                                        class="
                                            text-[10px]
                                            font-medium
                                            text-[#666666]
                                        "
                                    >
                                        System operational
                                    </span>

                                </div>


                                <span
                                    class="
                                        text-[9px]
                                        uppercase
                                        tracking-[0.12em]
                                        text-[#AAAAAA]
                                    "
                                >
                                    Real-time
                                </span>

                            </div>

                        </div>

                    </div>



                    {{-- BRAND ACCENT --}}

                    <div
                        class="
                            absolute
                            -bottom-3
                            -left-3
                            -z-10
                            h-16
                            w-16
                            rounded-lg
                            bg-[#D71920]
                        "
                    ></div>

                </div>

            </div>

        </section>



        {{-- =====================================================
            FEATURES
        ====================================================== --}}

        <section
            class="
                hidden
                shrink-0
                border-y
                border-[#E6E6E6]
                bg-white
                sm:block
            "
        >

            <div
                class="
                    mx-auto
                    max-w-6xl
                    px-6
                    py-4
                    lg:px-8
                "
            >

                <div
                    class="
                        grid
                        gap-6
                        md:grid-cols-3
                    "
                >


                    {{-- FEATURE 1 --}}

                    <div
                        class="flex items-center gap-3"
                    >

                        <div
                            class="
                                flex
                                h-9
                                w-9
                                shrink-0
                                items-center
                                justify-center
                                rounded-md
                                bg-[#FEF2F2]
                            "
                        >

                            <svg
                                class="h-4 w-4 text-[#D71920]"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.7"
                                    d="M9 12l2 2 4-4m5.6-3.8A11.9 11.9 0 0112 2.9a11.9 11.9 0 01-8.6 3.3A12 12 0 0012 21a12 12 0 008.6-14.8z"
                                />

                            </svg>

                        </div>


                        <div>

                            <h3
                                class="
                                    text-xs
                                    font-bold
                                    text-[#1F1F1F]
                                "
                            >
                                Structured Evaluation
                            </h3>

                            <p
                                class="
                                    mt-0.5
                                    text-[9px]
                                    text-[#737373]
                                "
                            >
                                Standardized assessment workflows.
                            </p>

                        </div>

                    </div>



                    {{-- FEATURE 2 --}}

                    <div
                        class="flex items-center gap-3"
                    >

                        <div
                            class="
                                flex
                                h-9
                                w-9
                                shrink-0
                                items-center
                                justify-center
                                rounded-md
                                bg-[#FEF2F2]
                            "
                        >

                            <svg
                                class="h-4 w-4 text-[#D71920]"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.7"
                                    d="M4 5h16v14H4z"
                                />

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.7"
                                    d="M8 12l3 3 5-6"
                                />

                            </svg>

                        </div>


                        <div>

                            <h3
                                class="
                                    text-xs
                                    font-bold
                                    text-[#1F1F1F]
                                "
                            >
                                Centralized Reports
                            </h3>

                            <p
                                class="
                                    mt-0.5
                                    text-[9px]
                                    text-[#737373]
                                "
                            >
                                Evaluations in one place.
                            </p>

                        </div>

                    </div>



                    {{-- FEATURE 3 --}}

                    <div
                        class="flex items-center gap-3"
                    >

                        <div
                            class="
                                flex
                                h-9
                                w-9
                                shrink-0
                                items-center
                                justify-center
                                rounded-md
                                bg-[#FEF2F2]
                            "
                        >

                            <svg
                                class="h-4 w-4 text-[#D71920]"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.7"
                                    d="M4 19V5m0 14h16"
                                />

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.7"
                                    d="M8 16v-5m4 5V8m4 8v-7"
                                />

                            </svg>

                        </div>


                        <div>

                            <h3
                                class="
                                    text-xs
                                    font-bold
                                    text-[#1F1F1F]
                                "
                            >
                                Performance Insights
                            </h3>

                            <p
                                class="
                                    mt-0.5
                                    text-[9px]
                                    text-[#737373]
                                "
                            >
                                Track trends and improvement areas.
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </section>

    </main>



    {{-- =========================================================
        FOOTER
    ========================================================== --}}

    <footer
        class="
            h-[48px]
            shrink-0
            bg-[#1F1F1F]
        "
    >

        <div
            class="
                mx-auto
                flex
                h-full
                max-w-6xl
                items-center
                justify-between
                px-5
                sm:px-6
                lg:px-8
            "
        >


            {{-- FOOTER BRAND --}}

            <div
                class="
                    flex
                    items-center
                    gap-3
                "
            >

                <img
                    src="{{ asset('images/logo.png') }}"
                    alt="AIA"
                    class="h-6 w-auto"
                >

                <span
                    class="
                        hidden
                        h-4
                        w-px
                        bg-white/20
                        sm:block
                    "
                ></span>

                <span
                    class="
                        hidden
                        text-[9px]
                        text-neutral-400
                        sm:block
                    "
                >
                    Employee Performance System
                </span>

            </div>



            {{-- COPYRIGHT --}}

            <div
                class="
                    text-[9px]
                    uppercase
                    tracking-[0.12em]
                    text-neutral-500
                "
            >

                © {{ date('Y') }} AIA

            </div>

        </div>

    </footer>

</body>

</html>
