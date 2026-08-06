@extends('layout-auth.main-layout')

@section('title', 'Masuk ke Akun Anda')

@push('styles')
    <style>
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .anim-header {
            animation: fadeUp .45s ease both;
        }

        .anim-card {
            animation: fadeUp .45s .1s ease both;
        }

        .anim-footer {
            animation: fadeUp .45s .2s ease both;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .spinner {
            display: none;
            width: 18px;
            height: 18px;
            border: 2px solid rgba(255, 255, 255, .35);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin .6s linear infinite;
            flex-shrink: 0;
        }

        #loginBtn.loading .spinner {
            display: block;
        }

        #loginBtn.loading .btn-label {
            display: none;
        }

        .field-input:focus {
            outline: none;
            border-color: #1a56db;
            box-shadow: 0 0 0 3px rgba(26, 86, 219, .10);
            background: #fff;
        }

        .field-wrapper:focus-within .field-icon {
            color: #1a56db;
        }

        .forgot-link:hover {
            opacity: .7;
        }
    </style>
@endpush

@section('content')

    {{-- Header --}}
    <div class="anim-header mb-9">
        <p class="text-xs font-semibold tracking-widest uppercase text-[#1a56db] mb-2">
            Portal Masyarakat &amp; Petugas
        </p>
        {{-- Turun dari font-extrabold ke font-bold --}}
        <h2 class="font-extrabold text-[30px] text-slate-900 leading-tight tracking-tight mb-2">
            Selamat datang<br>kembali 👋
        </h2>
        <p class="text-slate-500 text-sm leading-relaxed font-normal">
            Masuk untuk mengakses dashboard pengelolaan pengaduan warga.
        </p>
    </div>

    {{-- Card --}}
    <div class="anim-card bg-white rounded-[20px] p-9 shadow-card border border-slate-100">

        {{-- Masuk sebagai Warga --}}
        <a href="{{ route('google.redirect') }}"
            class="w-full h-[50px] flex items-center justify-center gap-3 border-[1.5px] border-slate-200 rounded-xl text-[15px] font-semibold text-slate-700 hover:bg-slate-50 transition-all duration-200">
            <svg class="w-5 h-5" viewBox="0 0 48 48">
                <path fill="#FFC107" d="M43.6 20.5H42V20H24v8h11.3C33.7 32.7 29.3 36 24 36c-6.6 0-12-5.4-12-12s5.4-12 12-12c3.1 0 5.8 1.1 8 3l6-6C34.5 5.1 29.5 3 24 3 12.4 3 3 12.4 3 24s9.4 21 21 21 21-9.4 21-21c0-1.5-.2-2.7-.4-3.5z"/>
                <path fill="#FF3D00" d="M6.3 14.7l6.6 4.8C14.6 15.6 18.9 13 24 13c3.1 0 5.8 1.1 8 3l6-6C34.5 5.1 29.5 3 24 3 16.3 3 9.6 7.3 6.3 14.7z"/>
                <path fill="#4CAF50" d="M24 45c5.3 0 10.1-2 13.7-5.4l-6.3-5.3C29.3 36 26.8 37 24 37c-5.3 0-9.7-3.3-11.3-8l-6.5 5C9.5 40.6 16.2 45 24 45z"/>
                <path fill="#1976D2" d="M43.6 20.5H42V20H24v8h11.3c-.8 2.3-2.3 4.2-4.2 5.6l6.3 5.3C40.4 36.5 43 30.8 43 24c0-1.5-.2-2.7-.4-3.5z"/>
            </svg>
            Masuk / Daftar sebagai Warga dengan Google
        </a>

        {{-- Divider --}}
        <div class="flex items-center gap-3 my-7">
            <div class="flex-1 h-px bg-slate-200"></div>
            <span class="text-[11px] font-semibold uppercase tracking-wider text-slate-400">Login Petugas</span>
            <div class="flex-1 h-px bg-slate-200"></div>
        </div>

        <form id="loginForm" method="POST" action="{{ route('login') }}" novalidate>
            @csrf

            {{-- Email Petugas --}}
            <div class="mb-5">
                <label for="login" class="block text-[13px] font-semibold text-slate-800 mb-2">
                    Email Petugas
                </label>
                <div class="field-wrapper relative">
                    <input type="text" id="login" name="login" placeholder="Email admin/petugas" value="{{ old('login') }}"
                        autocomplete="username" autofocus class="field-input w-full h-12 pl-11 pr-4 border-[1.5px] rounded-xl text-sm text-slate-900 bg-slate-50 transition-colors duration-200
                                {{ $errors->has('login')
        ? 'border-red-400 bg-red-50 shadow-[0_0_0_3px_rgba(220,38,38,.08)]'
        : 'border-slate-200' }}">
                    <svg class="field-icon pointer-events-none absolute left-3.5 top-1/2 -translate-y-1/2 w-[18px] h-[18px] text-slate-400 transition-colors duration-200"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                @error('login')
                    <div class="flex items-center gap-1.5 mt-1.5 text-xs text-red-600">
                        <svg class="w-3 h-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10" />
                            <line x1="12" y1="8" x2="12" y2="12" />
                            <line x1="12" y1="16" x2="12.01" y2="16" />
                        </svg>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Password --}}
            <div class="mb-5">
                <label for="password" class="block text-[13px] font-semibold text-slate-800 mb-2">
                    Kata Sandi
                </label>
                <div class="field-wrapper relative">
                    <input type="password" id="password" name="password" placeholder="Masukkan kata sandi"
                        autocomplete="current-password" class="field-input w-full h-12 pl-11 pr-11 border-[1.5px] rounded-xl text-sm text-slate-900 bg-slate-50 transition-colors duration-200
                                {{ $errors->has('password')
        ? 'border-red-400 bg-red-50 shadow-[0_0_0_3px_rgba(220,38,38,.08)]'
        : 'border-slate-200' }}">
                    <svg class="field-icon pointer-events-none absolute left-3.5 top-1/2 -translate-y-1/2 w-[18px] h-[18px] text-slate-400 transition-colors duration-200"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    <button type="button" id="togglePwd" title="Tampilkan/sembunyikan kata sandi"
                        class="absolute right-3.5 top-1/2 -translate-y-1/2 flex items-center text-slate-400 hover:text-[#1a56db] transition-colors duration-200">
                        <svg id="eyeOpen" class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg id="eyeClosed" class="w-[18px] h-[18px] hidden" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                        </svg>
                    </button>
                </div>
                @error('password')
                    <div class="flex items-center gap-1.5 mt-1.5 text-xs text-red-600">
                        <svg class="w-3 h-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10" />
                            <line x1="12" y1="8" x2="12" y2="12" />
                            <line x1="12" y1="16" x2="12.01" y2="16" />
                        </svg>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Remember + Forgot --}}
            <div class="flex items-center justify-between mb-6">
                <label class="flex items-center gap-2 cursor-pointer select-none text-[13px] text-slate-500">
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}
                        class="w-[18px] h-[18px] rounded-[5px] border-slate-300 text-[#1a56db] accent-[#1a56db] cursor-pointer">
                    Ingat saya
                </label>
                <a href="#"
                    class="forgot-link text-[13px] font-medium text-[#1a56db] no-underline transition-opacity duration-200">
                    Lupa kata sandi?
                </a>
            </div>

            {{-- Tombol Submit --}}
            <button type="submit" id="loginBtn" class="relative overflow-hidden w-full h-[50px] flex items-center justify-center gap-2
                        bg-[#1a56db] hover:bg-[#1240a8] text-white text-[15px] font-semibold rounded-xl
                        shadow-[0_4px_16px_rgba(26,86,219,.25)] hover:shadow-[0_6px_24px_rgba(26,86,219,.30)]
                        transition-all duration-200 hover:-translate-y-px active:translate-y-0
                        disabled:opacity-65 disabled:cursor-not-allowed disabled:translate-y-0">
                <span class="pointer-events-none absolute inset-0 bg-gradient-to-br from-white/10 to-transparent"></span>
                <div class="spinner"></div>
                <span class="btn-label">Masuk</span>
                <svg class="btn-label w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </button>

        </form>
    </div>

    {{-- Footer --}}
    <div class="anim-footer text-center mt-6 text-[13px] text-slate-500">
        Belum punya akun warga? Gunakan tombol <strong>Masuk / Daftar dengan Google</strong> di atas.
    </div>

@endsection

@push('scripts')
    <script>
        const togglePwd = document.getElementById('togglePwd');
        const pwdInput = document.getElementById('password');
        const eyeOpen = document.getElementById('eyeOpen');
        const eyeClosed = document.getElementById('eyeClosed');

        togglePwd.addEventListener('click', () => {
            const isPassword = pwdInput.type === 'password';
            pwdInput.type = isPassword ? 'text' : 'password';
            eyeOpen.classList.toggle('hidden', isPassword);
            eyeClosed.classList.toggle('hidden', !isPassword);
        });

        const loginForm = document.getElementById('loginForm');
        const loginBtn = document.getElementById('loginBtn');

        loginForm.addEventListener('submit', () => {
            loginBtn.classList.add('loading');
            loginBtn.disabled = true;
        });

        window.addEventListener('pageshow', () => {
            loginBtn.classList.remove('loading');
            loginBtn.disabled = false;
        });
    </script>
@endpush