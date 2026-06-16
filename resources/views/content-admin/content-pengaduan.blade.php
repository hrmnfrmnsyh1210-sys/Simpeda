@extends('layout-admin.main-layout-admin')

@section('title', 'Daftar Pengaduan')

@section('content')
    {{-- Header Halaman --}}
    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-sm text-gray-500 mb-2">
                {{-- Sesuaikan route dashboard Anda (admin atau superadmin) --}}
                <a href="{{ route('admin.dashboard') }}" class="text-primary hover:underline">Dashboard</a>
                <i class="bi bi-chevron-right text-[10px]"></i>
                <span class="text-gray-400">Pengaduan</span>
            </div>
            <h1 class="font-grotesk text-2xl font-bold text-gray-800 tracking-tight">Manajemen Pengaduan</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola dan pantau seluruh laporan aspirasi masyarakat.</p>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('admin.pengaduan.exportPdf', array_filter(['status' => request('status'), 'kategori' => request('kategori'), 'search' => request('search')])) }}"
               target="_blank"
               class="px-4 py-2 bg-white border border-[#e2e8f0] rounded-lg text-xs font-bold text-gray-600 hover:bg-red-50 hover:border-red-200 hover:text-red-600 transition-all flex items-center gap-2 shadow-sm">
                <i class="bi bi-file-earmark-pdf"></i> Ekspor PDF
            </a>
        </div>
    </div>

    {{-- Filter & Statistik Ringkas --}}
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-4 mb-6">
        @php
            $stats = [
                ['label' => 'Total Laporan', 'count' => \App\Models\Pengaduan::count(), 'color' => 'primary', 'icon' => 'bi-megaphone'],
                ['label' => 'Menunggu', 'count' => \App\Models\Pengaduan::where('status', 'Menunggu')->count(), 'color' => 'red-500', 'icon' => 'bi-clock-history'],
                ['label' => 'Sedang Proses', 'count' => \App\Models\Pengaduan::where('status', 'Diproses')->count(), 'color' => 'amber-500', 'icon' => 'bi-arrow-repeat'],
                ['label' => 'Selesai', 'count' => \App\Models\Pengaduan::where('status', 'Selesai')->count(), 'color' => 'blue-500', 'icon' => 'bi-patch-check'],
            ];
        @endphp

        @foreach($stats as $s)
            <div class="bg-white p-4 rounded-radius border border-[#e2e8f0] shadow-sm flex items-center gap-4">
                <div class="w-10 h-10 rounded-xl bg-opacity-10 flex items-center justify-center text-lg"
                    style="background-color: {{ $s['color'] == 'primary' ? '#eef3ff' : 'rgba(0,0,0,0.05)' }}; color: {{ $s['color'] == 'primary' ? '#1a56db' : $s['color'] }}">
                    <i class="bi {{ $s['icon'] }}"></i>
                </div>
                <div>
                    <div class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">{{ $s['label'] }}</div>
                    <div class="font-grotesk text-xl font-bold text-gray-800">{{ number_format($s['count']) }}</div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Tabel Utama --}}
    <div class="bg-white rounded-radius border border-[#e2e8f0] shadow-sm overflow-hidden flex flex-col">
        {{-- Tabel Header/Actions --}}
        <div
            class="px-6 py-4 border-b border-[#e2e8f0] flex flex-col lg:row md:flex-row md:items-center justify-between gap-4 bg-gray-50/30">

            {{-- Form Pencarian & Filter --}}
            <form action="{{ route('admin.pengaduan.index') }}" method="GET" class="flex flex-col md:flex-row gap-3 w-full">
                <div class="relative w-full md:w-64">
                    <i class="bi bi-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari tiket, pelapor..."
                        class="w-full pl-9 pr-4 py-2 bg-white border border-[#e2e8f0] rounded-lg text-xs focus:border-primary outline-none transition-all">
                </div>

                <select name="kategori" onchange="this.form.submit()"
                    class="px-3 py-2 bg-white border border-[#e2e8f0] rounded-lg text-xs font-semibold text-gray-600 focus:border-primary outline-none cursor-pointer transition-all">
                    <option value="">Semua Kategori</option>
                    @foreach(['Infrastruktur', 'Kebersihan', 'Keamanan', 'Administrasi', 'Sosial', 'Lainnya'] as $cat)
                        <option value="{{ $cat }}" {{ request('kategori') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>

                <select name="status" onchange="this.form.submit()"
                    class="px-3 py-2 bg-white border border-[#e2e8f0] rounded-lg text-xs font-semibold text-gray-600 focus:border-primary outline-none cursor-pointer transition-all">
                    <option value="">Semua Status</option>
                    @foreach(['Menunggu', 'Diproses', 'Selesai', 'Ditolak'] as $stat)
                        <option value="{{ $stat }}" {{ request('status') == $stat ? 'selected' : '' }}>{{ $stat }}</option>
                    @endforeach
                </select>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 text-gray-500 font-bold uppercase tracking-wider text-[10px]">
                    <tr>
                        <th class="px-6 py-4 border-b w-10 text-center">No</th>
                        <th class="px-6 py-4 border-b">Tiket & Pelapor</th>
                        <th class="px-6 py-4 border-b">Isi Pengaduan</th>
                        <th class="px-6 py-4 border-b">Kategori & Urgensi</th>
                        <th class="px-6 py-4 border-b">Status</th>
                        <th class="px-6 py-4 border-b text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($pengaduans as $index => $item)
                        <tr class="hover:bg-bg-base/50 transition-colors group">
                            <td class="px-6 py-4 text-xs text-gray-400 text-center">
                                {{ $pengaduans->firstItem() + $index }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-8 h-8 rounded-full bg-primary-light flex items-center justify-center text-primary font-bold text-[10px] shrink-0">
                                        {{ strtoupper(substr($item->nama_pelapor ?? '?', 0, 2)) }}
                                    </div>
                                    <div class="min-w-0">
                                        <div class="text-[10px] font-bold text-primary mb-0.5">#{{ $item->nomor_tiket }}</div>
                                        <div class="text-xs font-bold text-gray-800 truncate">{{ $item->nama_pelapor }}</div>
                                        <div class="text-[10px] text-gray-400">{{ $item->created_at->diffForHumans() }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-xs font-bold text-gray-700 leading-snug">{{ Str::limit($item->judul, 40) }}
                                </div>
                                <div class="text-[10px] text-gray-400 mt-1">{{ Str::limit($item->deskripsi, 60) }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col gap-1">
                                    <span class="text-[10px] font-semibold text-gray-600 italic">
                                        <i class="bi bi-tag text-primary"></i> {{ $item->kategori }}
                                    </span>
                                    @php
                                        $urgencyColor = [
                                            'Tinggi' => 'bg-red-100 text-red-700',
                                            'Sedang' => 'bg-amber-100 text-amber-700',
                                            'Rendah' => 'bg-blue-100 text-blue-700',
                                        ][$item->urgensi] ?? 'bg-gray-100 text-gray-700';
                                    @endphp
                                    <span class="w-fit px-2 py-0.5 rounded text-[9px] font-bold {{ $urgencyColor }}">
                                        {{ strtoupper($item->urgensi) }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($item->status == 'Menunggu')
                                    <span
                                        class="inline-flex items-center gap-1.5 px-2 py-1 rounded-full bg-red-50 text-red-600 text-[10px] font-bold uppercase tracking-wide">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-600 animate-pulse"></span> Menunggu
                                    </span>
                                @elseif($item->status == 'Diproses')
                                    <span
                                        class="inline-flex items-center gap-1.5 px-2 py-1 rounded-full bg-amber-50 text-amber-600 text-[10px] font-bold uppercase tracking-wide">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-600"></span> Diproses
                                    </span>
                                @elseif($item->status == 'Selesai')
                                    <span
                                        class="inline-flex items-center gap-1.5 px-2 py-1 rounded-full bg-green-50 text-green-600 text-[10px] font-bold uppercase tracking-wide">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-600"></span> Selesai
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center gap-1.5 px-2 py-1 rounded-full bg-gray-100 text-gray-600 text-[10px] font-bold uppercase tracking-wide">
                                        Ditolak
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    {{-- Tombol Detail --}}
                                    <a href="{{ route('admin.pengaduan.show', $item->id) }}"
                                        class="w-8 h-8 flex items-center justify-center border border-gray-200 rounded-lg text-gray-400 hover:text-primary hover:border-primary hover:bg-primary-light transition-all"
                                        title="Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    {{-- AKSI CEPAT: Ubah Status (Dropdown) --}}
                                    <div class="relative group/status">
                                        <button
                                            class="w-8 h-8 flex items-center justify-center border border-gray-200 rounded-lg text-gray-400 hover:text-amber-600 hover:border-amber-200 hover:bg-amber-50 transition-all"
                                            title="Ubah Status Cepat">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>

                                        {{-- Dropdown Menu Cepat --}}
                                        <div
                                            class="absolute right-0 bottom-full mb-2 w-40 bg-white border border-gray-100 shadow-xl rounded-xl overflow-hidden z-50 invisible group-hover/status:visible opacity-0 group-hover/status:opacity-100 transition-all transform translate-y-2 group-hover/status:translate-y-0">
                                            <div class="p-2 text-[10px] font-bold text-gray-400 uppercase bg-gray-50 border-b">
                                                Ubah Status</div>
                                            @foreach(['Menunggu', 'Diproses', 'Selesai', 'Ditolak'] as $statusOption)
                                                <form action="{{ route('admin.pengaduan.updateStatus', $item->id) }}" method="POST">
                                                    @csrf @method('PATCH')
                                                    <input type="hidden" name="status" value="{{ $statusOption }}">
                                                    <button type="submit"
                                                        class="w-full text-left px-4 py-2 text-xs hover:bg-primary-light hover:text-primary transition-colors flex items-center gap-2">
                                                        <span
                                                            class="w-1.5 h-1.5 rounded-full {{ $statusOption == 'Menunggu' ? 'bg-red-500' : ($statusOption == 'Diproses' ? 'bg-amber-500' : ($statusOption == 'Selesai' ? 'bg-green-500' : 'bg-gray-400')) }}"></span>
                                                        {{ $statusOption }}
                                                    </button>
                                                </form>
                                            @endforeach
                                        </div>
                                    </div>

                                    {{-- Tombol Hapus (Super Admin Only) --}}
                                    @if(Auth::user()->role === 'superadmin')
                                        <form action="{{ route('admin.pengaduan.destroy', $item->id) }}" method="POST"
                                            onsubmit="return confirm('Hapus pengaduan #{{ $item->nomor_tiket }}?')">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                class="w-8 h-8 flex items-center justify-center border border-gray-200 rounded-lg text-gray-400 hover:text-red-600 hover:border-red-200 hover:bg-red-50 transition-all">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                                <i class="bi bi-inbox text-4xl block mb-2 opacity-20"></i>
                                <p class="text-sm italic">Belum ada pengaduan ditemukan.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($pengaduans->hasPages())
            <div class="px-6 py-4 bg-gray-50 border-t border-[#e2e8f0]">
                {{ $pengaduans->links() }}
            </div>
        @endif
    </div>
@endsection