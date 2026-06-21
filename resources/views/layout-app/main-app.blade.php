<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SiMPeDa — Sistem Pengaduan Warga')</title>
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#eef3ff',
                            100: '#dce6fd',
                            200: '#c1d0fb',
                            300: '#97b0f8',
                            400: '#6585f3',
                            500: '#4160ed',
                            600: '#1a56db',
                            700: '#1240a8',
                            800: '#143082',
                            900: '#152c6a',
                        },
                    },
                    animation: {
                        'fade-up': 'fadeUp .5s ease both',
                        'fade-up-d1': 'fadeUp .5s .1s ease both',
                        'fade-up-d2': 'fadeUp .5s .2s ease both',
                        'fade-up-d3': 'fadeUp .5s .3s ease both',
                        'float': 'float 4s ease-in-out infinite',
                    },
                    keyframes: {
                        fadeUp: {
                            from: { opacity: '0', transform: 'translateY(24px)' },
                            to: { opacity: '1', transform: 'translateY(0)' },
                        },
                        float: {
                            '0%,100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-10px)' },
                        },
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

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        ::-webkit-scrollbar-thumb {
            background: #94a3b8;
            border-radius: 99px;
        }

        /* Noise texture overlay */
        .noise::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.03'/%3E%3C/svg%3E");
            pointer-events: none;
            z-index: 0;
        }

        /* Hero mesh gradient */
        .hero-bg {
            background: linear-gradient(135deg, #0f1f5c 0%, #1a56db 45%, #2d7af0 100%);
        }

        /* Card hover */
        .feature-card {
            transition: transform .25s, box-shadow .25s;
        }

        .feature-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 48px rgba(26, 86, 219, .14);
        }

        /* Form focus */
        .form-input:focus {
            outline: none;
            border-color: #1a56db;
            box-shadow: 0 0 0 3px rgba(26, 86, 219, .12);
        }

        /* Step tracker line */
        .step-line::after {
            content: '';
            position: absolute;
            top: 20px;
            left: 50%;
            width: 100%;
            height: 2px;
            background: #e2e8f0;
        }

        .step-line.done::after {
            background: #1a56db;
        }

        /* Tab active */
        .tab-btn.active {
            background: #1a56db;
            color: #fff;
            box-shadow: 0 4px 14px rgba(26, 86, 219, .3);
        }

        /* Timeline track */
        .tl-track {
            position: relative;
        }

        .tl-track::before {
            content: '';
            position: absolute;
            left: 19px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: #e2e8f0;
        }

        /* Navbar scroll effect via JS class */
        #navbar.scrolled {
            background: rgba(255, 255, 255, .97);
            box-shadow: 0 1px 24px rgba(0, 0, 0, .08);
        }
    </style>

    @stack('styles')
</head>

<body class="bg-slate-50 text-slate-900">

    @include('layout-app.navbar-app')

    <main>
        @yield('content')
    </main>

    @include('layout-app.footer-app')

    @stack('scripts')

    <script>
        // Navbar scroll effect
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            navbar.classList.toggle('scrolled', window.scrollY > 20);
        });

        // Mobile menu toggle
        const menuBtn = document.getElementById('menuBtn');
        const mobileMenu = document.getElementById('mobileMenu');
        menuBtn?.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    </script>
</body>

</html>