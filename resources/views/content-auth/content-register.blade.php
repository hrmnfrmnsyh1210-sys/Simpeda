@extends('layout-auth.main-layout')

@section('title', 'Daftar Akun Masyarakat')

@push('styles')
    <style>
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .anim-header { animation: fadeUp .45s ease both; }
        .anim-card   { animation: fadeUp .45s .1s ease both; }
        .anim-footer { animation: fadeUp .45s .2s ease both; }

        @keyframes spin { to { transform: rotate(360deg); } }
        .spinner {
            display: none; width: 18px; height: 18px;
            border: 2px solid rgba(255, 255, 255, .35); border-top-color: #fff;
            border-radius: 50%; animation: spin .6s linear infinite; flex-shrink: 0;
        }
        #registerBtn.loading .spinner { display: block; }
        #registerBtn.loading .btn-label { display: none; }

        .field-input:focus {
            outline: none; border-color: #1a56db;
            box-shadow: 0 0 0 3px rgba(26, 86, 219, .10); background: #fff;
        }
    </style>
@endpush

@section('content')

    {{-- Header --}}
    <div class="anim-header mb-7">
        <p class="text-xs font-semibold tracking-widest uppercase text-[#1a56db] mb-2">
            Portal Masyarakat
        </p>
        <h2 class="font-extrabold text-[30px] text-slate-900 leading-tight tracking-tight mb-2">
            Buat akun baru
        </h2>
        <p class="text-slate-500 text-sm leading-relaxed font-normal">
            Daftar untuk menyampaikan pengaduan dan memantau status laporan Anda.
        </p>
    </div>

    {{-- Card --}}
    <div class="anim-card bg-white rounded-[20px] p-9 shadow-card border border-slate-100">
        <form id="registerForm" method="POST" action="{{ route('register') }}" novalidate>
            @csrf

            {{-- Nama --}}
            <div class="mb-5">
                <label for="name" class="block text-[13px] font-semibold text-slate-800 mb-2">Nama Lengkap</label>
                <input type="text" id="name" name="name" placeholder="Nama lengkap Anda" value="{{ old('name') }}"
                    autocomplete="name" autofocus
                    class="field-input w-full h-12 px-4 border-[1.5px] rounded-xl text-sm text-slate-900 bg-slate-50 transition-colors duration-200
                        {{ $errors->has('name') ? 'border-red-400 bg-red-50' : 'border-slate-200' }}">
                @error('name') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- NIK --}}
            <div class="mb-5">
                <label for="nik" class="block text-[13px] font-semibold text-slate-800 mb-2">NIK (Nomor Induk Kependudukan)</label>
                <input type="text" id="nik" name="nik" placeholder="16 digit NIK pada KTP" value="{{ old('nik') }}"
                    inputmode="numeric" maxlength="16" autocomplete="off"
                    class="field-input w-full h-12 px-4 border-[1.5px] rounded-xl text-sm text-slate-900 bg-slate-50 transition-colors duration-200
                        {{ $errors->has('nik') ? 'border-red-400 bg-red-50' : 'border-slate-200' }}">
                @error('nik') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Email --}}
            <div class="mb-5">
                <label for="email" class="block text-[13px] font-semibold text-slate-800 mb-2">Alamat Email</label>
                <input type="email" id="email" name="email" placeholder="nama@email.com" value="{{ old('email') }}"
                    autocomplete="email"
                    class="field-input w-full h-12 px-4 border-[1.5px] rounded-xl text-sm text-slate-900 bg-slate-50 transition-colors duration-200
                        {{ $errors->has('email') ? 'border-red-400 bg-red-50' : 'border-slate-200' }}">
                @error('email') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Nomor HP + RT/RW --}}
            <div class="grid grid-cols-2 gap-4 mb-5">
                <div>
                    <label for="nomor_hp" class="block text-[13px] font-semibold text-slate-800 mb-2">Nomor HP</label>
                    <input type="tel" id="nomor_hp" name="nomor_hp" placeholder="08xx-xxxx-xxxx" value="{{ old('nomor_hp') }}"
                        autocomplete="tel"
                        class="field-input w-full h-12 px-4 border-[1.5px] rounded-xl text-sm text-slate-900 bg-slate-50 transition-colors duration-200
                            {{ $errors->has('nomor_hp') ? 'border-red-400 bg-red-50' : 'border-slate-200' }}">
                    @error('nomor_hp') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="rt_rw" class="block text-[13px] font-semibold text-slate-800 mb-2">
                        RT/RW <span class="text-slate-400 font-normal">(opsional)</span>
                    </label>
                    <input type="text" id="rt_rw" name="rt_rw" placeholder="001/002" value="{{ old('rt_rw') }}"
                        class="field-input w-full h-12 px-4 border-[1.5px] rounded-xl text-sm text-slate-900 bg-slate-50 transition-colors duration-200
                            {{ $errors->has('rt_rw') ? 'border-red-400 bg-red-50' : 'border-slate-200' }}">
                    @error('rt_rw') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Password --}}
            <div class="mb-5">
                <label for="password" class="block text-[13px] font-semibold text-slate-800 mb-2">Kata Sandi</label>
                <input type="password" id="password" name="password" placeholder="Minimal 6 karakter"
                    autocomplete="new-password"
                    class="field-input w-full h-12 px-4 border-[1.5px] rounded-xl text-sm text-slate-900 bg-slate-50 transition-colors duration-200
                        {{ $errors->has('password') ? 'border-red-400 bg-red-50' : 'border-slate-200' }}">
                @error('password') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Konfirmasi Password --}}
            <div class="mb-6">
                <label for="password_confirmation" class="block text-[13px] font-semibold text-slate-800 mb-2">Konfirmasi Kata Sandi</label>
                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi kata sandi"
                    autocomplete="new-password"
                    class="field-input w-full h-12 px-4 border-[1.5px] rounded-xl text-sm text-slate-900 bg-slate-50 border-slate-200 transition-colors duration-200">
            </div>

            {{-- Tombol Submit --}}
            <button type="submit" id="registerBtn" class="relative overflow-hidden w-full h-[50px] flex items-center justify-center gap-2
                        bg-[#1a56db] hover:bg-[#1240a8] text-white text-[15px] font-semibold rounded-xl
                        shadow-[0_4px_16px_rgba(26,86,219,.25)] hover:shadow-[0_6px_24px_rgba(26,86,219,.30)]
                        transition-all duration-200 hover:-translate-y-px active:translate-y-0
                        disabled:opacity-65 disabled:cursor-not-allowed disabled:translate-y-0">
                <span class="pointer-events-none absolute inset-0 bg-gradient-to-br from-white/10 to-transparent"></span>
                <div class="spinner"></div>
                <span class="btn-label">Daftar Sekarang</span>
            </button>

        </form>
    </div>

    {{-- Footer --}}
    <div class="anim-footer text-center mt-6 text-[13px] text-slate-500">
        Sudah punya akun?
        <a href="{{ route('login') }}" class="text-[#1a56db] font-semibold hover:underline">
            Masuk di sini
        </a>
    </div>

@endsection

@push('scripts')
    <script>
        const registerForm = document.getElementById('registerForm');
        const registerBtn = document.getElementById('registerBtn');

        registerForm.addEventListener('submit', () => {
            registerBtn.classList.add('loading');
            registerBtn.disabled = true;
        });

        window.addEventListener('pageshow', () => {
            registerBtn.classList.remove('loading');
            registerBtn.disabled = false;
        });
    </script>
@endpush
