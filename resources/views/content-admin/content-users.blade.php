@extends('layout-admin.main-layout-admin')

@section('title', 'Manajemen Pengguna')

@section('content')

    {{-- Header --}}
    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-sm text-gray-500 mb-2">
                <a href="{{ route('admin.dashboard') }}" class="text-primary hover:underline">Dashboard</a>
                <i class="bi bi-chevron-right text-[10px]"></i>
                <span class="text-gray-400">Manajemen Pengguna</span>
            </div>
            <h1 class="font-grotesk text-2xl font-bold text-gray-800 tracking-tight">Manajemen Akun</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola akun admin dan superadmin yang memiliki akses ke panel ini.</p>
        </div>
        <button onclick="document.getElementById('modal-tambah').classList.remove('hidden')"
            class="px-4 py-2 bg-primary text-white rounded-lg text-xs font-bold hover:bg-primary-dark transition-all flex items-center gap-2 shadow-sm shadow-primary/20">
            <i class="bi bi-plus-lg"></i> Tambah Akun
        </button>
    </div>

    {{-- Alert --}}
    @if(session('success'))
        <div class="mb-4 px-4 py-3 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm flex items-center gap-2">
            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-4 px-4 py-3 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm flex items-center gap-2">
            <i class="bi bi-exclamation-circle-fill"></i> {{ session('error') }}
        </div>
    @endif

    {{-- Tabel Pengguna --}}
    <div class="bg-white rounded-radius border border-[#e2e8f0] shadow-sm overflow-hidden">
        <div class="px-6 py-4 bg-gray-50/50 border-b border-[#e2e8f0] flex items-center justify-between">
            <h3 class="font-bold text-sm text-gray-700 flex items-center gap-2">
                <i class="bi bi-people text-primary"></i> Daftar Akun ({{ $users->count() }})
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead class="bg-gray-50 text-gray-500 font-bold uppercase tracking-wider text-[10px]">
                    <tr>
                        <th class="px-6 py-4 border-b">Nama & Email</th>
                        <th class="px-6 py-4 border-b">Role</th>
                        <th class="px-6 py-4 border-b text-center">Status</th>
                        <th class="px-6 py-4 border-b text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($users as $user)
                        <tr class="hover:bg-bg-base/50 transition-colors {{ $user->id === Auth::id() ? 'bg-primary-light/30' : '' }}">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full flex items-center justify-center font-bold text-xs text-white
                                        {{ $user->role === 'superadmin' ? 'bg-gradient-to-br from-violet-500 to-indigo-600' : 'bg-gradient-to-br from-primary to-[#2d7af0]' }}">
                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-gray-800 text-sm">
                                            {{ $user->name }}
                                            @if($user->id === Auth::id())
                                                <span class="ml-1 text-[9px] bg-primary-light text-primary px-1.5 py-0.5 rounded-full font-bold">Anda</span>
                                            @endif
                                        </div>
                                        <div class="text-[11px] text-gray-400">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($user->role === 'superadmin')
                                    <span class="px-2 py-1 bg-violet-50 text-violet-700 text-[10px] font-bold rounded-full uppercase tracking-wide">
                                        <i class="bi bi-shield-fill-check mr-1"></i> Super Admin
                                    </span>
                                @else
                                    <span class="px-2 py-1 bg-primary-light text-primary text-[10px] font-bold rounded-full uppercase tracking-wide">
                                        <i class="bi bi-shield-check mr-1"></i> Admin
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($user->is_active)
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
                                    @if($user->id !== Auth::id())
                                        {{-- Toggle Status --}}
                                        <form action="{{ route('admin.users.toggle', $user) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <button type="submit" title="{{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}"
                                                class="w-8 h-8 flex items-center justify-center border border-gray-200 rounded-lg text-gray-400 hover:text-amber-600 hover:border-amber-200 hover:bg-amber-50 transition-all">
                                                <i class="bi {{ $user->is_active ? 'bi-pause-circle' : 'bi-play-circle' }}"></i>
                                            </button>
                                        </form>
                                        {{-- Hapus --}}
                                        @if(Auth::user()->role === 'superadmin')
                                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                                onsubmit="return confirm('Hapus akun {{ $user->name }}?')">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    class="w-8 h-8 flex items-center justify-center border border-gray-200 rounded-lg text-gray-400 hover:text-red-600 hover:border-red-200 hover:bg-red-50 transition-all">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    @else
                                        <span class="text-[10px] text-gray-300 italic">—</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modal Tambah Akun --}}
    <div id="modal-tambah" class="hidden fixed inset-0 bg-black/50 z-[1100]">
        <div class="flex items-center justify-center min-h-full p-4">
        <div class="bg-white rounded-radius shadow-2xl w-full max-w-md">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h3 class="font-bold text-gray-800 flex items-center gap-2">
                    <i class="bi bi-person-plus text-primary"></i> Tambah Akun Baru
                </h3>
                <button onclick="document.getElementById('modal-tambah').classList.add('hidden')"
                    class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-gray-100 text-gray-400 transition-all">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            <form action="{{ route('admin.users.store') }}" method="POST" class="p-6 space-y-4">
                @csrf
                @if($errors->any())
                    <div class="p-3 bg-red-50 border border-red-200 rounded-lg text-xs text-red-600">
                        <ul class="space-y-1">
                            @foreach($errors->all() as $e) <li>• {{ $e }}</li> @endforeach
                        </ul>
                    </div>
                @endif
                <div>
                    <label class="block text-[11px] font-bold text-gray-500 mb-1">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                        class="w-full px-4 py-2 border border-gray-200 rounded-lg text-sm focus:border-primary outline-none transition-all"
                        placeholder="Nama lengkap...">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-gray-500 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        class="w-full px-4 py-2 border border-gray-200 rounded-lg text-sm focus:border-primary outline-none transition-all"
                        placeholder="email@example.com">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-gray-500 mb-1">Role</label>
                    <select name="role" class="w-full px-4 py-2 border border-gray-200 rounded-lg text-sm focus:border-primary outline-none transition-all">
                        <option value="admin">Admin</option>
                        <option value="superadmin">Super Admin</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-gray-500 mb-1">Password</label>
                    <input type="password" name="password" required
                        class="w-full px-4 py-2 border border-gray-200 rounded-lg text-sm focus:border-primary outline-none transition-all"
                        placeholder="Minimal 8 karakter...">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-gray-500 mb-1">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" required
                        class="w-full px-4 py-2 border border-gray-200 rounded-lg text-sm focus:border-primary outline-none transition-all"
                        placeholder="Ulangi password...">
                </div>
                <div class="flex gap-3 pt-2">
                    <button type="button" onclick="document.getElementById('modal-tambah').classList.add('hidden')"
                        class="flex-1 py-2.5 border border-gray-200 text-gray-600 font-bold rounded-lg text-sm hover:bg-gray-50 transition-all">
                        Batal
                    </button>
                    <button type="submit"
                        class="flex-1 py-2.5 bg-primary text-white font-bold rounded-lg text-sm hover:bg-primary-dark transition-all shadow-sm shadow-primary/20">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Buka modal otomatis jika ada error validasi
        @if($errors->any())
            document.getElementById('modal-tambah').classList.remove('hidden');
        @endif
    </script>
    @endpush

@endsection
