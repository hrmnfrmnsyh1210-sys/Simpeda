@extends('layout-admin.main-layout-admin')

@section('title', 'Kategori Pengaduan')

@section('content')

    {{-- Header --}}
    <div class="mb-6">
        <div class="flex items-center gap-2 text-sm text-gray-500 mb-2">
            <a href="{{ route('admin.dashboard') }}" class="text-primary hover:underline">Dashboard</a>
            <i class="bi bi-chevron-right text-[10px]"></i>
            <span class="text-gray-400">Kategori</span>
        </div>
        <h1 class="font-grotesk text-2xl font-bold text-gray-800 tracking-tight">Kategori Pengaduan</h1>
        <p class="text-sm text-gray-500 mt-1">Statistik pengaduan berdasarkan kategori.</p>
    </div>

    {{-- Grid Kategori --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        @foreach($stats as $s)
            @php
                $colorMap = [
                    'blue'   => ['bg' => 'bg-blue-50',   'text' => 'text-blue-600',   'bar' => 'bg-blue-500',   'border' => 'border-blue-200'],
                    'green'  => ['bg' => 'bg-green-50',  'text' => 'text-green-600',  'bar' => 'bg-green-500',  'border' => 'border-green-200'],
                    'red'    => ['bg' => 'bg-red-50',    'text' => 'text-red-600',    'bar' => 'bg-red-500',    'border' => 'border-red-200'],
                    'purple' => ['bg' => 'bg-purple-50', 'text' => 'text-purple-600', 'bar' => 'bg-purple-500', 'border' => 'border-purple-200'],
                    'amber'  => ['bg' => 'bg-amber-50',  'text' => 'text-amber-600',  'bar' => 'bg-amber-500',  'border' => 'border-amber-200'],
                    'gray'   => ['bg' => 'bg-gray-100',  'text' => 'text-gray-600',   'bar' => 'bg-gray-400',   'border' => 'border-gray-200'],
                ];
                $c = $colorMap[$s['color']] ?? $colorMap['gray'];
                $pct = $totalSemua > 0 ? round(($s['total'] / $totalSemua) * 100) : 0;
            @endphp
            <div class="bg-white rounded-radius border border-[#e2e8f0] shadow-sm p-6 hover:shadow-md hover:-translate-y-0.5 transition-all">
                {{-- Icon & Nama --}}
                <div class="flex items-center gap-4 mb-5">
                    <div class="w-12 h-12 rounded-xl {{ $c['bg'] }} {{ $c['text'] }} flex items-center justify-center text-2xl">
                        <i class="bi {{ $s['icon'] }}"></i>
                    </div>
                    <div>
                        <h3 class="font-grotesk font-bold text-gray-800 text-base">{{ $s['nama'] }}</h3>
                        <div class="text-[11px] text-gray-400">{{ $s['total'] }} total pengaduan</div>
                    </div>
                    <div class="ml-auto font-grotesk text-2xl font-bold {{ $c['text'] }}">{{ $pct }}%</div>
                </div>

                {{-- Progress bar --}}
                <div class="h-2 w-full bg-gray-100 rounded-full overflow-hidden mb-4">
                    <div class="h-full {{ $c['bar'] }} rounded-full transition-all" style="width: {{ $pct }}%"></div>
                </div>

                {{-- Detail status --}}
                <div class="grid grid-cols-2 gap-2">
                    <div class="bg-red-50 rounded-lg p-2 text-center">
                        <div class="font-grotesk font-bold text-red-600 text-lg">{{ $s['menunggu'] }}</div>
                        <div class="text-[9px] text-gray-500 uppercase font-bold tracking-wider">Menunggu</div>
                    </div>
                    <div class="bg-amber-50 rounded-lg p-2 text-center">
                        <div class="font-grotesk font-bold text-amber-600 text-lg">{{ $s['diproses'] }}</div>
                        <div class="text-[9px] text-gray-500 uppercase font-bold tracking-wider">Diproses</div>
                    </div>
                    <div class="bg-green-50 rounded-lg p-2 text-center">
                        <div class="font-grotesk font-bold text-green-600 text-lg">{{ $s['selesai'] }}</div>
                        <div class="text-[9px] text-gray-500 uppercase font-bold tracking-wider">Selesai</div>
                    </div>
                    <div class="bg-gray-100 rounded-lg p-2 text-center">
                        <div class="font-grotesk font-bold text-gray-500 text-lg">{{ $s['ditolak'] }}</div>
                        <div class="text-[9px] text-gray-500 uppercase font-bold tracking-wider">Ditolak</div>
                    </div>
                </div>

                <a href="{{ route('admin.pengaduan.index', ['kategori' => $s['nama']]) }}"
                    class="mt-4 block text-center py-2 bg-bg-base {{ $c['text'] }} text-[11px] font-bold rounded-lg hover:{{ $c['bg'] }} transition-all">
                    Lihat Pengaduan <i class="bi bi-arrow-right ml-1"></i>
                </a>
            </div>
        @endforeach
    </div>

@endsection
