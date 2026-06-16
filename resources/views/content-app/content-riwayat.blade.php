@extends('layout-app.main-app')

@section('title', 'Riwayat Pengaduan — SiMPeDa')

@push('styles')
    <style>
        /* Entrance animation */
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(16px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .anim-1 {
            animation: fadeUp .4s ease both;
        }

        .anim-2 {
            animation: fadeUp .4s .08s ease both;
        }

        .anim-3 {
            animation: fadeUp .4s .16s ease both;
        }

        /* Card row hover */
        .row-card {
            transition: box-shadow .2s, transform .2s;
        }

        .row-card:hover {
            box-shadow: 0 8px 32px rgba(26, 86, 219, .10);
            transform: translateY(-2px);
        }

        .filter-input:focus {
            outline: none;
            border-color: #1a56db;
            box-shadow: 0 0 0 3px rgba(26, 86, 219, .10);
        }
    </style>
@endpush

@section('content')

    {{-- ── HEADER ── --}}
    <section class="bg-brand-600 pt-28 pb-16 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10 pointer-events-none">
            <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                <path d="M0 100 C 20 0 50 0 100 100 Z" fill="white" />
            </svg>
        </div>
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="anim-1">
                <div
                    class="inline-flex items-center gap-2 bg-white/10 border border-white/20 rounded-full px-3 py-1 text-xs text-white/80 mb-3">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Arsip Laporan SiMPeDa
                </div>
                <h1 class="font-extrabold text-3xl sm:text-4xl text-white tracking-tight">Riwayat Pengaduan</h1>
                <p class="text-white/65 text-sm mt-2">Daftar rekaman seluruh pengaduan yang telah masuk ke sistem SiMPeDa.
                </p>
            </div>
        </div>
    </section>

    {{-- ── FILTER BAR ── --}}
    <section class="bg-white border-b border-slate-100 sticky top-16 z-30 anim-2">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
            {{-- PERUBAHAN: Action form diarahkan ke route riwayat --}}
            <form method="GET" action="{{ route('riwayat') }}"
                class="flex flex-col sm:flex-row gap-2.5 items-stretch sm:items-center">

                {{-- Search --}}
                <div class="relative flex-1 min-w-0">
                    <input type="text" name="q" value="{{ request('q') }}"
                        placeholder="Cari nomor tiket atau judul laporan..."
                        class="filter-input w-full h-10 pl-9 pr-4 border border-slate-200 rounded-xl text-sm bg-slate-50 transition-all">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 pointer-events-none"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>

                {{-- Filter Status --}}
                <select name="status"
                    class="filter-input h-10 px-3 border border-slate-200 rounded-xl text-sm bg-slate-50 text-slate-700 transition-all min-w-[140px]">
                    <option value="">Semua Status</option>
                    @foreach(['diterima', 'diverifikasi', 'diproses', 'selesai'] as $s)
                        <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>
                            {{ ucfirst($s) }}
                        </option>
                    @endforeach
                </select>

                <button type="submit"
                    class="h-10 px-5 bg-brand-600 text-white text-sm font-semibold rounded-xl hover:bg-brand-700 transition-all shrink-0">
                    Filter
                </button>

                @if(request()->hasAny(['q', 'status']))
                    {{-- PERUBAHAN: Link reset mengarah kembali ke route riwayat tanpa param --}}
                    <a href="{{ route('riwayat') }}"
                        class="h-10 px-4 flex items-center gap-1.5 border border-slate-200 text-slate-500 text-sm rounded-xl hover:bg-slate-50 transition-all shrink-0">
                        Reset
                    </a>
                @endif
            </form>
        </div>
    </section>

    {{-- ── CONTENT ── --}}
    <section class="py-8 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if($pengaduans->isEmpty())
                <div class="anim-3 flex flex-col items-center justify-center py-24 text-center">
                    <div class="w-16 h-16 rounded-2xl bg-slate-100 flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 01-2 2H6a2 2 0 01-2-2m16 0l-8 4-8-4" />
                        </svg>
                    </div>
                    <p class="font-bold text-slate-700">Data Riwayat Kosong</p>
                    <p class="text-slate-400 text-sm mt-1">Tidak ada riwayat pengaduan yang dapat ditampilkan.</p>
                </div>
            @else
                <div class="anim-3 bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-100">
                                <th class="text-left px-5 py-3.5 text-xs font-bold text-slate-500 uppercase">No. Tiket</th>
                                <th class="text-left px-5 py-3.5 text-xs font-bold text-slate-500 uppercase">Judul Pengaduan
                                </th>
                                <th class="text-left px-5 py-3.5 text-xs font-bold text-slate-500 uppercase">Status</th>
                                <th class="text-left px-5 py-3.5 text-xs font-bold text-slate-500 uppercase">Tanggal</th>
                                <th class="px-5 py-3.5"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach($pengaduans as $item)
                                <tr class="row-card">
                                    <td class="px-5 py-4">
                                        <span class="font-mono font-bold text-brand-700 text-xs bg-brand-50 px-2 py-1 rounded-lg">
                                            {{ $item->nomor_tiket }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-4">
                                        <p class="font-semibold text-slate-800">{{ $item->judul }}</p>
                                    </td>
                                    <td class="px-5 py-4">
                                        @php
                                            $statusColor = match ($item->status) {
                                                'selesai' => 'bg-green-100 text-green-700',
                                                'diproses' => 'bg-blue-100 text-blue-700',
                                                'diverifikasi' => 'bg-violet-100 text-violet-700',
                                                default => 'bg-amber-100 text-amber-700',
                                            };
                                        @endphp
                                        <span class="text-xs font-semibold px-2.5 py-1 rounded-full {{ $statusColor }}">
                                            {{ ucfirst($item->status) }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-4 text-slate-400 text-xs whitespace-nowrap">
                                        {{ $item->created_at->format('d M Y') }}
                                    </td>
                                    <td class="px-5 py-4 text-right">
                                        {{-- PERUBAHAN: Mengarahkan ke halaman lacak desa sesuai nomor tiket --}}
                                        <a href="{{ route('pengaduan.lacak', ['tiket' => $item->nomor_tiket]) }}"
                                            class="text-brand-600 font-bold text-xs hover:underline">
                                            Lihat Detail →
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- PAGINATION --}}
                <div class="mt-8 anim-3">
                    {{ $pengaduans->links() }}
                </div>
            @endif

        </div>
    </section>

@endsection