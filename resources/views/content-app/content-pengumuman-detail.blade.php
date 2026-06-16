@extends('layout-app.main-app')

@section('title', $pengumuman->judul . ' — SiMPeDa')

@section('content')

    {{-- Hero --}}
    <section class="bg-brand-600 pt-32 pb-16 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-full opacity-10 pointer-events-none">
            <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                <path d="M0 100 C 20 0 50 0 100 100 Z" fill="white"></path>
            </svg>
        </div>
        <div class="relative z-10 max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white">
            <a href="{{ route('pengumuman.index') }}" class="text-brand-100 text-xs font-bold uppercase tracking-widest hover:text-white inline-block mb-3">
                ← Kembali ke daftar
            </a>
            <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight mb-3">{{ $pengumuman->judul }}</h1>
            <p class="text-brand-100 text-sm">
                <span>{{ $pengumuman->tanggal_terbit?->translatedFormat('d F Y, H:i') }}</span>
                <span class="mx-2">·</span>
                <span>{{ $pengumuman->views }} dibaca</span>
            </p>
        </div>
    </section>

    {{-- Konten --}}
    <section class="bg-slate-50 py-16">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <article class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                @if($pengumuman->gambar)
                    <img src="{{ asset('storage/' . $pengumuman->gambar) }}" alt="{{ $pengumuman->judul }}"
                        class="w-full max-h-[420px] object-cover">
                @endif
                <div class="p-8">
                    @if($pengumuman->ringkasan)
                        <p class="text-slate-600 text-lg font-medium mb-6 border-l-4 border-brand-500 pl-4 italic">
                            {{ $pengumuman->ringkasan }}
                        </p>
                    @endif
                    <div class="prose prose-slate max-w-none text-slate-700 leading-relaxed whitespace-pre-line">
                        {!! nl2br(e($pengumuman->isi)) !!}
                    </div>
                </div>
            </article>

            @if($lainnya->isNotEmpty())
                <div class="mt-12">
                    <h2 class="text-lg font-extrabold text-slate-900 mb-4">Pengumuman Lainnya</h2>
                    <div class="grid sm:grid-cols-3 gap-4">
                        @foreach($lainnya as $l)
                            <a href="{{ route('pengumuman.show', $l->slug) }}"
                                class="bg-white rounded-xl p-4 border border-slate-100 shadow-sm hover:shadow-md transition-shadow group">
                                <div class="text-[10px] text-brand-600 font-bold tracking-wider uppercase mb-1">
                                    {{ $l->tanggal_terbit?->translatedFormat('d M Y') }}
                                </div>
                                <h3 class="font-bold text-sm text-slate-800 line-clamp-2 group-hover:text-brand-600">{{ $l->judul }}</h3>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>

@endsection
