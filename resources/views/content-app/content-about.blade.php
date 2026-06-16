@extends('layout-app.main-app')

@section('title', 'SiMPeDa — Sistem Manajemen Pengaduan Desa')

@section('content')

    {{-- ═══════════════════════════════════════════════
    SECTION: DYNAMIC HEADER
    ═══════════════════════════════════════════════ --}}
    <section class="bg-brand-600 pt-32 pb-20 relative overflow-hidden">
        {{-- Decorative Background --}}
        <div class="absolute top-0 left-0 w-full h-full opacity-10 pointer-events-none">
            <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                <path d="M0 100 C 20 0 50 0 100 100 Z" fill="white"></path>
            </svg>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white">
            <div class="animate-fade-in">
                <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight mb-4">Layanan Pengaduan Desa</h1>
                <p class="text-brand-100 max-w-2xl mx-auto text-lg">
                    Suara Anda adalah kontribusi nyata bagi kemajuan desa kita.
                    Kenali bagaimana kami memproses setiap aspirasi Anda.
                </p>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════
    SECTION: TENTANG (FEATURES)
    ═══════════════════════════════════════════════ --}}
    <section id="tentang" class="bg-slate-50 py-20 border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-14">
                <span class="text-xs font-bold tracking-widest uppercase text-brand-600 mb-2 block">Kenapa SiMPeDa?</span>
                <h2 class="font-extrabold text-3xl sm:text-4xl text-slate-900 tracking-tight">
                    Pengaduan yang benar-benar ditindak
                </h2>
                <p class="text-slate-500 mt-3 max-w-xl mx-auto text-sm leading-relaxed">
                    Bukan sekadar laporan — setiap pengaduan diverifikasi, diproses,
                    dan dikomunikasikan hasilnya kepada pelapor.
                </p>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @php
                    $features = [
                        ['icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z', 'color' => 'blue', 'title' => 'Terverifikasi', 'desc' => 'Setiap laporan divalidasi petugas sebelum diproses lebih lanjut.'],
                        ['icon' => 'M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z', 'color' => 'indigo', 'title' => 'Transparan', 'desc' => 'Lacak status pengaduan secara real-time dengan nomor tiket unik.'],
                        ['icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0', 'color' => 'violet', 'title' => 'Cepat Respons', 'desc' => 'Target respons kurang dari 24 jam untuk pengaduan prioritas tinggi.'],
                        ['icon' => 'M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z', 'color' => 'sky', 'title' => 'Balasan Resmi', 'desc' => 'Petugas memberikan tanggapan resmi langsung di halaman tiket.'],
                        ['icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01', 'color' => 'teal', 'title' => 'Riwayat Lengkap', 'desc' => 'Semua laporan Anda tersimpan dan dapat diakses kapan saja.'],
                        ['icon' => 'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z', 'color' => 'emerald', 'title' => 'Aman & Privat', 'desc' => 'Data identitas pelapor dijaga kerahasiaannya sesuai regulasi.'],
                    ];
                    $colorMap = [
                        'blue' => ['bg' => 'bg-blue-50', 'icon' => 'text-blue-600'],
                        'indigo' => ['bg' => 'bg-indigo-50', 'icon' => 'text-indigo-600'],
                        'violet' => ['bg' => 'bg-violet-50', 'icon' => 'text-violet-600'],
                        'sky' => ['bg' => 'bg-sky-50', 'icon' => 'text-sky-600'],
                        'teal' => ['bg' => 'bg-teal-50', 'icon' => 'text-teal-600'],
                        'emerald' => ['bg' => 'bg-emerald-50', 'icon' => 'text-emerald-600'],
                    ];
                @endphp
                @foreach($features as $f)
                    @php $c = $colorMap[$f['color']]; @endphp
                    <div
                        class="feature-card bg-white rounded-2xl p-6 border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
                        <div class="w-11 h-11 rounded-xl {{ $c['bg'] }} flex items-center justify-center mb-4">
                            <svg class="w-5 h-5 {{ $c['icon'] }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $f['icon'] }}" />
                            </svg>
                        </div>
                        <h3 class="font-bold text-slate-900 mb-1.5">{{ $f['title'] }}</h3>
                        <p class="text-slate-500 text-sm leading-relaxed">{{ $f['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

@endsection