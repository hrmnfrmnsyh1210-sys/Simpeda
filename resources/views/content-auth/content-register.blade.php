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
        <a href="{{ route('google.redirect') }}"
            class="w-full h-[50px] flex items-center justify-center gap-3 bg-[#1a56db] hover:bg-[#1240a8] rounded-xl text-[15px] font-semibold text-white
                shadow-[0_4px_16px_rgba(26,86,219,.25)] hover:shadow-[0_6px_24px_rgba(26,86,219,.30)]
                transition-all duration-200 hover:-translate-y-px active:translate-y-0">
            <svg class="w-5 h-5 bg-white rounded-full p-0.5" viewBox="0 0 48 48">
                <path fill="#FFC107" d="M43.6 20.5H42V20H24v8h11.3C33.7 32.7 29.3 36 24 36c-6.6 0-12-5.4-12-12s5.4-12 12-12c3.1 0 5.8 1.1 8 3l6-6C34.5 5.1 29.5 3 24 3 12.4 3 3 12.4 3 24s9.4 21 21 21 21-9.4 21-21c0-1.5-.2-2.7-.4-3.5z"/>
                <path fill="#FF3D00" d="M6.3 14.7l6.6 4.8C14.6 15.6 18.9 13 24 13c3.1 0 5.8 1.1 8 3l6-6C34.5 5.1 29.5 3 24 3 16.3 3 9.6 7.3 6.3 14.7z"/>
                <path fill="#4CAF50" d="M24 45c5.3 0 10.1-2 13.7-5.4l-6.3-5.3C29.3 36 26.8 37 24 37c-5.3 0-9.7-3.3-11.3-8l-6.5 5C9.5 40.6 16.2 45 24 45z"/>
                <path fill="#1976D2" d="M43.6 20.5H42V20H24v8h11.3c-.8 2.3-2.3 4.2-4.2 5.6l6.3 5.3C40.4 36.5 43 30.8 43 24c0-1.5-.2-2.7-.4-3.5z"/>
            </svg>
            Daftar dengan Google
        </a>

        <p class="text-center text-xs text-slate-400 mt-4 leading-relaxed">
            Setelah masuk dengan Google, Anda akan diminta melengkapi NIK dan nomor HP
            agar pengaduan dapat diproses oleh petugas desa.
        </p>
    </div>

    {{-- Footer --}}
    <div class="anim-footer text-center mt-6 text-[13px] text-slate-500">
        Sudah punya akun?
        <a href="{{ route('login') }}" class="text-[#1a56db] font-semibold hover:underline">
            Masuk di sini
        </a>
    </div>

@endsection
