<aside id="sidebar"
    class="fixed top-0 left-0 w-[260px] h-screen bg-bg-sidebar flex flex-col z-[1000] transition-all duration-300 sidebar-scroll overflow-x-hidden border-r border-white/5">

    {{-- Brand --}}
    <div class="p-5 flex items-center gap-3 border-b border-white/10 flex-shrink-0">
        <div
            class="w-9 h-9 bg-gradient-to-br from-[#2d7af0] to-primary rounded-xl flex items-center justify-center shadow-lg">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.2"
                stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 2L2 7l10 5 10-5-10-5z" />
                <path d="M2 17l10 5 10-5M2 12l10 5 10-5" />
            </svg>
        </div>
        <div class="leading-none">
            <div class="font-grotesk font-bold text-white text-base tracking-tight">SiMPeDa</div>
            <div class="text-[10px] text-white/40 uppercase tracking-wider mt-0.5">Pengaduan</div>
        </div>
    </div>

    {{-- User Info --}}
    @php $authRole = Auth::user()->role; @endphp
    <div class="px-5 py-4 bg-white/5 border-b border-white/5">
        <div class="flex items-center gap-3">
            <div
                class="w-8 h-8 rounded-full bg-gradient-to-br {{ $authRole === 'superadmin' ? 'from-violet-500 to-indigo-600' : 'from-primary to-[#2d7af0]' }} flex items-center justify-center text-white font-bold text-[11px]">
                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
            </div>
            <div class="min-w-0">
                <div class="text-xs font-bold text-white truncate">{{ Auth::user()->name }}</div>
                <div class="text-[10px] mt-0.5 {{ $authRole === 'superadmin' ? 'text-violet-300' : 'text-blue-300' }}">
                    ● {{ $authRole === 'superadmin' ? 'Super Admin' : 'Administrator' }}
                </div>
            </div>
        </div>
    </div>

    {{-- Nav --}}
    <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-6 sidebar-scroll">

        {{-- Section 1: Menu Utama --}}
        <div>
            <label class="px-4 text-[10px] font-bold text-white/30 uppercase tracking-[2px] mb-2 block">Menu
                Utama</label>
            <div class="space-y-1">
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-primary/20 text-blue-300 font-bold border-l-4 border-blue-400' : 'text-white/60 hover:bg-white/5 hover:text-white' }}">
                    <i class="bi bi-grid-1x2"></i> <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.pengaduan.index') }}"
                    class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm transition-all {{ request()->routeIs('admin.pengaduan.index') && request('status') === null && request('kategori') === null ? 'bg-primary/20 text-blue-300 font-bold border-l-4 border-blue-400' : 'text-white/60 hover:bg-white/5 hover:text-white' }}">
                    <i class="bi bi-megaphone"></i> <span class="flex-1">Semua Pengaduan</span>
                    @php $cMasuk = \App\Models\Pengaduan::where('status', 'Menunggu')->count(); @endphp
                    @if($cMasuk > 0)
                        <span class="bg-red-500 text-white text-[10px] px-1.5 py-0.5 rounded-full">{{ $cMasuk }}</span>
                    @endif
                </a>
                <a href="{{ route('admin.pengaduan.index', ['status' => 'Diproses']) }}"
                    class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm transition-all {{ request()->routeIs('admin.pengaduan.index') && request('status') === 'Diproses' ? 'bg-primary/20 text-blue-300 font-bold border-l-4 border-blue-400' : 'text-white/60 hover:bg-white/5 hover:text-white' }}">
                    <i class="bi bi-arrow-repeat"></i> <span>Sedang Diproses</span>
                </a>
            </div>
        </div>

        {{-- Section 2: Management --}}
        <div>
            <label class="px-4 text-[10px] font-bold text-white/30 uppercase tracking-[2px] mb-2 block">Manajemen
                Data</label>
            <div class="space-y-1">
                @if($authRole === 'superadmin')
                    <a href="{{ route('admin.users.index') }}"
                        class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm transition-all {{ request()->routeIs('admin.users.*') ? 'bg-primary/20 text-blue-300 font-bold border-l-4 border-blue-400' : 'text-white/60 hover:bg-white/5 hover:text-white' }}">
                        <i class="bi bi-people"></i> <span>Manajemen Pengguna</span>
                    </a>
                @endif
                <a href="{{ route('admin.kategori.index') }}"
                    class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm transition-all {{ request()->routeIs('admin.kategori.*') ? 'bg-primary/20 text-blue-300 font-bold border-l-4 border-blue-400' : 'text-white/60 hover:bg-white/5 hover:text-white' }}">
                    <i class="bi bi-tags"></i> <span>Kategori</span>
                </a>
                <a href="{{ route('admin.struktur.index') }}"
                    class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm transition-all {{ request()->routeIs('admin.struktur.*') ? 'bg-primary/20 text-blue-300 font-bold border-l-4 border-blue-400' : 'text-white/60 hover:bg-white/5 hover:text-white' }}">
                    <i class="bi bi-diagram-3"></i> <span>Struktur Organisasi</span>
                </a>
            </div>
        </div>

        {{-- Section: Konten Publik --}}
        <div>
            <label class="px-4 text-[10px] font-bold text-white/30 uppercase tracking-[2px] mb-2 block">Konten Publik</label>
            <div class="space-y-1">
                <a href="{{ route('admin.pengumuman.index') }}"
                    class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm transition-all {{ request()->routeIs('admin.pengumuman.*') ? 'bg-primary/20 text-blue-300 font-bold border-l-4 border-blue-400' : 'text-white/60 hover:bg-white/5 hover:text-white' }}">
                    <i class="bi bi-megaphone"></i> <span>Pengumuman</span>
                </a>
            </div>
        </div>

        {{-- Section 3: Super Admin Only --}}
        @if($authRole === 'superadmin')
            <div>
                <label class="px-4 text-[10px] font-bold text-blue-400/60 uppercase tracking-[2px] mb-2 block">System
                    Settings</label>
                <div class="space-y-1">
                    <a href="{{ route('admin.log.index') }}"
                        class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm transition-all {{ request()->routeIs('admin.log.*') ? 'bg-primary/20 text-blue-300 font-bold border-l-4 border-blue-400' : 'text-white/60 hover:bg-white/5 hover:text-white' }}">
                        <i class="bi bi-clock-history"></i> <span>Log Aktivitas</span>
                    </a>
                    <a href="{{ route('admin.pengaturan') }}"
                        class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm transition-all {{ request()->routeIs('admin.pengaturan') ? 'bg-primary/20 text-blue-300 font-bold border-l-4 border-blue-400' : 'text-white/60 hover:bg-white/5 hover:text-white' }}">
                        <i class="bi bi-sliders2"></i> <span>Pengaturan</span>
                    </a>
                </div>
            </div>
        @endif
    </nav>

    <div class="p-4 border-t border-white/5 flex items-center justify-between">
        <div class="flex items-center gap-2">
            <span class="w-1.5 h-1.5 rounded-full bg-blue-400"></span>
            <span class="text-[9px] text-white/40 font-bold tracking-widest uppercase">{{ $authRole }}</span>
        </div>
        <span class="text-[9px] text-white/20">V1.0</span>
    </div>
</aside>