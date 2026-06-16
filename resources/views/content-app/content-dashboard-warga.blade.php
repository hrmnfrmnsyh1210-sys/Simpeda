@extends('layout-app.main-app')

@section('title', 'Dashboard Warga — SiMPeDa')

@section('content')

    {{-- ── HERO / WELCOME ── --}}
    <section class="hero-bg pt-28 pb-24 relative overflow-hidden noise">
        <div class="absolute inset-0 opacity-10 pointer-events-none">
            <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                <path d="M0 100 C 25 10 60 10 100 100 Z" fill="white" />
            </svg>
        </div>
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="animate-fade-up">
                <span
                    class="inline-flex items-center gap-2 bg-white/10 border border-white/20 rounded-full px-3 py-1 text-xs text-white/80 mb-3">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Dashboard Warga SiMPeDa
                </span>
                <h1 class="font-extrabold text-3xl sm:text-4xl text-white tracking-tight">
                    Selamat datang, {{ auth()->user()->name }} 👋
                </h1>
                <p class="text-white/70 text-sm mt-2 max-w-2xl">
                    Sampaikan keluhan dan aspirasi Anda kepada perangkat desa secara online, lalu pantau
                    perkembangan setiap laporan dalam satu halaman.
                </p>
            </div>
        </div>
    </section>

    {{-- ── KARTU AKSI + STATISTIK (overlap hero) ── --}}
    <section class="relative z-20 -mt-14 pb-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-5 flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl px-4 py-3 text-sm animate-fade-up">
                    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            {{-- 3 Aksi Utama --}}
            <div class="grid sm:grid-cols-3 gap-4">

                {{-- Buat Pengaduan --}}
                <a href="{{ route('pengaduan') }}"
                    class="feature-card group bg-white rounded-2xl border border-slate-100 shadow-sm p-5 flex items-start gap-4 animate-fade-up">
                    <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-bold text-slate-800 group-hover:text-brand-700 transition-colors">Buat Pengaduan</p>
                        <p class="text-slate-500 text-xs mt-0.5">Laporkan keluhan baru disertai foto & lokasi.</p>
                    </div>
                </a>

                {{-- Lacak Pengaduan --}}
                <a href="{{ route('pengaduan.lacak') }}"
                    class="feature-card group bg-white rounded-2xl border border-slate-100 shadow-sm p-5 flex items-start gap-4 animate-fade-up-d1">
                    <div class="w-12 h-12 rounded-xl bg-brand-100 text-brand-600 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-bold text-slate-800 group-hover:text-brand-700 transition-colors">Lacak Pengaduan</p>
                        <p class="text-slate-500 text-xs mt-0.5">Cek status laporan lewat nomor tiket.</p>
                    </div>
                </a>

                {{-- Riwayat Pengaduan Saya --}}
                <a href="#riwayat"
                    class="feature-card group bg-white rounded-2xl border border-slate-100 shadow-sm p-5 flex items-start gap-4 animate-fade-up-d2">
                    <div class="w-12 h-12 rounded-xl bg-violet-100 text-violet-600 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-bold text-slate-800 group-hover:text-brand-700 transition-colors">Riwayat Pengaduan Saya</p>
                        <p class="text-slate-500 text-xs mt-0.5">Lihat seluruh laporan yang pernah Anda ajukan.</p>
                    </div>
                </a>
            </div>

            {{-- Statistik ringkas --}}
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mt-4">
                @php
                    $cards = [
                        ['label' => 'Total Laporan', 'val' => $stats['total'], 'color' => 'text-slate-800', 'dot' => 'bg-slate-300'],
                        ['label' => 'Menunggu', 'val' => $stats['menunggu'], 'color' => 'text-amber-600', 'dot' => 'bg-amber-400'],
                        ['label' => 'Diproses', 'val' => $stats['diproses'], 'color' => 'text-blue-600', 'dot' => 'bg-blue-500'],
                        ['label' => 'Selesai', 'val' => $stats['selesai'], 'color' => 'text-emerald-600', 'dot' => 'bg-emerald-500'],
                    ];
                @endphp
                @foreach ($cards as $c)
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm px-5 py-4">
                        <div class="flex items-center gap-2 text-xs font-medium text-slate-500">
                            <span class="w-2 h-2 rounded-full {{ $c['dot'] }}"></span> {{ $c['label'] }}
                        </div>
                        <p class="text-2xl font-extrabold mt-1 {{ $c['color'] }}">{{ $c['val'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ── RIWAYAT PENGADUAN SAYA ── --}}
    <section id="riwayat" class="py-10 scroll-mt-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="flex items-center justify-between mb-4">
                <h2 class="font-bold text-lg text-slate-800">Riwayat Pengaduan Saya</h2>
            </div>

            {{-- Filter bar --}}
            <form method="GET" action="{{ route('warga.dashboard') }}"
                class="flex flex-col sm:flex-row gap-2.5 items-stretch sm:items-center mb-5">
                <div class="relative flex-1 min-w-0">
                    <input type="text" name="q" value="{{ request('q') }}"
                        placeholder="Cari nomor tiket atau judul laporan..."
                        class="form-input w-full h-10 pl-9 pr-4 border border-slate-200 rounded-xl text-sm bg-white transition-all">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 pointer-events-none"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <select name="status"
                    class="form-input h-10 px-3 border border-slate-200 rounded-xl text-sm bg-white text-slate-700 transition-all min-w-[150px]">
                    <option value="">Semua Status</option>
                    @foreach (['Menunggu', 'Diproses', 'Selesai', 'Ditolak'] as $s)
                        <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ $s }}</option>
                    @endforeach
                </select>
                <button type="submit"
                    class="h-10 px-5 bg-brand-600 text-white text-sm font-semibold rounded-xl hover:bg-brand-700 transition-all shrink-0">
                    Filter
                </button>
                @if (request()->hasAny(['q', 'status']))
                    <a href="{{ route('warga.dashboard') }}"
                        class="h-10 px-4 flex items-center border border-slate-200 text-slate-500 text-sm rounded-xl hover:bg-slate-50 transition-all shrink-0">
                        Reset
                    </a>
                @endif
            </form>

            @if ($pengaduans->isEmpty())
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm flex flex-col items-center justify-center py-20 text-center">
                    <div class="w-16 h-16 rounded-2xl bg-slate-100 flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 01-2 2H6a2 2 0 01-2-2m16 0l-8 4-8-4" />
                        </svg>
                    </div>
                    <p class="font-bold text-slate-700">Belum ada pengaduan</p>
                    <p class="text-slate-400 text-sm mt-1">Anda belum pernah mengajukan laporan. Mulai dengan membuat pengaduan baru.</p>
                    <a href="{{ route('pengaduan') }}"
                        class="mt-5 inline-flex items-center gap-2 h-10 px-5 bg-brand-600 text-white text-sm font-semibold rounded-xl hover:bg-brand-700 transition-all">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        Buat Pengaduan
                    </a>
                </div>
            @else
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="bg-slate-50 border-b border-slate-100">
                                    <th class="text-left px-5 py-3.5 text-xs font-bold text-slate-500 uppercase">No. Tiket</th>
                                    <th class="text-left px-5 py-3.5 text-xs font-bold text-slate-500 uppercase">Judul Pengaduan</th>
                                    <th class="text-left px-5 py-3.5 text-xs font-bold text-slate-500 uppercase">Kategori</th>
                                    <th class="text-left px-5 py-3.5 text-xs font-bold text-slate-500 uppercase">Status</th>
                                    <th class="text-left px-5 py-3.5 text-xs font-bold text-slate-500 uppercase">Tanggal</th>
                                    <th class="px-5 py-3.5"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @foreach ($pengaduans as $item)
                                    @php
                                        $badge = match ($item->status) {
                                            'Selesai' => 'bg-emerald-100 text-emerald-700',
                                            'Diproses' => 'bg-blue-100 text-blue-700',
                                            'Ditolak' => 'bg-rose-100 text-rose-700',
                                            default => 'bg-amber-100 text-amber-700',
                                        };
                                    @endphp
                                    <tr class="hover:bg-slate-50/60 transition-colors">
                                        <td class="px-5 py-4">
                                            <span class="font-mono font-bold text-brand-700 text-xs bg-brand-50 px-2 py-1 rounded-lg">
                                                {{ $item->nomor_tiket }}
                                            </span>
                                        </td>
                                        <td class="px-5 py-4">
                                            <p class="font-semibold text-slate-800 line-clamp-1 max-w-[260px]">{{ $item->judul }}</p>
                                        </td>
                                        <td class="px-5 py-4 text-slate-500 text-xs">{{ $item->kategori }}</td>
                                        <td class="px-5 py-4">
                                            <span class="text-xs font-semibold px-2.5 py-1 rounded-full {{ $badge }}">{{ $item->status }}</span>
                                        </td>
                                        <td class="px-5 py-4 text-slate-400 text-xs whitespace-nowrap">
                                            {{ $item->created_at->format('d M Y') }}
                                        </td>
                                        <td class="px-5 py-4 text-right">
                                            <a href="{{ route('pengaduan.lacak', ['tiket' => $item->nomor_tiket]) }}"
                                                class="text-brand-600 font-bold text-xs hover:underline whitespace-nowrap">
                                                Lihat Detail →
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mt-6">
                    {{ $pengaduans->links() }}
                </div>
            @endif
        </div>
    </section>

@endsection
