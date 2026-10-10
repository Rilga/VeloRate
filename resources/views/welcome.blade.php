<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Employee Performance System</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @endif

    <style>
        :root {
            --brand-orange: #FB5105;
            --brand-orange-dark: #E54600;
            --charcoal: #181818;
            --text: #242424;
            --muted: #707070;
            --surface: #FAFAF8;
            --border: #E8E6E2;
        }

        [x-cloak] {
            display: none !important;
        }

        body {
            font-family: 'Instrument Sans', sans-serif;
        }
    </style>
</head>

<body
    class="min-h-screen bg-[var(--surface)] text-[var(--text)]"
    x-data="{ open: false }"
>

    <!-- =========================
         HEADER
    ========================== -->
    <header class="border-b border-[var(--border)] bg-white">

        <div class="mx-auto flex h-[72px] max-w-6xl items-center justify-between px-6 lg:px-8">

            <!-- BRAND -->
            <a href="/" class="flex items-center gap-3">

                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-[var(--brand-orange)]">
                    <span class="text-sm font-bold tracking-tight text-white">
                        PP
                    </span>
                </div>

                <div class="leading-none">
                    <div class="text-sm font-bold tracking-tight text-[var(--charcoal)]">
                        PIT PET
                    </div>

                    <div class="mt-1 text-[9px] font-medium uppercase tracking-[0.18em] text-neutral-400">
                        Employee Performance
                    </div>
                </div>

            </a>


            <!-- DESKTOP NAV -->
            <nav class="hidden items-center gap-3 lg:flex">

                @auth
                    <a
                        href="{{ url('/dashboard') }}"
                        class="rounded-md border border-neutral-300 px-5 py-2 text-sm font-medium text-neutral-700 transition hover:border-neutral-800 hover:text-neutral-900"
                    >
                        Dashboard
                    </a>
                @else
                    <a
                        href="{{ route('login') }}"
                        class="rounded-md bg-[var(--charcoal)] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[var(--brand-orange)]"
                    >
                        Log in
                    </a>
                @endauth

            </nav>


            <!-- MOBILE BUTTON -->
            <button
                @click="open = !open"
                class="flex h-10 w-10 items-center justify-center rounded-md border border-neutral-200 lg:hidden"
                aria-label="Toggle menu"
            >

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


        <!-- MOBILE MENU -->
        <div
            x-show="open"
            x-cloak
            x-transition
            class="border-t border-[var(--border)] bg-white px-6 py-4 lg:hidden"
        >

            @auth
                <a
                    href="{{ url('/dashboard') }}"
                    class="block rounded-md border border-neutral-200 px-4 py-3 text-center text-sm font-medium"
                >
                    Dashboard
                </a>
            @else
                <a
                    href="{{ route('login') }}"
                    class="block rounded-md bg-[var(--charcoal)] px-4 py-3 text-center text-sm font-semibold text-white"
                >
                    Log in
                </a>
            @endauth

        </div>

    </header>



    <!-- =========================
         MAIN
    ========================== -->
    <main>

        <section class="mx-auto max-w-6xl px-6 py-16 lg:px-8 lg:py-24">

            <div class="grid items-center gap-16 lg:grid-cols-[1.15fr_0.85fr]">


                <!-- LEFT CONTENT -->
                <div>

                    <!-- EYEBROW -->
                    <div class="mb-7 flex items-center gap-3">

                        <span class="h-[2px] w-8 bg-[var(--brand-orange)]"></span>

                        <span class="text-xs font-bold uppercase tracking-[0.18em] text-[var(--brand-orange)]">
                            Employee Management
                        </span>

                    </div>


                    <!-- TITLE -->
                    <h1 class="max-w-2xl text-4xl font-bold leading-[1.08] tracking-[-0.035em] text-[var(--charcoal)] sm:text-5xl lg:text-6xl">

                        Employee

                        <span class="text-[var(--brand-orange)]">
                            Performance
                        </span>

                        System

                    </h1>


                    <!-- DESCRIPTION -->
                    <p class="mt-6 max-w-xl text-base leading-7 text-[var(--muted)] lg:text-lg">

                        A centralized platform for managing employee evaluations,
                        performance criteria, and reporting with a clear,
                        structured, and measurable approach.

                    </p>


                    <!-- CTA -->
                    <div class="mt-9 flex flex-col gap-3 sm:flex-row">

                        @auth

                            <a
                                href="{{ url('/dashboard') }}"
                                class="inline-flex items-center justify-center gap-2 rounded-md bg-[var(--brand-orange)] px-6 py-3.5 text-sm font-semibold text-white transition hover:bg-[var(--brand-orange-dark)]"
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
                                class="inline-flex items-center justify-center gap-2 rounded-md bg-[var(--charcoal)] px-6 py-3.5 text-sm font-semibold text-white transition hover:bg-[var(--brand-orange)]"
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


                    <!-- TRUST LINE -->
                    <div class="mt-10 flex items-center gap-3 text-xs text-neutral-400">

                        <div class="h-1.5 w-1.5 rounded-full bg-[var(--brand-orange)]"></div>

                        <span>
                            Structured • Transparent • Data-driven
                        </span>

                    </div>

                </div>



                <!-- RIGHT VISUAL -->
                <div class="relative">

                    <!-- MAIN PANEL -->
                    <div class="relative overflow-hidden rounded-xl border border-[var(--border)] bg-white">

                        <!-- PANEL HEADER -->
                        <div class="flex items-center justify-between border-b border-[var(--border)] px-6 py-5">

                            <div>

                                <p class="text-xs font-semibold uppercase tracking-wider text-neutral-400">
                                    Performance Overview
                                </p>

                                <p class="mt-1 text-lg font-bold text-[var(--charcoal)]">
                                    Evaluation Dashboard
                                </p>

                            </div>

                            <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#FFF0EA]">

                                <svg
                                    class="h-5 w-5 text-[var(--brand-orange)]"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.7"
                                        d="M9 19V6m0 0l-3 3m3-3l3 3M15 5v13m0 0l-3-3m3 3l3-3"
                                    />
                                </svg>

                            </div>

                        </div>


                        <!-- SCORE -->
                        <div class="px-6 py-7">

                            <div class="flex items-end justify-between">

                                <div>

                                    <p class="text-xs text-neutral-400">
                                        Average Performance
                                    </p>

                                    <p class="mt-1 text-4xl font-bold tracking-tight text-[var(--charcoal)]">
                                        87.4
                                    </p>

                                </div>

                                <div class="mb-1 rounded-full bg-[#FFF0EA] px-3 py-1 text-xs font-semibold text-[var(--brand-orange)]">
                                    +8.2%
                                </div>

                            </div>


                            <!-- BAR -->
                            <div class="mt-6">

                                <div class="mb-2 flex justify-between text-[10px] text-neutral-400">

                                    <span>Performance score</span>
                                    <span>87%</span>

                                </div>

                                <div class="h-2 overflow-hidden rounded-full bg-neutral-100">

                                    <div
                                        class="h-full rounded-full bg-[var(--brand-orange)]"
                                        style="width: 87%"
                                    ></div>

                                </div>

                            </div>


                            <!-- MINI STATS -->
                            <div class="mt-7 grid grid-cols-3 gap-3">

                                <div class="border-l-2 border-[var(--brand-orange)] pl-3">

                                    <p class="text-xl font-bold text-[var(--charcoal)]">
                                        128
                                    </p>

                                    <p class="mt-1 text-[10px] text-neutral-400">
                                        Employees
                                    </p>

                                </div>


                                <div class="border-l-2 border-neutral-200 pl-3">

                                    <p class="text-xl font-bold text-[var(--charcoal)]">
                                        94%
                                    </p>

                                    <p class="mt-1 text-[10px] text-neutral-400">
                                        Evaluated
                                    </p>

                                </div>


                                <div class="border-l-2 border-neutral-200 pl-3">

                                    <p class="text-xl font-bold text-[var(--charcoal)]">
                                        12
                                    </p>

                                    <p class="mt-1 text-[10px] text-neutral-400">
                                        Criteria
                                    </p>

                                </div>

                            </div>

                        </div>


                        <!-- STATUS -->
                        <div class="border-t border-[var(--border)] bg-[#FAFAF8] px-6 py-4">

                            <div class="flex items-center justify-between">

                                <div class="flex items-center gap-2">

                                    <span class="h-2 w-2 rounded-full bg-green-500"></span>

                                    <span class="text-xs font-medium text-neutral-600">
                                        System operational
                                    </span>

                                </div>

                                <span class="text-[10px] uppercase tracking-wider text-neutral-400">
                                    Real-time
                                </span>

                            </div>

                        </div>

                    </div>


                    <!-- SMALL ACCENT -->
                    <div class="absolute -bottom-4 -left-4 -z-10 h-20 w-20 rounded-lg bg-[var(--brand-orange)]"></div>

                </div>

            </div>

        </section>



        <!-- =========================
             FEATURES
        ========================== -->

        <section class="border-y border-[var(--border)] bg-white">

            <div class="mx-auto max-w-6xl px-6 py-12 lg:px-8">

                <div class="grid gap-8 md:grid-cols-3">


                    <!-- FEATURE -->
                    <div class="flex gap-4">

                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-md bg-[#FFF0EA]">

                            <svg
                                class="h-5 w-5 text-[var(--brand-orange)]"
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

                            <h3 class="text-sm font-bold text-[var(--charcoal)]">
                                Structured Evaluation
                            </h3>

                            <p class="mt-1 text-xs leading-5 text-neutral-500">
                                Standardized criteria and assessment workflows.
                            </p>

                        </div>

                    </div>


                    <!-- FEATURE -->
                    <div class="flex gap-4">

                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-md bg-[#FFF0EA]">

                            <svg
                                class="h-5 w-5 text-[var(--brand-orange)]"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.7"
                                    d="M7 12l3 3 7-7"
                                />

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.7"
                                    d="M4 5h16v14H4z"
                                />

                            </svg>

                        </div>

                        <div>

                            <h3 class="text-sm font-bold text-[var(--charcoal)]">
                                Centralized Reports
                            </h3>

                            <p class="mt-1 text-xs leading-5 text-neutral-500">
                                Keep evaluations and employee records in one place.
                            </p>

                        </div>

                    </div>


                    <!-- FEATURE -->
                    <div class="flex gap-4">

                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-md bg-[#FFF0EA]">

                            <svg
                                class="h-5 w-5 text-[var(--brand-orange)]"
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

                            <h3 class="text-sm font-bold text-[var(--charcoal)]">
                                Performance Insights
                            </h3>

                            <p class="mt-1 text-xs leading-5 text-neutral-500">
                                Track performance trends and identify improvement areas.
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </section>

    </main>



    <!-- =========================
         FOOTER
    ========================== -->

    <footer class="bg-[var(--charcoal)]">

        <div class="mx-auto flex max-w-6xl flex-col gap-3 px-6 py-6 sm:flex-row sm:items-center sm:justify-between lg:px-8">

            <div class="text-xs font-semibold text-white">
                PIT PET
            </div>

            <div class="text-[10px] uppercase tracking-[0.16em] text-neutral-500">
                © {{ date('Y') }} PT. XYZ · Employee Performance System
            </div>

        </div>

    </footer>

</body>
</html>
