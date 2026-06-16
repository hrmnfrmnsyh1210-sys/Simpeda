@extends('layout-app.main-app')

@section('title', 'Pengumuman — SiMPeDa')

@section('content')

    {{-- Hero --}}
    <section class="bg-brand-600 pt-32 pb-20 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-full opacity-10 pointer-events-none">
            <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                <path d="M0 100 C 20 0 50 0 100 100 Z" fill="white"></path>
            </svg>
        </div>
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white">
            <span class="text-xs font-bold tracking-widest uppercase text-brand-100 mb-2 block">Informasi Resmi</span>
            <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight mb-4">Pengumuman & Berita</h1>
            <p class="text-brand-100 max-w-2xl mx-auto text-lg">Informasi terbaru seputar layanan dan kegiatan desa.</p>
        </div>
    </section>

    {{-- List --}}
    <section class="bg-slate-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($pengumumans->isEmpty())
                <div class="text-center py-20">
                    <svg class="w-16 h-16 mx-auto text-slate-300 mb-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5.882V19.24a1.76 1.76 0 0 1-3.417.592l-2.147-6.15M18 13a3 3 0 1 0 0-6M5.436 13.683A4 4 0 0 1 7 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 0 1-1.564-.317Z"/>
                    </svg>
                    <p class="text-slate-500">Belum ada pengumuman yang dipublikasikan.</p>
                </div>
            @else
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($pengumumans as $p)
                        <a href="{{ route('pengumuman.show', $p->slug) }}"
                            class="feature-card bg-white rounded-2xl overflow-hidden border border-slate-100 shadow-sm hover:shadow-md transition-shadow group">
                            <div class="aspect-[16/9] bg-gradient-to-br from-brand-100 to-brand-50 overflow-hidden">
                                @if($p->gambar)
                                    <img src="{{ asset('storage/' . $p->gambar) }}" alt="{{ $p->judul }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-brand-300">
                                        <svg class="w-16 h-16" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 1 1 0-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 0 1-1.44-4.282m3.102.069a18.03 18.03 0 0 1-.59-4.59c0-1.586.205-3.124.59-4.59m0 9.18a23.848 23.848 0 0 1 8.835 2.535M10.34 6.66a23.847 23.847 0 0 0 8.835-2.535m0 0A23.74 23.74 0 0 0 18.795 3m.38 1.125a23.91 23.91 0 0 1 1.014 5.395m-1.014 8.855c-.118.38-.245.754-.38 1.125m.38-1.125a23.91 23.91 0 0 0 1.014-5.395m0-3.46c.495.413.811 1.035.811 1.73 0 .695-.316 1.317-.811 1.73m0-3.46a24.347 24.347 0 0 1 0 3.46"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="p-5">
                                <div class="text-[11px] text-brand-600 font-bold tracking-wider uppercase mb-2">
                                    {{ $p->tanggal_terbit?->translatedFormat('d M Y') }}
                                </div>
                                <h3 class="font-bold text-slate-900 mb-2 line-clamp-2 group-hover:text-brand-600 transition-colors">{{ $p->judul }}</h3>
                                @if($p->ringkasan)
                                    <p class="text-sm text-slate-500 line-clamp-3">{{ $p->ringkasan }}</p>
                                @endif
                                <div class="mt-4 flex items-center justify-between text-[11px] text-slate-400">
                                    <span><i class="inline-block w-1 h-1 rounded-full bg-slate-300 mr-1"></i> {{ $p->views }} dibaca</span>
                                    <span class="text-brand-600 font-bold">Baca →</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                @if($pengumumans->hasPages())
                    <div class="mt-10">{{ $pengumumans->links() }}</div>
                @endif
            @endif
        </div>
    </section>

@endsection
