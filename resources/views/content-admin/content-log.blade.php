@extends('layout-admin.main-layout-admin')

@section('title', 'Log Aktivitas')

@section('content')

    {{-- Header --}}
    <div class="mb-6">
        <div class="flex items-center gap-2 text-sm text-gray-500 mb-2">
            <a href="{{ route('admin.dashboard') }}" class="text-primary hover:underline">Dashboard</a>
            <i class="bi bi-chevron-right text-[10px]"></i>
            <span class="text-gray-400">Log Aktivitas</span>
        </div>
        <h1 class="font-grotesk text-2xl font-bold text-gray-800 tracking-tight">Log Aktivitas</h1>
        <p class="text-sm text-gray-500 mt-1">Riwayat seluruh aktivitas yang dilakukan oleh admin dan superadmin.</p>
    </div>

    {{-- Filter --}}
    <form action="{{ route('admin.log.index') }}" method="GET"
        class="mb-5 flex flex-col sm:flex-row gap-3 bg-white border border-[#e2e8f0] rounded-radius p-4 shadow-sm">
        <div class="relative flex-1">
            <i class="bi bi-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
            <input type="text" name="action" value="{{ request('action') }}"
                placeholder="Cari aksi (Update Status, Hapus...)"
                class="w-full pl-9 pr-4 py-2 bg-bg-base border border-[#e2e8f0] rounded-lg text-xs focus:border-primary outline-none">
        </div>
        <button type="submit"
            class="px-4 py-2 bg-primary text-white rounded-lg text-xs font-bold hover:bg-primary-dark transition-all">
            <i class="bi bi-funnel mr-1"></i> Filter
        </button>
        @if(request()->hasAny(['action', 'user_id']))
            <a href="{{ route('admin.log.index') }}"
                class="px-4 py-2 bg-gray-100 text-gray-600 rounded-lg text-xs font-bold hover:bg-gray-200 transition-all flex items-center gap-1">
                <i class="bi bi-x-circle"></i> Reset
            </a>
        @endif
    </form>

    {{-- Tabel Log --}}
    <div class="bg-white rounded-radius border border-[#e2e8f0] shadow-sm overflow-hidden">
        <div class="px-6 py-4 bg-gray-50/50 border-b border-[#e2e8f0]">
            <h3 class="font-bold text-sm text-gray-700 flex items-center gap-2">
                <i class="bi bi-clock-history text-primary"></i> Riwayat Aktivitas
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead class="bg-gray-50 text-gray-500 font-bold uppercase tracking-wider text-[10px]">
                    <tr>
                        <th class="px-6 py-4 border-b">Waktu</th>
                        <th class="px-6 py-4 border-b">Admin</th>
                        <th class="px-6 py-4 border-b">Aksi</th>
                        <th class="px-6 py-4 border-b">Target</th>
                        <th class="px-6 py-4 border-b">Keterangan</th>
                        <th class="px-6 py-4 border-b">IP</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($logs as $log)
                        @php
                            $actionColors = [
                                'Update Status'   => 'bg-amber-50 text-amber-700',
                                'Hapus Pengaduan' => 'bg-red-50 text-red-700',
                                'Tambah Akun'     => 'bg-green-50 text-green-700',
                                'Hapus Akun'      => 'bg-red-50 text-red-700',
                                'Aktifkan Akun'   => 'bg-green-50 text-green-700',
                                'Nonaktifkan Akun'=> 'bg-gray-100 text-gray-600',
                                'Tambah Instansi' => 'bg-blue-50 text-blue-700',
                                'Edit Instansi'   => 'bg-amber-50 text-amber-700',
                                'Hapus Instansi'  => 'bg-red-50 text-red-700',
                            ];
                            $badgeClass = $actionColors[$log->action] ?? 'bg-gray-100 text-gray-600';
                        @endphp
                        <tr class="hover:bg-bg-base/50 transition-colors">
                            <td class="px-6 py-4 text-[11px] text-gray-400 whitespace-nowrap">
                                <div>{{ $log->created_at->format('d M Y') }}</div>
                                <div class="text-gray-300">{{ $log->created_at->format('H:i:s') }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-full bg-primary-light flex items-center justify-center text-primary font-bold text-[10px]">
                                        {{ strtoupper(substr($log->user->name ?? '?', 0, 2)) }}
                                    </div>
                                    <div>
                                        <div class="text-xs font-bold text-gray-700">{{ $log->user->name ?? '—' }}</div>
                                        <div class="text-[10px] text-gray-400">{{ $log->user->role ?? '' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide {{ $badgeClass }}">
                                    {{ $log->action }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-xs font-bold text-gray-700">{{ $log->target }}</td>
                            <td class="px-6 py-4 text-[11px] text-gray-500">{{ $log->keterangan ?? '—' }}</td>
                            <td class="px-6 py-4 text-[11px] text-gray-400 font-mono">{{ $log->ip_address ?? '—' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                                <i class="bi bi-clock-history text-4xl block mb-2 opacity-20"></i>
                                <p class="text-sm italic">Belum ada aktivitas tercatat.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($logs->hasPages())
            <div class="px-6 py-4 bg-gray-50 border-t border-[#e2e8f0]">
                {{ $logs->links() }}
            </div>
        @endif
    </div>

@endsection
