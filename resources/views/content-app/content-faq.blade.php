@extends('layout-app.main-app')

@section('title', 'FAQ — SiMPeDa')

@php
    $faqs = [
        'Umum' => [
            [
                'pertanyaan' => 'Apa itu SiMPeDa?',
                'jawaban'    => 'SiMPeDa (Sistem Manajemen Pengaduan Desa) adalah layanan pengaduan online untuk masyarakat agar dapat melaporkan permasalahan pelayanan publik.',
            ],
        ],
        'Pengaduan' => [
            [
                'pertanyaan' => 'Bagaimana cara membuat laporan pengaduan?',
                'jawaban'    => 'Klik menu Pengaduan, isi formulir dengan benar (kategori, judul, deskripsi, foto, dan koordinat), lalu klik Kirim. Anda akan mendapatkan nomor tiket.',
            ],
            [
                'pertanyaan' => 'Berapa lama pengaduan akan ditindaklanjuti?',
                'jawaban'    => 'Pengaduan biasanya direspons dalam 1x24 jam hari kerja. Lama penyelesaian tergantung kategori dan kompleksitas masalah.',
            ],
            [
                'pertanyaan' => 'Bagaimana cara melacak status laporan saya?',
                'jawaban'    => 'Buka menu Lacak Pengaduan lalu masukkan nomor tiket yang Anda terima saat membuat laporan.',
            ],
        ],
        'Privasi' => [
            [
                'pertanyaan' => 'Apakah identitas pelapor dirahasiakan?',
                'jawaban'    => 'Ya. Data pribadi pelapor hanya diakses oleh petugas yang berwenang dan tidak dipublikasikan.',
            ],
        ],
    ];
@endphp

@section('content')

    <section class="bg-brand-600 pt-32 pb-20 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-full opacity-10 pointer-events-none">
            <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                <path d="M0 100 C 20 0 50 0 100 100 Z" fill="white"></path>
            </svg>
        </div>
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white">
            <span class="text-xs font-bold tracking-widest uppercase text-brand-100 mb-2 block">Bantuan</span>
            <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight mb-4">Pertanyaan Sering Ditanyakan</h1>
            <p class="text-brand-100 max-w-2xl mx-auto text-lg">Jawaban singkat seputar layanan SiMPeDa.</p>
        </div>
    </section>

    <section class="bg-slate-50 py-16">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            @foreach($faqs as $kategori => $items)
                <div class="mb-10">
                    <h2 class="text-xs font-bold uppercase tracking-widest text-brand-600 mb-4">{{ $kategori }}</h2>
                    <div class="space-y-3">
                        @foreach($items as $f)
                            <details class="bg-white rounded-2xl border border-slate-100 shadow-sm group">
                                <summary class="cursor-pointer list-none px-5 py-4 flex items-start justify-between gap-4">
                                    <span class="font-bold text-slate-900 text-sm sm:text-base">{{ $f['pertanyaan'] }}</span>
                                    <span class="w-8 h-8 rounded-full bg-brand-50 text-brand-600 flex items-center justify-center shrink-0 group-open:rotate-45 transition-transform">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                                        </svg>
                                    </span>
                                </summary>
                                <div class="px-5 pb-5 text-sm text-slate-600 leading-relaxed border-t border-slate-100 pt-3 whitespace-pre-line">
                                    {{ $f['jawaban'] }}
                                </div>
                            </details>
                        @endforeach
                    </div>
                </div>
            @endforeach

            <div class="mt-12 text-center bg-white rounded-2xl border border-slate-100 shadow-sm p-8">
                <h3 class="font-extrabold text-slate-900 text-lg mb-2">Tidak menemukan jawaban?</h3>
                <p class="text-sm text-slate-500 mb-4">Sampaikan pertanyaan Anda langsung melalui formulir pengaduan.</p>
                <a href="{{ route('pengaduan') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-brand-600 text-white font-bold text-sm rounded-xl hover:bg-brand-700 transition-colors">
                    Buat Pengaduan
                </a>
            </div>
        </div>
    </section>

@endsection
