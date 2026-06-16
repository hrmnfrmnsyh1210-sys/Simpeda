@extends('layout-admin.main-layout-admin')

@section('title', 'Pengaturan Sistem')

@section('content')

    {{-- Header --}}
    <div class="mb-6">
        <div class="flex items-center gap-2 text-sm text-gray-500 mb-2">
            <a href="{{ route('admin.dashboard') }}" class="text-primary hover:underline">Dashboard</a>
            <i class="bi bi-chevron-right text-[10px]"></i>
            <span class="text-gray-400">Pengaturan</span>
        </div>
        <h1 class="font-grotesk text-2xl font-bold text-gray-800 tracking-tight">Pengaturan Sistem</h1>
        <p class="text-sm text-gray-500 mt-1">Informasi dan statistik sistem SiMPeDa.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Kolom Kiri: Info Sistem --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Statistik Database --}}
            <div class="bg-white rounded-radius border border-[#e2e8f0] shadow-sm p-6">
                <h3 class="font-bold text-gray-700 mb-5 flex items-center gap-2 text-sm">
                    <i class="bi bi-database text-primary"></i> Statistik Database
                </h3>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    @php
                        $dbStats = [
                            ['label' => 'Pengaduan', 'val' => $stats['total_pengaduan'], 'icon' => 'bi-megaphone', 'color' => 'text-primary', 'bg' => 'bg-primary-light'],
                            ['label' => 'Pengguna', 'val' => $stats['total_users'], 'icon' => 'bi-people', 'color' => 'text-violet-600', 'bg' => 'bg-violet-50'],
                            ['label' => 'Log Aktivitas', 'val' => $stats['total_logs'], 'icon' => 'bi-clock-history', 'color' => 'text-amber-600', 'bg' => 'bg-amber-50'],
                        ];
                    @endphp
                    @foreach($dbStats as $ds)
                        <div class="{{ $ds['bg'] }} rounded-xl p-4 text-center">
                            <div class="{{ $ds['color'] }} text-2xl mb-2"><i class="bi {{ $ds['icon'] }}"></i></div>
                            <div class="font-grotesk font-bold text-gray-800 text-2xl">{{ number_format($ds['val']) }}</div>
                            <div class="text-[10px] text-gray-500 uppercase font-bold tracking-wider mt-1">{{ $ds['label'] }}</div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Info Aplikasi --}}
            <div class="bg-white rounded-radius border border-[#e2e8f0] shadow-sm p-6">
                <h3 class="font-bold text-gray-700 mb-5 flex items-center gap-2 text-sm">
                    <i class="bi bi-info-circle text-primary"></i> Informasi Aplikasi
                </h3>
                <div class="space-y-3 text-sm">
                    @php
                        $appInfos = [
                            ['label' => 'Nama Aplikasi',   'val' => 'SiMPeDa — Sistem Manajemen Pengaduan Desa'],
                            ['label' => 'Versi',           'val' => 'v1.0.0'],
                            ['label' => 'Framework',       'val' => 'Laravel ' . app()->version()],
                            ['label' => 'PHP Version',     'val' => phpversion()],
                            ['label' => 'Lingkungan',      'val' => ucfirst(config('app.env'))],
                            ['label' => 'Zona Waktu',      'val' => config('app.timezone')],
                            ['label' => 'Tanggal Server',  'val' => now()->isoFormat('dddd, D MMMM Y — HH:mm')],
                        ];
                    @endphp
                    @foreach($appInfos as $info)
                        <div class="flex items-start gap-4 py-2.5 border-b border-gray-50 last:border-0">
                            <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider w-36 shrink-0 pt-0.5">{{ $info['label'] }}</span>
                            <span class="text-gray-700 font-medium">{{ $info['val'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Aksi --}}
        <div class="space-y-5">

            {{-- Akun Aktif --}}
            <div class="bg-white rounded-radius border border-[#e2e8f0] shadow-sm p-5">
                <h3 class="font-bold text-gray-700 mb-3 text-sm flex items-center gap-2">
                    <i class="bi bi-person-check text-primary"></i> Sesi Aktif
                </h3>
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-violet-500 to-indigo-600 flex items-center justify-center text-white font-bold text-sm">
                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                    </div>
                    <div>
                        <div class="font-bold text-gray-800 text-sm">{{ Auth::user()->name }}</div>
                        <div class="text-[11px] text-gray-400">{{ Auth::user()->email }}</div>
                        <span class="mt-1 inline-block px-2 py-0.5 bg-violet-50 text-violet-700 text-[9px] font-bold rounded-full uppercase">
                            {{ Auth::user()->role }}
                        </span>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="w-full py-2 bg-red-50 text-red-600 font-bold rounded-lg text-xs hover:bg-red-100 transition-all flex items-center justify-center gap-2">
                        <i class="bi bi-box-arrow-right"></i> Keluar dari Sistem
                    </button>
                </form>
            </div>

            {{-- Link Cepat --}}
            <div class="bg-white rounded-radius border border-[#e2e8f0] shadow-sm p-5">
                <h3 class="font-bold text-gray-700 mb-3 text-sm flex items-center gap-2">
                    <i class="bi bi-lightning text-primary"></i> Navigasi Cepat
                </h3>
                <div class="space-y-2">
                    @php
                        $quickLinks = [
                            ['label' => 'Semua Pengaduan', 'route' => 'admin.pengaduan.index', 'icon' => 'bi-megaphone', 'color' => 'text-primary'],
                            ['label' => 'Manajemen Akun',  'route' => 'admin.users.index',     'icon' => 'bi-people',    'color' => 'text-violet-600'],
                            ['label' => 'Kategori',        'route' => 'admin.kategori.index',  'icon' => 'bi-tags',      'color' => 'text-green-600'],
                            ['label' => 'Log Aktivitas',   'route' => 'admin.log.index',       'icon' => 'bi-clock-history', 'color' => 'text-amber-600'],
                        ];
                    @endphp
                    @foreach($quickLinks as $ql)
                        <a href="{{ route($ql['route']) }}"
                            class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-bg-base transition-all text-xs font-bold text-gray-600 hover:text-gray-800">
                            <i class="bi {{ $ql['icon'] }} {{ $ql['color'] }} text-base w-5 text-center"></i>
                            {{ $ql['label'] }}
                            <i class="bi bi-chevron-right ml-auto text-gray-300 text-[10px]"></i>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

@endsection
