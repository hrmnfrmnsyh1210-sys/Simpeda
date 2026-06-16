@extends('layout-admin.main-layout-admin')

@section('title', 'Manajemen Struktur Organisasi')

@section('content')

    {{-- Header --}}
    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-sm text-gray-500 mb-2">
                <a href="{{ route('admin.dashboard') }}" class="text-primary hover:underline">Dashboard</a>
                <i class="bi bi-chevron-right text-[10px]"></i>
                <span class="text-gray-400">Struktur Organisasi</span>
            </div>
            <h1 class="font-grotesk text-2xl font-bold text-gray-800 tracking-tight">Manajemen Struktur Organisasi</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola data pejabat & staf kantor desa yang ditampilkan di halaman Profil Desa.</p>
        </div>
        <button onclick="openModal()"
            class="px-4 py-2 bg-primary text-white rounded-lg text-xs font-bold hover:bg-primary-dark transition-all flex items-center gap-2 shadow-sm shadow-primary/20">
            <i class="bi bi-plus-lg"></i> Tambah Pejabat
        </button>
    </div>

    @if(session('success'))
        <div class="mb-4 px-4 py-3 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm flex items-center gap-2">
            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
        </div>
    @endif

    {{-- Search --}}
    <form method="GET" class="mb-4 flex gap-2">
        <div class="relative flex-1 max-w-md">
            <i class="bi bi-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Cari jabatan, nama, atau NIP..."
                class="w-full pl-9 pr-4 py-2 bg-white border border-[#e2e8f0] rounded-lg text-sm focus:border-primary outline-none transition-all">
        </div>
        <button type="submit" class="px-4 py-2 bg-white border border-[#e2e8f0] rounded-lg text-xs font-bold hover:bg-bg-base">
            Cari
        </button>
    </form>

    {{-- Tabel --}}
    <div class="bg-white rounded-radius border border-[#e2e8f0] shadow-sm overflow-hidden">
        <div class="px-6 py-4 bg-gray-50/50 border-b border-[#e2e8f0]">
            <h3 class="font-bold text-sm text-gray-700 flex items-center gap-2">
                <i class="bi bi-diagram-3 text-primary"></i> Daftar Pejabat ({{ $strukturs->total() }})
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead class="bg-gray-50 text-gray-500 font-bold uppercase tracking-wider text-[10px]">
                    <tr>
                        <th class="px-6 py-4 border-b w-20">Urutan</th>
                        <th class="px-6 py-4 border-b">Jabatan</th>
                        <th class="px-6 py-4 border-b">Nama</th>
                        <th class="px-6 py-4 border-b">NIP / NIAP</th>
                        <th class="px-6 py-4 border-b text-center">Status</th>
                        <th class="px-6 py-4 border-b text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($strukturs as $s)
                        <tr class="hover:bg-bg-base/50 transition-colors">
                            <td class="px-6 py-4">
                                <span class="inline-flex w-8 h-8 items-center justify-center bg-primary-light text-primary font-mono font-bold text-[11px] rounded">
                                    {{ $s->urutan }}
                                </span>
                            </td>
                            <td class="px-6 py-4 font-bold text-gray-800">{{ $s->jabatan }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $s->nama }}</td>
                            <td class="px-6 py-4 text-gray-500 font-mono text-xs">{{ $s->nip ?: '—' }}</td>
                            <td class="px-6 py-4 text-center">
                                @if($s->is_active)
                                    <span class="inline-flex items-center gap-1.5 px-2 py-1 rounded-full bg-green-50 text-green-600 text-[10px] font-bold uppercase">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-600 animate-pulse"></span> Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2 py-1 rounded-full bg-gray-100 text-gray-500 text-[10px] font-bold uppercase">
                                        <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span> Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <button type="button"
                                        onclick='openEditModal(@json($s))'
                                        class="w-8 h-8 flex items-center justify-center border border-gray-200 rounded-lg text-gray-400 hover:text-primary hover:border-primary-light hover:bg-primary-light transition-all">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <form action="{{ route('admin.struktur.destroy', $s) }}" method="POST"
                                          onsubmit="return confirm('Hapus {{ $s->nama }} ({{ $s->jabatan }})?')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="w-8 h-8 flex items-center justify-center border border-gray-200 rounded-lg text-gray-400 hover:text-red-600 hover:border-red-200 hover:bg-red-50 transition-all">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-6 py-10 text-center text-gray-400 text-sm">Belum ada data struktur organisasi.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($strukturs->hasPages())
            <div class="px-6 py-3 border-t border-gray-100">{{ $strukturs->links() }}</div>
        @endif
    </div>

    {{-- Modal Form --}}
    <div id="modal-struktur" class="hidden fixed inset-0 bg-black/50 z-[1100] overflow-y-auto">
        <div class="flex items-start justify-center min-h-full p-4 py-10">
            <div class="bg-white rounded-radius shadow-2xl w-full max-w-xl">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="font-bold text-gray-800 flex items-center gap-2">
                        <i class="bi bi-diagram-3 text-primary"></i> <span id="modal-title">Tambah Pejabat</span>
                    </h3>
                    <button onclick="closeModal()"
                        class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-gray-100 text-gray-400 transition-all">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
                <form id="form-struktur" action="{{ route('admin.struktur.store') }}" method="POST" class="p-6 space-y-4">
                    @csrf
                    <input type="hidden" name="_method" id="form-method" value="POST">

                    @if($errors->any())
                        <div class="p-3 bg-red-50 border border-red-200 rounded-lg text-xs text-red-600">
                            <ul class="space-y-1">
                                @foreach($errors->all() as $e) <li>• {{ $e }}</li> @endforeach
                            </ul>
                        </div>
                    @endif

                    <div>
                        <label class="block text-[11px] font-bold text-gray-500 mb-1">Jabatan *</label>
                        <input type="text" name="jabatan" id="f-jabatan" required maxlength="100"
                            placeholder="Contoh: Kepala Desa, Sekretaris Desa..."
                            class="w-full px-4 py-2 border border-gray-200 rounded-lg text-sm focus:border-primary outline-none">
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold text-gray-500 mb-1">Nama Lengkap *</label>
                        <input type="text" name="nama" id="f-nama" required maxlength="100"
                            class="w-full px-4 py-2 border border-gray-200 rounded-lg text-sm focus:border-primary outline-none">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[11px] font-bold text-gray-500 mb-1">NIP / NIAP</label>
                            <input type="text" name="nip" id="f-nip" maxlength="30"
                                class="w-full px-4 py-2 border border-gray-200 rounded-lg text-sm focus:border-primary outline-none font-mono">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-gray-500 mb-1">Urutan Tampil</label>
                            <input type="number" name="urutan" id="f-urutan" min="0" max="999" value="0"
                                class="w-full px-4 py-2 border border-gray-200 rounded-lg text-sm focus:border-primary outline-none">
                            <p class="text-[10px] text-gray-400 mt-1">Semakin kecil semakin di atas.</p>
                        </div>
                    </div>

                    <label class="flex items-center gap-2 text-sm text-gray-600">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" id="f-active" value="1" checked
                            class="w-4 h-4 text-primary rounded">
                        Tampilkan di halaman Profil Desa
                    </label>

                    <div class="flex gap-3 pt-2">
                        <button type="button" onclick="closeModal()"
                            class="flex-1 py-2.5 border border-gray-200 text-gray-600 font-bold rounded-lg text-sm hover:bg-gray-50">Batal</button>
                        <button type="submit"
                            class="flex-1 py-2.5 bg-primary text-white font-bold rounded-lg text-sm hover:bg-primary-dark shadow-sm shadow-primary/20">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@push('scripts')
<script>
    const modal = document.getElementById('modal-struktur');
    const form  = document.getElementById('form-struktur');

    function openModal() {
        document.getElementById('modal-title').textContent = 'Tambah Pejabat';
        form.action = "{{ route('admin.struktur.store') }}";
        document.getElementById('form-method').value = 'POST';
        form.reset();
        document.getElementById('f-active').checked = true;
        document.getElementById('f-urutan').value = 0;
        modal.classList.remove('hidden');
    }

    function openEditModal(item) {
        document.getElementById('modal-title').textContent = 'Edit Pejabat';
        form.action = "{{ url('admin/struktur') }}/" + item.id;
        document.getElementById('form-method').value = 'PATCH';
        document.getElementById('f-jabatan').value = item.jabatan;
        document.getElementById('f-nama').value    = item.nama;
        document.getElementById('f-nip').value     = item.nip ?? '';
        document.getElementById('f-urutan').value  = item.urutan ?? 0;
        document.getElementById('f-active').checked = !!item.is_active;
        modal.classList.remove('hidden');
    }

    function closeModal() { modal.classList.add('hidden'); }

    @if($errors->any())
        openModal();
    @endif
</script>
@endpush

@endsection
