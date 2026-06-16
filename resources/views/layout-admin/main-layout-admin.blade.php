<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — SiMPeDa</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&family=Space+Grotesk:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#1a56db',
                        'primary-dark': '#1240a8',
                        'primary-light': '#eef3ff',
                        'bg-base': '#f0f4fc',
                        'bg-sidebar': '#0f1f5c',
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                        grotesk: ['Space Grotesk', 'sans-serif'],
                    },
                    borderRadius: {
                        'radius': '12px',
                    }
                }
            }
        }
    </script>
    <style>
        /* Custom scrollbar untuk sidebar agar tipis */
        .sidebar-scroll::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-scroll::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }
    </style>
    @stack('styles')
</head>

<body class="bg-bg-base text-[#1a202c] min-h-screen flex overflow-x-hidden">

    <div id="sidebar-overlay" class="fixed inset-0 bg-black/45 z-[999] hidden" onclick="toggleSidebar()"></div>

    @include('layout-admin.sidebar-layout-admin')

    <div id="main-content" class="flex-1 flex flex-col min-w-0 transition-all duration-300 ml-[260px] max-md:ml-0">

        {{-- Topbar --}}
        @php $authRole = Auth::user()->role; @endphp
        <header
            class="h-[64px] bg-white border-b border-[#e2e8f0] flex items-center px-6 gap-4 sticky top-0 z-[900] shadow-sm">
            <button
                class="w-9 h-9 flex items-center justify-center border border-[#e2e8f0] rounded-lg hover:bg-bg-base transition-colors"
                onclick="toggleSidebar()">
                <i class="bi bi-list text-xl"></i>
            </button>

            <div class="flex-1 max-w-[380px] ml-2 hidden sm:block">
                <div class="relative">
                    <i class="bi bi-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                    <input type="text" placeholder="Cari pengaduan..."
                        class="w-full pl-9 pr-4 py-2 bg-bg-base border border-[#e2e8f0] rounded-full text-sm focus:border-primary focus:bg-white outline-none transition-all">
                </div>
            </div>

            <div class="flex-grow"></div>

            {{-- Role Chip --}}
            <div class="flex items-center gap-1.5 px-3 py-1 rounded-full font-semibold text-[11px] uppercase tracking-wider
                {{ $authRole === 'superadmin' ? 'bg-[#ede9fe] text-[#5b21b6]' : 'bg-primary-light text-primary' }}">
                <i class="bi {{ $authRole === 'superadmin' ? 'bi-shield-fill-check' : 'bi-shield-check' }}"></i>
                {{ $authRole === 'superadmin' ? 'Super Admin' : 'Admin' }}
            </div>

            <div class="w-[1px] h-7 bg-[#e2e8f0] mx-1"></div>

            {{-- User Menu --}}
            <div class="relative group" id="user-wrapper">
                <button onclick="toggleUserMenu()"
                    class="flex items-center gap-2.5 p-1.5 rounded-lg hover:bg-bg-base transition-all text-left">
                    <div
                        class="w-8 h-8 rounded-full flex items-center justify-center text-white font-bold text-xs
                        {{ $authRole === 'superadmin' ? 'bg-gradient-to-br from-violet-600 to-indigo-600' : 'bg-gradient-to-br from-primary to-[#2d7af0]' }}">
                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                    </div>
                    <div class="hidden lg:block leading-tight">
                        <div class="text-[12px] font-bold truncate max-w-[120px]">{{ Auth::user()->name }}</div>
                        <div class="text-[10px] text-gray-500 capitalize">{{ $authRole }}</div>
                    </div>
                    <i class="bi bi-chevron-down text-[10px] text-gray-400"></i>
                </button>

                {{-- Dropdown --}}
                <div id="user-dropdown"
                    class="absolute right-0 mt-2 w-52 bg-white border border-[#e2e8f0] rounded-radius shadow-xl hidden overflow-hidden p-1.5 z-[999]">
                    <div class="px-3 py-2 border-b border-gray-50 mb-1">
                        <div class="text-xs font-bold">{{ Auth::user()->name }}</div>
                        <div class="text-[10px] text-gray-500">{{ Auth::user()->email }}</div>
                    </div>
                    <a href="#"
                        class="flex items-center gap-2 px-3 py-2 text-xs text-gray-600 hover:bg-bg-base rounded-md transition-all">
                        <i class="bi bi-person"></i> Profil Saya
                    </a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="w-full flex items-center gap-2 px-3 py-2 text-xs text-red-600 hover:bg-red-50 rounded-md transition-all">
                            <i class="bi bi-box-arrow-right"></i> Keluar
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <main class="p-4 lg:p-7 flex-1">
            @yield('content')
        </main>

        <footer
            class="p-4 lg:px-7 bg-white border-t border-[#edf2f7] flex flex-wrap justify-between items-center text-[11px] text-gray-500 gap-2">
            <span>&copy; {{ date('Y') }} <strong class="text-primary">SiMPeDa</strong> — Sistem Manajemen
                Pengaduan Desa</span>
            <span class="opacity-50 tracking-widest">V1.0.0</span>
        </footer>
    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('main-content');
        const overlay = document.getElementById('sidebar-overlay');
        const userDropdown = document.getElementById('user-dropdown');

        function toggleSidebar() {
            if (window.innerWidth <= 768) {
                sidebar.classList.toggle('-translate-x-full');
                overlay.classList.toggle('hidden');
            } else {
                sidebar.classList.toggle('w-0');
                sidebar.classList.toggle('-translate-x-full');
                mainContent.classList.toggle('ml-0');
                mainContent.classList.toggle('ml-[260px]');
            }
        }

        function toggleUserMenu() {
            userDropdown.classList.toggle('hidden');
        }

        window.addEventListener('click', function (e) {
            if (!document.getElementById('user-wrapper').contains(e.target)) {
                userDropdown.classList.add('hidden');
            }
        });
    </script>
    @stack('scripts')
</body>

</html>