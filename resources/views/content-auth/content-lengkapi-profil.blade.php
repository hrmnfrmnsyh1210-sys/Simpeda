@extends('layout-auth.main-layout')

@section('title', 'Lengkapi Profil')

@push('styles')
    <style>
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .anim-header { animation: fadeUp .45s ease both; }
        .anim-card   { animation: fadeUp .45s .1s ease both; }

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
            Satu Langkah Lagi
        </p>
        <h2 class="font-extrabold text-[30px] text-slate-900 leading-tight tracking-tight mb-2">
            Lengkapi profil Anda
        </h2>
        <p class="text-slate-500 text-sm leading-relaxed font-normal">
            Halo, {{ Auth::user()->name }}. Kami perlu data ini agar pengaduan Anda dapat diproses petugas desa.
        </p>
    </div>

    {{-- Card --}}
    <div class="anim-card bg-white rounded-[20px] p-9 shadow-card border border-slate-100">
        <form method="POST" action="{{ route('warga.lengkapi-profil.store') }}" novalidate>
            @csrf

            {{-- NIK --}}
            <div class="mb-5">
                <label for="nik" class="block text-[13px] font-semibold text-slate-800 mb-2">NIK (Nomor Induk Kependudukan)</label>
                <input type="text" id="nik" name="nik" placeholder="16 digit NIK pada KTP" value="{{ old('nik') }}"
                    inputmode="numeric" maxlength="16" autocomplete="off" autofocus
                    class="field-input w-full h-12 px-4 border-[1.5px] rounded-xl text-sm text-slate-900 bg-slate-50 transition-colors duration-200
                        {{ $errors->has('nik') ? 'border-red-400 bg-red-50' : 'border-slate-200' }}">
                @error('nik') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Nomor HP + RT/RW --}}
            <div class="grid grid-cols-2 gap-4 mb-6">
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

            {{-- Tombol Submit --}}
            <button type="submit" class="relative overflow-hidden w-full h-[50px] flex items-center justify-center gap-2
                        bg-[#1a56db] hover:bg-[#1240a8] text-white text-[15px] font-semibold rounded-xl
                        shadow-[0_4px_16px_rgba(26,86,219,.25)] hover:shadow-[0_6px_24px_rgba(26,86,219,.30)]
                        transition-all duration-200 hover:-translate-y-px active:translate-y-0">
                Simpan &amp; Lanjutkan
            </button>
        </form>
    </div>

@endsection
