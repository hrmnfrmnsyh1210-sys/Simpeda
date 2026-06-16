@extends('layout-app.main-app')

@section('title', 'SiMPeDa — Sistem Manajemen Pengaduan Desa')

@section('content')

{{-- ═══════════════════════════════════════════════
    SECTION 1 — HERO
    ═══════════════════════════════════════════════ --}}
<section id="beranda" class="relative noise hero-bg overflow-hidden pt-16">

    {{-- Decorative circles --}}
    <div
        class="absolute top-0 right-0 w-[600px] h-[600px] rounded-full bg-white/[.04] -translate-y-1/2 translate-x-1/3 pointer-events-none">
    </div>
    <div
        class="absolute bottom-0 left-0 w-[400px] h-[400px] rounded-full bg-white/[.03] translate-y-1/2 -translate-x-1/4 pointer-events-none">
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-32">
        <div class="grid lg:grid-cols-2 gap-16 items-center">

            {{-- Left copy --}}
            <div>
                <div
                    class="inline-flex items-center gap-2 bg-white/10 border border-white/20 rounded-full px-4 py-1.5 text-xs text-white/80 mb-6 animate-fade-up">
                    <span class="w-1.5 h-1.5 rounded-full bg-green-400 inline-block"></span>
                    Sistem aktif &amp; siap melayani 24/7
                </div>

                <h1
                    class="font-extrabold text-4xl sm:text-5xl lg:text-[56px] text-white leading-[1.1] tracking-tight mb-6 animate-fade-up-d1">
                    Suaramu penting.<br>
                    <span class="text-brand-200">Kami dengarkan.</span>
                </h1>

                <p class="text-white/70 text-lg leading-relaxed mb-8 max-w-lg animate-fade-up-d2">
                    Platform pengaduan warga yang transparan, terstruktur, dan dapat dilacak secara real-time. Laporkan
                    masalah di lingkunganmu dalam hitungan menit.
                </p>

                <div class="flex flex-wrap gap-3 animate-fade-up-d3">
                    <a href="{{ route('pengaduan') }}"
                        class="inline-flex items-center gap-2 px-6 py-3 bg-white text-brand-700 font-bold rounded-xl hover:bg-brand-50 transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        Buat Pengaduan
                    </a>
                    <a href=" {{ route('pengaduan') }}"
                        class="inline-flex items-center gap-2 px-6 py-3 bg-white/10 border border-white/20 text-white font-semibold rounded-xl hover:bg-white/20 transition-all">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Lacak Tiket
                    </a>
                </div>
            </div>

            {{-- Right stats cards --}}
            <div class="grid grid-cols-2 gap-4 animate-fade-up-d2">
                @php
                $stats = [
                ['icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2', 'num' => number_format($totalPengaduan), 'label' => 'Total Pengaduan'],
                ['icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0', 'num' => $persenSelesai . '%', 'label' => 'Terselesaikan'],
                ['icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0', 'num' => '<24j', 'label' => 'Rata-rata Respons'],
                ['icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z', 'num' => $wilayahTerlayani . ' RT', 'label' => 'Wilayah Terlayani'],
                ];
                @endphp
                    @foreach($stats as $i => $stat)
                    <div
                        class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl p-5 {{ $i === 0 ? 'col-span-2 sm:col-span-1' : '' }}">
                        <div class="w-9 h-9 rounded-xl bg-white/15 flex items-center justify-center mb-3">
                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $stat['icon'] }}" />
                            </svg>
                        </div>
                        <div class="font-extrabold text-2xl text-white leading-none">{{ $stat['num'] }}</div>
                        <div class="text-white/60 text-xs mt-1">{{ $stat['label'] }}</div>
                    </div>
                    @endforeach
            </div>
        </div>
    </div>


</section>



@endsection

@push('scripts')
<script>
    function switchTab(tab) {
        const btnForm = document.getElementById('tab-form');
        const btnLacak = document.getElementById('tab-lacak');
        const panelForm = document.getElementById('panel-form');
        const panelLacak = document.getElementById('panel-lacak');

        if (tab === 'form') {
            btnForm.classList.add('active');
            btnLacak.classList.remove('active');
            btnLacak.classList.add('text-slate-500');
            panelForm.classList.remove('hidden');
            panelLacak.classList.add('hidden');
        } else {
            btnLacak.classList.add('active');
            btnForm.classList.remove('active');
            btnForm.classList.add('text-slate-500');
            panelLacak.classList.remove('hidden');
            panelForm.classList.add('hidden');
        }
    }

    // Script untuk menampilkan nama file yang dipilih
    document.getElementById('foto').addEventListener('change', function(e) {
        const fileName = e.target.files[0] ? e.target.files[0].name : "";
        const label = document.getElementById('file-name');
        if (fileName) {
            label.innerText = "Terpilih: " + fileName;
            label.classList.remove('hidden');
        } else {
            label.classList.add('hidden');
        }
    });

    if (window.location.hash === '#lacak' || new URLSearchParams(window.location.search).has('tiket')) {
        switchTab('lacak');
    }
</script>
@endpush