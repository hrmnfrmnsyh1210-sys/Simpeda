@extends('layout-app.main-app')

@section('title', 'Profil Desa — SiMPeDa')

@section('content')

{{-- ═══════════════════════════════════════════════
    SECTION 1 — HERO PROFIL DESA (sambutan mencolok)
    ═══════════════════════════════════════════════ --}}
<section class="relative noise hero-bg overflow-hidden pt-16">

    <div class="absolute top-0 right-0 w-[600px] h-[600px] rounded-full bg-white/[.04] -translate-y-1/2 translate-x-1/3 pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 w-[400px] h-[400px] rounded-full bg-white/[.03] translate-y-1/2 -translate-x-1/4 pointer-events-none"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-28 text-center">
        <div class="inline-flex items-center gap-2 bg-white/10 border border-white/20 rounded-full px-4 py-1.5 text-xs text-white/80 mb-6 animate-fade-up">
            <span class="w-1.5 h-1.5 rounded-full bg-amber-300 inline-block"></span>
            Profil Resmi Pemerintah Desa
        </div>

        <h1 class="font-extrabold text-4xl sm:text-5xl lg:text-[56px] text-white leading-[1.1] tracking-tight mb-6 animate-fade-up-d1">
            Melayani dengan Hati,<br>
            <span class="text-brand-200">Membangun dengan Integritas.</span>
        </h1>

        <p class="text-white/75 text-lg leading-relaxed mb-8 max-w-2xl mx-auto animate-fade-up-d2">
            Kantor Desa hadir sebagai garda depan pelayanan masyarakat — transparan, akuntabel,
            dan berorientasi pada kesejahteraan warga. Mari kita bangun desa bersama.
        </p>
    </div>
</section>

{{-- ═══════════════════════════════════════════════
    SECTION 2 — KATA SAMBUTAN / PENGHARGAAN MENCOLOK
    ═══════════════════════════════════════════════ --}}
<section class="bg-gradient-to-br from-amber-50 via-white to-brand-50 py-16 border-b border-slate-100">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-3 gap-6">

            {{-- Quote besar mencolok --}}
            <div class="lg:col-span-2 relative bg-white rounded-3xl p-8 lg:p-10 border border-amber-200 shadow-lg overflow-hidden">
                <div class="absolute -top-6 -right-6 w-32 h-32 rounded-full bg-amber-100/60"></div>
                <div class="absolute -bottom-8 -left-8 w-40 h-40 rounded-full bg-brand-100/40"></div>

                <svg class="w-12 h-12 text-amber-400 mb-4 relative" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M3 21c3 0 7-1 7-8V5c0-1.25-.756-2.017-2-2H4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2 1 0 1 0 1 1v1c0 1-1 2-2 2s-1 .008-1 1.031V20c0 1 0 1 1 1zM15 21c3 0 7-1 7-8V5c0-1.25-.757-2.017-2-2h-4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 1.974 2H17c1 0 1 0 1 1v1c0 1-1 2-2 2s-1 .008-1 1.031V20c0 1 0 1 1 1z"/>
                </svg>

                <p class="relative text-xl lg:text-2xl text-slate-800 font-semibold leading-snug mb-6">
                    &ldquo;Desa yang maju lahir dari warga yang peduli dan pemerintah yang
                    <span class="text-brand-700">mendengar</span>.
                    Bersama SiMPeDa, suara Anda menjadi langkah nyata pembangunan.&rdquo;
                </p>

                <div class="relative flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full bg-brand-600 flex items-center justify-center text-white font-bold text-lg">
                        KD
                    </div>
                    <div>
                        <div class="font-bold text-slate-900">Kepala Desa</div>
                        <div class="text-xs text-slate-500">Sambutan Resmi</div>
                    </div>
                </div>
            </div>

            {{-- Penghargaan card --}}
            <div class="bg-brand-700 rounded-3xl p-8 text-white relative overflow-hidden shadow-lg">
                <div class="absolute -top-10 -right-10 w-40 h-40 rounded-full bg-white/10"></div>

                <div class="relative">
                    <div class="w-12 h-12 rounded-2xl bg-white/15 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-amber-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                        </svg>
                    </div>

                    <h3 class="font-extrabold text-xl mb-2">Penghargaan</h3>
                    <p class="text-white/70 text-sm mb-5 leading-relaxed">
                        Pengakuan atas dedikasi pelayanan masyarakat desa.
                    </p>

                    <ul class="space-y-3">
                        @foreach($penghargaan as $p)
                            <li class="flex gap-3 text-sm">
                                <span class="shrink-0 inline-flex items-center justify-center w-10 h-10 rounded-lg bg-amber-300 text-brand-800 font-extrabold text-xs">{{ $p['tahun'] }}</span>
                                <div>
                                    <div class="font-semibold text-white leading-snug">{{ $p['judul'] }}</div>
                                    <div class="text-white/60 text-xs">{{ $p['pemberi'] }}</div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════
    SECTION 3 — VISI & MISI
    ═══════════════════════════════════════════════ --}}
<section class="bg-white py-16 border-b border-slate-100">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-2 gap-6">
            <div class="bg-slate-50 rounded-2xl p-7 border border-slate-100">
                <div class="inline-flex items-center gap-2 text-brand-700 font-bold uppercase text-xs tracking-widest mb-3">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    Visi
                </div>
                <p class="text-slate-700 text-base leading-relaxed">
                    Mewujudkan desa yang mandiri, sejahtera, dan berdaya saing melalui pelayanan
                    publik yang prima serta partisipasi aktif seluruh lapisan masyarakat.
                </p>
            </div>

            <div class="bg-slate-50 rounded-2xl p-7 border border-slate-100">
                <div class="inline-flex items-center gap-2 text-brand-700 font-bold uppercase text-xs tracking-widest mb-3">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                    Misi
                </div>
                <ul class="space-y-2 text-slate-700 text-sm leading-relaxed list-disc list-inside marker:text-brand-500">
                    <li>Meningkatkan kualitas pelayanan administrasi & publik desa.</li>
                    <li>Membangun infrastruktur dan ekonomi desa secara berkelanjutan.</li>
                    <li>Mendorong transparansi dan akuntabilitas pemerintahan desa.</li>
                    <li>Memperkuat partisipasi masyarakat dalam pembangunan.</li>
                </ul>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════
    SECTION 4 — TABEL STRUKTUR ORGANISASI KANTOR DESA
    ═══════════════════════════════════════════════ --}}
<section id="struktur" class="bg-slate-50 py-20">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center mb-10">
            <span class="text-xs font-bold tracking-widest uppercase text-brand-600 mb-2 block">Profil Desa</span>
            <h2 class="font-extrabold text-3xl sm:text-4xl text-slate-900 tracking-tight">
                Struktur Organisasi Kantor Desa
            </h2>
            <p class="text-slate-500 mt-3 max-w-xl mx-auto text-sm leading-relaxed">
                Berikut daftar pejabat dan staf pemerintah desa yang bertugas melayani masyarakat.
            </p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-brand-600 text-white">
                        <tr>
                            <th class="px-4 py-3 text-left font-semibold w-16">No.</th>
                            <th class="px-4 py-3 text-left font-semibold">Jabatan</th>
                            <th class="px-4 py-3 text-left font-semibold">Nama</th>
                            <th class="px-4 py-3 text-left font-semibold">NIP / NIAP</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($struktur as $i => $row)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-4 py-3 text-slate-500">{{ $i + 1 }}</td>
                                <td class="px-4 py-3 font-semibold text-slate-800">{{ $row->jabatan }}</td>
                                <td class="px-4 py-3 text-slate-700">{{ $row->nama }}</td>
                                <td class="px-4 py-3 text-slate-500 font-mono text-xs">{{ $row->nip ?: '—' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-10 text-center text-slate-400 text-sm">
                                    Data struktur organisasi belum tersedia.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <p class="text-center text-xs text-slate-400 mt-4">
            *Data dapat diperbarui sesuai pembaruan pejabat & staf desa.
        </p>
    </div>
</section>

@endsection
