@extends('layout-admin.main-layout-admin')

@section('title', 'Manajemen Pengumuman')

@section('content')

    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-sm text-gray-500 mb-2">
                <a href="{{ route('admin.dashboard') }}" class="text-primary hover:underline">Dashboard</a>
                <i class="bi bi-chevron-right text-[10px]"></i>
                <span class="text-gray-400">Pengumuman</span>
            </div>
            <h1 class="font-grotesk text-2xl font-bold text-gray-800 tracking-tight">Manajemen Pengumuman</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola pengumuman & berita yang ditampilkan di halaman publik.</p>
        </div>
        <button onclick="openModal()"
            class="px-4 py-2 bg-primary text-white rounded-lg text-xs font-bold hover:bg-primary-dark flex items-center gap-2 shadow-sm shadow-primary/20">
            <i class="bi bi-plus-lg"></i> Tambah Pengumuman
        </button>
    </div>

    @if(session('success'))
        <div class="mb-4 px-4 py-3 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm flex items-center gap-2">
            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
        </div>
    @endif

    {{-- Filter --}}
    <form method="GET" class="mb-4 flex gap-2 flex-wrap">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul..."
            class="flex-1 max-w-md px-4 py-2 bg-white border border-[#e2e8f0] rounded-lg text-sm focus:border-primary outline-none">
        <select name="status" class="px-4 py-2 bg-white border border-[#e2e8f0] rounded-lg text-sm focus:border-primary outline-none">
            <option value="">Semua Status</option>
            @foreach(['Draft','Publish','Arsip'] as $s)
                <option value="{{ $s }}" {{ request('status')===$s?'selected':'' }}>{{ $s }}</option>
            @endforeach
        </select>
        <button type="submit" class="px-4 py-2 bg-white border border-[#e2e8f0] rounded-lg text-xs font-bold hover:bg-bg-base">Filter</button>
    </form>

    <div class="bg-white rounded-radius border border-[#e2e8f0] shadow-sm overflow-hidden">
        <div class="px-6 py-4 bg-gray-50/50 border-b border-[#e2e8f0]">
            <h3 class="font-bold text-sm text-gray-700 flex items-center gap-2">
                <i class="bi bi-megaphone-fill text-primary"></i> Daftar Pengumuman ({{ $pengumumans->total() }})
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead class="bg-gray-50 text-gray-500 font-bold uppercase tracking-wider text-[10px]">
                    <tr>
                        <th class="px-6 py-4 border-b">Judul</th>
                        <th class="px-6 py-4 border-b text-center">Status</th>
                        <th class="px-6 py-4 border-b text-center">Views</th>
                        <th class="px-6 py-4 border-b">Tanggal Terbit</th>
                        <th class="px-6 py-4 border-b text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($pengumumans as $p)
                        <tr class="hover:bg-bg-base/50">
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-800">{{ $p->judul }}</div>
                                @if($p->ringkasan)
                                    <div class="text-[11px] text-gray-400 mt-0.5 line-clamp-1">{{ $p->ringkasan }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                @php
                                    $color = ['Draft'=>'bg-gray-100 text-gray-600','Publish'=>'bg-green-50 text-green-600','Arsip'=>'bg-amber-50 text-amber-600'][$p->status];
                                @endphp
                                <span class="px-2 py-1 rounded-full text-[10px] font-bold uppercase {{ $color }}">{{ $p->status }}</span>
                            </td>
                            <td class="px-6 py-4 text-center font-bold text-gray-600">{{ $p->views }}</td>
                            <td class="px-6 py-4 text-xs text-gray-500">
                                {{ $p->tanggal_terbit ? $p->tanggal_terbit->format('d M Y, H:i') : '—' }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    @if($p->status === 'Publish')
                                        <a href="{{ route('pengumuman.show', $p->slug) }}" target="_blank" title="Lihat publik"
                                            class="w-8 h-8 flex items-center justify-center border border-gray-200 rounded-lg text-gray-400 hover:text-blue-600 hover:bg-blue-50 hover:border-blue-200">
                                            <i class="bi bi-box-arrow-up-right"></i>
                                        </a>
                                    @endif
                                    <button type="button" onclick='openEditModal(@json($p))' title="Edit"
                                        class="w-8 h-8 flex items-center justify-center border border-gray-200 rounded-lg text-gray-400 hover:text-primary hover:bg-primary-light hover:border-primary-light">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    @if(Auth::user()->role === 'superadmin')
                                        <form action="{{ route('admin.pengumuman.destroy', $p) }}" method="POST"
                                              onsubmit="return confirm('Hapus pengumuman ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                class="w-8 h-8 flex items-center justify-center border border-gray-200 rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 hover:border-red-200">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-6 py-10 text-center text-gray-400 text-sm">Belum ada pengumuman.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($pengumumans->hasPages())
            <div class="px-6 py-3 border-t border-gray-100">{{ $pengumumans->links() }}</div>
        @endif
    </div>

    {{-- Modal Form --}}
    <div id="modal-pengumuman" class="hidden fixed inset-0 bg-black/50 z-[1100] overflow-y-auto">
        <div class="flex items-start justify-center min-h-full p-4 py-10">
            <div class="bg-white rounded-radius shadow-2xl w-full max-w-2xl">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="font-bold text-gray-800 flex items-center gap-2">
                        <i class="bi bi-megaphone text-primary"></i> <span id="modal-title">Tambah Pengumuman</span>
                    </h3>
                    <button onclick="closeModal()" class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-gray-100 text-gray-400">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
                <form id="form-pengumuman" action="{{ route('admin.pengumuman.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                    @csrf
                    <input type="hidden" name="_method" id="form-method" value="POST">

                    @if($errors->any())
                        <div class="p-3 bg-red-50 border border-red-200 rounded-lg text-xs text-red-600">
                            <ul class="space-y-1">@foreach($errors->all() as $e)<li>• {{ $e }}</li>@endforeach</ul>
                        </div>
                    @endif

                    <div>
                        <label class="block text-[11px] font-bold text-gray-500 mb-1">Judul *</label>
                        <input type="text" name="judul" id="f-judul" required
                            class="w-full px-4 py-2 border border-gray-200 rounded-lg text-sm focus:border-primary outline-none">
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold text-gray-500 mb-1">Ringkasan</label>
                        <textarea name="ringkasan" id="f-ringkasan" rows="2"
                            class="w-full px-4 py-2 border border-gray-200 rounded-lg text-sm focus:border-primary outline-none resize-none"></textarea>
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold text-gray-500 mb-1">Isi *</label>
                        <textarea name="isi" id="f-isi" rows="8" required
                            class="w-full px-4 py-2 border border-gray-200 rounded-lg text-sm focus:border-primary outline-none resize-none"></textarea>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[11px] font-bold text-gray-500 mb-1">Gambar (opsional)</label>
                            <input type="file" name="gambar" accept="image/*"
                                class="w-full text-xs file:px-3 file:py-1.5 file:rounded-lg file:border-0 file:bg-primary-light file:text-primary file:font-bold">
                            <p id="gambar-info" class="text-[10px] text-gray-400 mt-1 hidden"></p>
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-gray-500 mb-1">Status Publikasi</label>
                            <div class="flex items-center gap-3 px-3 py-2 border border-gray-200 rounded-lg bg-gray-50/40">
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="hidden" name="publish" value="0">
                                    <input type="checkbox" name="publish" id="f-publish" value="1"
                                        class="w-4 h-4 text-primary rounded border-gray-300 focus:ring-primary">
                                    <span class="ml-2 text-sm text-gray-700 font-medium">Terbitkan ke publik</span>
                                </label>
                                <span class="ml-auto text-[10px] text-gray-400">Hilangkan centang untuk Draft</span>
                            </div>
                            <label class="mt-2 inline-flex items-center gap-2 text-[11px] text-gray-500 cursor-pointer">
                                <input type="checkbox" name="arsip" id="f-arsip" value="1"
                                    class="w-3.5 h-3.5 text-amber-600 rounded border-gray-300 focus:ring-amber-500">
                                Arsipkan (tidak ditampilkan & dikunci dari edit publik)
                            </label>
                        </div>
                    </div>

                    <div class="flex gap-3 pt-2">
                        <button type="button" onclick="closeModal()" class="flex-1 py-2.5 border border-gray-200 text-gray-600 font-bold rounded-lg text-sm hover:bg-gray-50">Batal</button>
                        <button type="submit" class="flex-1 py-2.5 bg-primary text-white font-bold rounded-lg text-sm hover:bg-primary-dark shadow-sm shadow-primary/20">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@push('scripts')
<script>
    const modal = document.getElementById('modal-pengumuman');
    const form  = document.getElementById('form-pengumuman');

    function openModal() {
        document.getElementById('modal-title').textContent = 'Tambah Pengumuman';
        form.action = "{{ route('admin.pengumuman.store') }}";
        document.getElementById('form-method').value = 'POST';
        form.reset();
        document.getElementById('f-publish').checked = false;
        document.getElementById('f-arsip').checked = false;
        document.getElementById('gambar-info').classList.add('hidden');
        modal.classList.remove('hidden');
    }

    function openEditModal(p) {
        document.getElementById('modal-title').textContent = 'Edit Pengumuman';
        form.action = "{{ url('admin/pengumuman') }}/" + p.id;
        document.getElementById('form-method').value = 'PATCH';
        document.getElementById('f-judul').value     = p.judul;
        document.getElementById('f-ringkasan').value = p.ringkasan ?? '';
        document.getElementById('f-isi').value       = p.isi;
        document.getElementById('f-publish').checked = (p.status === 'Publish');
        document.getElementById('f-arsip').checked   = (p.status === 'Arsip');
        const info = document.getElementById('gambar-info');
        if (p.gambar) { info.textContent = 'Gambar saat ini: ' + p.gambar + ' (unggah baru untuk mengganti)'; info.classList.remove('hidden'); }
        else { info.classList.add('hidden'); }
        modal.classList.remove('hidden');
    }

    function closeModal() { modal.classList.add('hidden'); }

    @if($errors->any())
        openModal();
    @endif
</script>
@endpush

@endsection
