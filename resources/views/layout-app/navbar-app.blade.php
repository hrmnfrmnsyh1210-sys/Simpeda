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
                    <span class="text-[10px] text-white/60 leading-none" id="nav-sub">Sistem Manajemen
                        Pengaduan Desa</span>
                </div>
            </a>

            {{-- Desktop Nav --}}
            <nav class="hidden md:flex items-center gap-1">
                <a href="{{ route('beranda') }}"
                    class="nav-link px-4 py-2 rounded-lg text-sm font-medium text-white/80 hover:text-white hover:bg-white/10 transition-all">Beranda</a>
                <a href="{{ route('profil-desa') }}"
                    class="nav-link px-4 py-2 rounded-lg text-sm font-medium text-white/80 hover:text-white hover:bg-white/10 transition-all">Profil
                    Desa</a>
                <a href="{{ route('pengaduan') }}"
                    class="nav-link px-4 py-2 rounded-lg text-sm font-medium text-white/80 hover:text-white hover:bg-white/10 transition-all">Buat
                    Pengaduan </a>
                <a href="{{ route('pengumuman.index') }}"
                    class="nav-link px-4 py-2 rounded-lg text-sm font-medium text-white/80 hover:text-white hover:bg-white/10 transition-all">Pengumuman</a>
                <a href="{{ route('faq.index') }}"
                    class="nav-link px-4 py-2 rounded-lg text-sm font-medium text-white/80 hover:text-white hover:bg-white/10 transition-all">FAQ</a>
                <a href="{{ route('tentang') }}"
                    class="nav-link px-4 py-2 rounded-lg text-sm font-medium text-white/80 hover:text-white hover:bg-white/10 transition-all">Tentang</a>
                <a href="{{ route('riwayat') }}"
                    class="nav-link px-4 py-2 rounded-lg text-sm font-medium text-white/80 hover:text-white hover:bg-white/10 transition-all">Riwayat
                    Pengaduan </a>
            </nav>
            {{-- CTA --}}
            <div class="hidden md:flex items-center gap-3">
                @auth
                    @if (in_array(auth()->user()->role, ['admin', 'superadmin']))
                        <a href="{{ route('admin.dashboard') }}"
                            class="px-4 py-2 text-sm font-semibold text-white/80 hover:text-white hover:bg-white/10 rounded-xl transition-all">
                            Dashboard
                        </a>
                    @elseif (auth()->user()->role === 'masyarakat')
                        <a href="{{ route('warga.dashboard') }}"
                            class="px-4 py-2 text-sm font-semibold text-white/80 hover:text-white hover:bg-white/10 rounded-xl transition-all">
                            Dashboard
                        </a>
                    @endif
                    <span class="text-sm font-medium text-white/90 max-w-[160px] truncate" title="{{ auth()->user()->name }}">
                        Halo, {{ auth()->user()->name }}
                    </span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="px-4 py-2 bg-white text-brand-700 text-sm font-bold rounded-xl hover:bg-brand-50 transition-all shadow-sm">
                            Keluar
                        </button>
                    </form>
                @else
                    <a href="{{ route('register') }}"
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
                @if (auth()->user()->role === 'masyarakat')
                    <a href="{{ route('warga.dashboard') }}"
                        class="block px-3 py-2 rounded-lg text-sm font-medium text-white/80 hover:text-white hover:bg-white/10 transition">Dashboard</a>
                @endif
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
            <a href="{{ route('faq.index') }}"
                class="block px-3 py-2 rounded-lg text-sm font-medium text-white/80 hover:text-white hover:bg-white/10 transition">FAQ</a>
            <a href="{{ route('riwayat') }}"
                class="block px-3 py-2 rounded-lg text-sm font-medium text-white/80 hover:text-white hover:bg-white/10 transition">Riwayat
                Pengaduan</a>
            <a href="{{ route('tentang') }}"
                class="block px-3 py-2 rounded-lg text-sm font-medium text-white/80 hover:text-white hover:bg-white/10 transition">Tentang</a>
            <div class="pt-2 border-t border-white/10 flex gap-2">
                @auth
                    <span class="flex-1 px-3 py-2 text-sm font-medium text-white/90 truncate">Halo, {{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="flex-1">
                        @csrf
                        <button type="submit"
                            class="w-full text-center px-3 py-2 rounded-lg text-sm font-semibold bg-white text-brand-700 hover:bg-brand-50 transition">Keluar</button>
                    </form>
                @else
                    <a href="{{ route('register') }}"
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
</script>