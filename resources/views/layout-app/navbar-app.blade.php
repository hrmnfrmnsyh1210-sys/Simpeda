<header id="navbar" class="fixed top-0 inset-x-0 z-50 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            {{-- Logo --}}
            <a href="{{ route('beranda') }}" class="flex items-center gap-2.5 group">
                <img src="{{ asset('logo.png') }}" alt="Logo SiMPeDa"
                    class="w-9 h-9 rounded-xl object-contain bg-white p-1 shadow-md">
                <div class="leading-tight">
                    <span class="font-extrabold text-lg text-white tracking-tight leading-none block"
                        id="nav-brand">SiMPeDa</span>
                    <span class="text-[10px] text-white/60 leading-none" id="nav-sub">Sistem Pengaduan
                        Masyarakat Desa</span>
                </div>
            </a>

            {{-- Desktop Nav --}}
            <nav class="hidden md:flex items-center gap-0.5 lg:gap-1">
                <a href="{{ route('beranda') }}"
                    class="nav-link whitespace-nowrap px-2.5 lg:px-3.5 py-2 rounded-lg text-sm font-medium text-white/80 hover:text-white hover:bg-white/10 transition-all">Beranda</a>
                <a href="{{ route('profil-desa') }}"
                    class="nav-link whitespace-nowrap px-2.5 lg:px-3.5 py-2 rounded-lg text-sm font-medium text-white/80 hover:text-white hover:bg-white/10 transition-all">Profil Desa</a>
                <a href="{{ route('pengaduan') }}"
                    class="nav-link whitespace-nowrap px-2.5 lg:px-3.5 py-2 rounded-lg text-sm font-medium text-white/80 hover:text-white hover:bg-white/10 transition-all">Buat Pengaduan</a>
                <a href="{{ route('pengumuman.index') }}"
                    class="nav-link whitespace-nowrap px-2.5 lg:px-3.5 py-2 rounded-lg text-sm font-medium text-white/80 hover:text-white hover:bg-white/10 transition-all">Pengumuman</a>
                <a href="{{ route('tentang') }}"
                    class="nav-link whitespace-nowrap px-2.5 lg:px-3.5 py-2 rounded-lg text-sm font-medium text-white/80 hover:text-white hover:bg-white/10 transition-all">Tentang</a>
                <a href="{{ route('riwayat') }}"
                    class="nav-link whitespace-nowrap px-2.5 lg:px-3.5 py-2 rounded-lg text-sm font-medium text-white/80 hover:text-white hover:bg-white/10 transition-all">Riwayat Pengaduan</a>
            </nav>
            {{-- CTA --}}
            <div class="hidden md:flex items-center gap-3">
                @auth
                    @php
                        $dashboardRoute = in_array(auth()->user()->role, ['admin', 'superadmin'])
                            ? route('admin.dashboard')
                            : route('warga.dashboard');
                    @endphp
                    <div class="relative" id="userMenu">
                        <button type="button" id="userMenuBtn"
                            class="flex items-center gap-2 pl-2 pr-3 py-1.5 rounded-xl hover:bg-white/10 transition-all">
                            <span class="w-8 h-8 rounded-full bg-white/15 flex items-center justify-center text-white font-bold text-xs shrink-0">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </span>
                            <span class="text-sm font-semibold text-white/90 max-w-[110px] truncate">{{ auth()->user()->name }}</span>
                            <svg class="w-3.5 h-3.5 text-white/60 transition-transform" id="userMenuChevron" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div id="userMenuDropdown"
                            class="hidden absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-xl border border-slate-100 overflow-hidden py-1.5">
                            <div class="px-4 py-2.5 border-b border-slate-100">
                                <p class="text-[11px] text-slate-400">Masuk sebagai</p>
                                <p class="text-sm font-bold text-slate-800 truncate">{{ auth()->user()->name }}</p>
                            </div>
                            <a href="{{ $dashboardRoute }}"
                                class="flex items-center gap-2 px-4 py-2.5 text-sm text-slate-600 hover:bg-slate-50 transition-colors">
                                <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                                Dashboard
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full flex items-center gap-2 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('google.redirect') }}"
                        class="px-4 py-2 text-sm font-semibold text-white/90 hover:text-white hover:bg-white/10 rounded-xl transition-all">
                        Daftar
                    </a>
                    <a href="{{ route('login') }}"
                        class="px-4 py-2 bg-white text-brand-700 text-sm font-bold rounded-xl hover:bg-brand-50 transition-all shadow-sm">
                        Masuk
                    </a>
                @endauth
            </div>

            {{-- Mobile Menu Button --}}
            <button id="menuBtn"
                class="md:hidden p-2 rounded-lg text-white/80 hover:text-white hover:bg-white/10 transition">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div id="mobileMenu" class="hidden md:hidden border-t border-white/10 bg-brand-800/95 backdrop-blur-md">
        <div class="px-4 py-3 space-y-1">
            <a href="{{ route('beranda') }}"
                class="block px-3 py-2 rounded-lg text-sm font-medium text-white/80 hover:text-white hover:bg-white/10 transition">Beranda</a>
            @auth
                <a href="{{ in_array(auth()->user()->role, ['admin', 'superadmin']) ? route('admin.dashboard') : route('warga.dashboard') }}"
                    class="block px-3 py-2 rounded-lg text-sm font-medium text-white/80 hover:text-white hover:bg-white/10 transition">Dashboard</a>
            @endauth
            <a href="{{ route('profil-desa') }}"
                class="block px-3 py-2 rounded-lg text-sm font-medium text-white/80 hover:text-white hover:bg-white/10 transition">Profil
                Desa</a>
            <a href="{{ route('pengaduan') }}"
                class="block px-3 py-2 rounded-lg text-sm font-medium text-white/80 hover:text-white hover:bg-white/10 transition">Buat
                Pengaduan</a>
            <a href="{{ route('pengaduan.lacak') }}"
                class="block px-3 py-2 rounded-lg text-sm font-medium text-white/80 hover:text-white hover:bg-white/10 transition">Lacak
                Pengaduan</a>
            <a href="{{ route('pengumuman.index') }}"
                class="block px-3 py-2 rounded-lg text-sm font-medium text-white/80 hover:text-white hover:bg-white/10 transition">Pengumuman</a>
            <a href="{{ route('riwayat') }}"
                class="block px-3 py-2 rounded-lg text-sm font-medium text-white/80 hover:text-white hover:bg-white/10 transition">Riwayat
                Pengaduan</a>
            <a href="{{ route('tentang') }}"
                class="block px-3 py-2 rounded-lg text-sm font-medium text-white/80 hover:text-white hover:bg-white/10 transition">Tentang</a>
            <div class="pt-2 border-t border-white/10 flex gap-2">
                @auth
                    <span class="flex-1 px-3 py-2 text-sm font-medium text-white/90 truncate">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="flex-1">
                        @csrf
                        <button type="submit"
                            class="w-full text-center px-3 py-2 rounded-lg text-sm font-semibold bg-white text-brand-700 hover:bg-brand-50 transition">Keluar</button>
                    </form>
                @else
                    <a href="{{ route('google.redirect') }}"
                        class="flex-1 text-center px-3 py-2 rounded-lg text-sm font-semibold text-white/80 hover:bg-white/10 transition">Daftar</a>
                    <a href="{{ route('login') }}"
                        class="flex-1 text-center px-3 py-2 rounded-lg text-sm font-semibold bg-white text-brand-700 hover:bg-brand-50 transition">Masuk</a>
                @endauth
            </div>
        </div>
    </div>
</header>

{{-- Navbar text color adjustment on scroll --}}
<script>
    const nb = document.getElementById('navbar');
    const brandTxt = document.getElementById('nav-brand');
    const subTxt = document.getElementById('nav-sub');
    const navLinks = document.querySelectorAll('.nav-link');

    window.addEventListener('scroll', () => {
        const scrolled = window.scrollY > 60;
        brandTxt.classList.toggle('text-white', !scrolled);
        brandTxt.classList.toggle('text-brand-700', scrolled);
        subTxt.classList.toggle('text-white/60', !scrolled);
        subTxt.classList.toggle('text-slate-400', scrolled);

        navLinks.forEach(l => {
            l.classList.toggle('text-white/80', !scrolled);
            l.classList.toggle('hover:text-white', !scrolled);
            l.classList.toggle('text-slate-600', scrolled);
            l.classList.toggle('hover:text-brand-700', scrolled);
            l.classList.toggle('hover:bg-white/10', !scrolled);
            l.classList.toggle('hover:bg-brand-50', scrolled);
        });
    });

    // Dropdown menu user (Dashboard + Keluar)
    const userMenuBtn = document.getElementById('userMenuBtn');
    const userMenuDropdown = document.getElementById('userMenuDropdown');
    const userMenuChevron = document.getElementById('userMenuChevron');

    if (userMenuBtn) {
        userMenuBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            userMenuDropdown.classList.toggle('hidden');
            userMenuChevron.classList.toggle('rotate-180');
        });

        document.addEventListener('click', (e) => {
            if (!document.getElementById('userMenu').contains(e.target)) {
                userMenuDropdown.classList.add('hidden');
                userMenuChevron.classList.remove('rotate-180');
            }
        });
    }
</script>