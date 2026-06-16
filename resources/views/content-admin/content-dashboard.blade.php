@extends('layout-admin.main-layout-admin')

@section('title', 'Dashboard')

@section('content')

    @php $isSuperAdmin = $authRole === 'superadmin'; @endphp

    {{-- Welcome Banner --}}
    <div class="relative overflow-hidden rounded-radius p-8 mb-6 text-white bg-gradient-to-br {{ $isSuperAdmin ? 'from-[#0f1f5c] via-[#1240a8] to-[#1a56db]' : 'from-[#0f1f5c] via-[#1240a8] to-[#2d7af0]' }}">
        <div class="relative z-10">
            <div class="text-xs text-white/60 mb-1">{{ now()->locale('id')->isoFormat('dddd, D MMMM Y') }}</div>
            <h2 class="font-grotesk text-2xl font-bold mb-1">
                {{ $isSuperAdmin ? '👑' : '🛡️' }} Selamat datang, {{ $user->name }}!
            </h2>
            <p class="text-sm text-white/70 max-w-lg mb-5">
                {{ $isSuperAdmin ? 'Anda memiliki kendali penuh atas sistem manajemen pengaduan desa SiMPeDa.' : 'Pantau dan kelola pengaduan masyarakat dari dashboard administrator.' }}
            </p>
            <div class="flex gap-3">
                <a href="{{ route('admin.pengaduan.index') }}" class="px-4 py-2 bg-white/20 hover:bg-white/30 border border-white/20 rounded-lg text-xs font-bold transition-all flex items-center gap-2">
                    <i class="bi bi-megaphone"></i> Lihat Pengaduan
                </a>
            </div>
        </div>
        <i class="bi {{ $isSuperAdmin ? 'bi-shield-fill-check' : 'bi-shield-check' }} absolute -right-4 -bottom-4 text-9xl opacity-10"></i>
    </div>

    {{-- Stat Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white p-5 rounded-radius border border-[#e2e8f0] shadow-sm relative overflow-hidden group hover:shadow-md hover:-translate-y-1 transition-all">
            <div class="absolute top-0 left-0 right-0 h-1 bg-primary"></div>
            <div class="flex justify-between items-start">
                <div>
                    <div class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">Total Laporan</div>
                    <div class="font-grotesk text-3xl font-bold text-gray-800">{{ number_format($totalPengaduan) }}</div>
                </div>
                <div class="w-10 h-10 bg-primary-light text-primary rounded-xl flex items-center justify-center text-lg"><i class="bi bi-megaphone"></i></div>
            </div>
        </div>
        <div class="bg-white p-5 rounded-radius border border-[#e2e8f0] shadow-sm relative overflow-hidden group hover:shadow-md hover:-translate-y-1 transition-all">
            <div class="absolute top-0 left-0 right-0 h-1 bg-red-500"></div>
            <div class="flex justify-between items-start">
                <div>
                    <div class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">Belum Diproses</div>
                    <div class="font-grotesk text-3xl font-bold text-gray-800">{{ number_format($pengaduanMasuk) }}</div>
                </div>
                <div class="w-10 h-10 bg-red-50 text-red-500 rounded-xl flex items-center justify-center text-lg"><i class="bi bi-inbox"></i></div>
            </div>
        </div>
        <div class="bg-white p-5 rounded-radius border border-[#e2e8f0] shadow-sm relative overflow-hidden group hover:shadow-md hover:-translate-y-1 transition-all">
            <div class="absolute top-0 left-0 right-0 h-1 bg-amber-500"></div>
            <div class="flex justify-between items-start">
                <div>
                    <div class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">Sedang Proses</div>
                    <div class="font-grotesk text-3xl font-bold text-gray-800">{{ number_format($pengaduanProses) }}</div>
                </div>
                <div class="w-10 h-10 bg-amber-50 text-amber-500 rounded-xl flex items-center justify-center text-lg"><i class="bi bi-arrow-repeat"></i></div>
            </div>
        </div>
        <div class="bg-white p-5 rounded-radius border border-[#e2e8f0] shadow-sm relative overflow-hidden group hover:shadow-md hover:-translate-y-1 transition-all">
            <div class="absolute top-0 left-0 right-0 h-1 bg-blue-500"></div>
            <div class="flex justify-between items-start">
                <div>
                    <div class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">Selesai</div>
                    <div class="font-grotesk text-3xl font-bold text-gray-800">{{ number_format($pengaduanSelesai) }}</div>
                </div>
                <div class="w-10 h-10 bg-blue-50 text-blue-500 rounded-xl flex items-center justify-center text-lg"><i class="bi bi-patch-check"></i></div>
            </div>
        </div>
    </div>

    {{-- Main Content Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Tabel Pengaduan Terbaru --}}
        <div class="lg:col-span-2 bg-white rounded-radius border border-[#e2e8f0] shadow-sm overflow-hidden flex flex-col">

            {{-- Header + Filter --}}
            <div class="px-6 py-4 border-b border-[#e2e8f0] bg-gray-50/30">
                <div class="flex justify-between items-center mb-3">
                    <h3 class="font-bold text-sm text-gray-700 flex items-center gap-2">
                        <i class="bi bi-list-ul text-primary"></i> Pengaduan Terbaru
                    </h3>
                    <a href="{{ route('admin.pengaduan.index') }}" class="text-[11px] font-bold text-primary hover:underline">Lihat Semua</a>
                </div>

                {{-- Filter --}}
                <form action="{{ route('admin.dashboard') }}" method="GET" class="flex flex-col md:flex-row gap-2">
                    <div class="relative w-full md:w-52">
                        <i class="bi bi-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari tiket, pelapor..."
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
                    @if(request('search') || request('kategori') || request('status'))
                        <a href="{{ route('admin.dashboard') }}"
                            class="px-3 py-2 bg-white border border-[#e2e8f0] rounded-lg text-xs font-semibold text-gray-400 hover:text-red-500 hover:border-red-200 transition-all flex items-center gap-1">
                            <i class="bi bi-x-circle"></i> Reset
                        </a>
                    @endif
                </form>
            </div>

            {{-- Tabel --}}
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
                        @forelse($recentPengaduan as $index => $item)
                            <tr class="hover:bg-bg-base/50 transition-colors group">
                                <td class="px-6 py-4 text-xs text-gray-400 text-center">{{ $index + 1 }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-primary-light flex items-center justify-center text-primary font-bold text-[10px] shrink-0">
                                            {{ strtoupper(substr($item->nama_pelapor ?? '?', 0, 2)) }}
                                        </div>
                                        <div class="min-w-0">
                                            <div class="text-[10px] font-bold text-primary mb-0.5">#{{ $item->nomor_tiket }}</div>
                                            <div class="text-xs font-bold text-gray-800 truncate">{{ $item->nama_pelapor ?? '-' }}</div>
                                            <div class="text-[10px] text-gray-400">{{ $item->created_at->diffForHumans() }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-xs font-bold text-gray-700 leading-snug">{{ Str::limit($item->judul, 40) }}</div>
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
                                        <span class="inline-flex items-center gap-1.5 px-2 py-1 rounded-full bg-red-50 text-red-600 text-[10px] font-bold uppercase tracking-wide">
                                            <span class="w-1.5 h-1.5 rounded-full bg-red-600 animate-pulse"></span> Menunggu
                                        </span>
                                    @elseif($item->status == 'Diproses')
                                        <span class="inline-flex items-center gap-1.5 px-2 py-1 rounded-full bg-amber-50 text-amber-600 text-[10px] font-bold uppercase tracking-wide">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-600"></span> Diproses
                                        </span>
                                    @elseif($item->status == 'Selesai')
                                        <span class="inline-flex items-center gap-1.5 px-2 py-1 rounded-full bg-green-50 text-green-600 text-[10px] font-bold uppercase tracking-wide">
                                            <span class="w-1.5 h-1.5 rounded-full bg-green-600"></span> Selesai
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2 py-1 rounded-full bg-gray-100 text-gray-600 text-[10px] font-bold uppercase tracking-wide">
                                            Ditolak
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('admin.pengaduan.show', $item->id) }}"
                                            class="w-8 h-8 flex items-center justify-center border border-gray-200 rounded-lg text-gray-400 hover:text-primary hover:border-primary hover:bg-primary-light transition-all"
                                            title="Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>
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
        </div>

        {{-- Side Column --}}
        <div class="space-y-6">
            {{-- Persentase Status --}}
            <div class="bg-white rounded-radius border border-[#e2e8f0] shadow-sm p-6">
                <h3 class="text-sm font-bold text-gray-700 mb-5 flex items-center gap-2">
                    <i class="bi bi-pie-chart text-primary"></i> Persentase Status
                </h3>
                <div class="space-y-4">
                    @php
                        $divider = $totalPengaduan > 0 ? $totalPengaduan : 1;
                        $stats = [
                            ['label' => 'Selesai',   'val' => $pengaduanSelesai, 'color' => 'bg-green-500'],
                            ['label' => 'Diproses',  'val' => $pengaduanProses,  'color' => 'bg-amber-500'],
                            ['label' => 'Menunggu',  'val' => $pengaduanMasuk,   'color' => 'bg-red-500'],
                        ];
                    @endphp
                    @foreach($stats as $s)
                        <div>
                            <div class="flex justify-between text-[11px] font-bold mb-1.5 uppercase tracking-wide">
                                <span class="text-gray-500">{{ $s['label'] }}</span>
                                <span class="text-gray-800">{{ round(($s['val'] / $divider) * 100) }}%</span>
                            </div>
                            <div class="h-1.5 w-full bg-gray-100 rounded-full overflow-hidden">
                                <div class="h-full {{ $s['color'] }}" style="width: {{ ($s['val'] / $divider) * 100 }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Info Admin --}}
            <div class="bg-white rounded-radius border border-[#e2e8f0] shadow-sm p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-bold text-gray-700 flex items-center gap-2">
                        <i class="bi bi-shield-check text-primary"></i> Admin
                    </h3>
                    <span class="text-xs font-grotesk font-bold text-primary">{{ number_format($totalUser) }} Akun</span>
                </div>
                <p class="text-[11px] text-gray-500 leading-relaxed mb-4">Total akun administrator & superadmin yang memiliki akses ke panel SiMPeDa.</p>
                @if($isSuperAdmin)
                    <a href="{{ route('admin.users.index') }}" class="block text-center py-2 bg-bg-base text-primary text-[11px] font-bold rounded-lg hover:bg-primary-light transition-all">Kelola Admin</a>
                @endif
            </div>
        </div>

    </div>

@endsection