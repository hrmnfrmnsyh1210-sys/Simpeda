<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistem Pengaduan Warga') SiMPeDa</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    {{-- Syne dihapus, Plus Jakarta Sans ditambah weight 800 --}}
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        // display sekarang pakai font yang sama dengan body
                        display: ['Plus Jakarta Sans', 'sans-serif'],
                        body: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            DEFAULT: '#1a56db',
                            dark: '#1240a8',
                            light: '#e8effd',
                        },
                    },
                    boxShadow: {
                        card: '0 12px 48px rgba(26,86,219,.16)',
                    },
                },
            },
        }
    </script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            -webkit-font-smoothing: antialiased;
        }

        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.025'/%3E%3C/svg%3E");
            pointer-events: none;
            z-index: 0;
        }

        body::after {
            content: '';
            position: fixed;
            top: -200px;
            right: -200px;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(26, 86, 219, .07) 0%, transparent 70%);
            pointer-events: none;
            z-index: 0;
        }

        .panel-deco::before {
            content: '';
            position: absolute;
            bottom: -120px;
            left: -80px;
            width: 400px;
            height: 400px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .06);
        }

        .panel-deco::after {
            content: '';
            position: absolute;
            top: -60px;
            right: -100px;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .04);
        }
    </style>

    @stack('styles')
</head>

<body class="min-h-screen bg-[#f0f4ff] text-slate-900">

    <div class="relative z-10 flex min-h-screen">

        {{-- ===== Panel Kiri — Branding ===== --}}
        <aside
            class="panel-deco hidden lg:flex w-[420px] shrink-0 flex-col justify-between bg-[#1a56db] overflow-hidden relative px-10 py-12">

            {{-- Logo --}}
            <div class="relative z-10 flex items-center gap-3">
                <div class="w-11 h-11 rounded-xl bg-white/15 border border-white/20 flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                    </svg>
                </div>
                <div>
                    {{-- SiMPeDa name --}}
                    <div class="font-extrabold text-xl text-white tracking-tight">SiMPeDa</div>
                    <div class="text-white/60 text-xs mt-0.5">Sistem Manajemen Pengaduan Desa</div>
                </div>
            </div>

            {{-- Hero --}}
            <div class="relative z-10">
                <div
                    class="inline-flex items-center gap-1.5 bg-white/10 border border-white/[.18] rounded-full px-3 py-1 text-xs text-white/85 mb-6">
                    <span class="w-1.5 h-1.5 rounded-full bg-green-400 inline-block"></span>
                    Sistem aktif &amp; siap melayani
                </div>
                {{-- Judul hero: turun dari extrabold ke bold --}}
                <h1 class="font-extrabold text-[36px] text-white leading-[1.15] tracking-tight mb-4">
                    Suara warga,<br>ditindak nyata.
                </h1>
                <p class="text-white/65 text-sm leading-relaxed">
                    Platform digital untuk menyampaikan pengaduan, saran, dan aspirasi warga secara transparan dan
                    terstruktur.
                </p>
            </div>

            {{-- Stats --}}
            <div class="relative z-10 grid grid-cols-2 gap-3">
                <div class="bg-white/[.08] border border-white/[.12] rounded-xl p-4">
                    {{-- Angka statistik: turun ke font-bold --}}
                    <div class="font-extrabold text-[28px] text-white leading-none">99%</div>
                    <div class="text-white/55 text-[11px] mt-1">Pengaduan diproses</div>
                </div>
                <div class="bg-white/[.08] border border-white/[.12] rounded-xl p-4">
                    <div class="font-extrabold text-[28px] text-white leading-none">&lt;24j</div>
                    <div class="text-white/55 text-[11px] mt-1">Rata-rata respons</div>
                </div>
            </div>
        </aside>

        {{-- ===== Panel Kanan — Slot konten ===== --}}
        <main class="flex-1 flex items-center justify-center px-6 py-8">
            <div class="w-full max-w-[440px]">

                @if (session('error'))
                    <div
                        class="flex items-start gap-2 bg-red-50 border border-red-200 rounded-xl px-4 py-3 text-sm text-red-600 mb-5">
                        <svg class="w-4 h-4 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <circle cx="12" cy="12" r="10" />
                            <line x1="12" y1="8" x2="12" y2="12" />
                            <line x1="12" y1="16" x2="12.01" y2="16" />
                        </svg>
                        {{ session('error') }}
                    </div>
                @endif

                @if (session('success'))
                    <div class="bg-green-50 border border-green-200 rounded-xl px-4 py-3 text-sm text-green-700 mb-5">
                        {{ session('success') }}
                    </div>
                @endif

                @yield('content')

            </div>
        </main>

    </div>

    @stack('scripts')
</body>

</html>