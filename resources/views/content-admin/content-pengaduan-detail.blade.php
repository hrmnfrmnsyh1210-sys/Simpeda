@extends('layout-admin.main-layout-admin')

@section('title', 'Detail Pengaduan #' . $pengaduan->nomor_tiket)

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
@endpush

@section('content')
    {{-- Header --}}
    <div class="mb-6 flex items-center justify-between gap-4 flex-wrap">
        <div>
            <a href="{{ route('admin.pengaduan.index') }}"
                class="inline-flex items-center gap-2 text-xs font-bold text-primary mb-2 hover:underline">
                <i class="bi bi-arrow-left"></i> Kembali ke Daftar
            </a>
            <h1 class="text-2xl font-grotesk font-bold text-gray-800">Tiket #{{ $pengaduan->nomor_tiket }}</h1>
            <p class="text-xs text-gray-400 mt-0.5">Dilaporkan {{ $pengaduan->created_at->diffForHumans() }} &mdash; {{ $pengaduan->created_at->format('d M Y, H:i') }}</p>
        </div>
        <span class="px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider
            {{ $pengaduan->status == 'Menunggu' ? 'bg-red-100 text-red-600 border border-red-200' :
               ($pengaduan->status == 'Diproses'  ? 'bg-amber-100 text-amber-600 border border-amber-200' :
               ($pengaduan->status == 'Selesai'   ? 'bg-green-100 text-green-600 border border-green-200' :
                                                    'bg-gray-100 text-gray-600 border border-gray-200')) }}">
            <i class="bi {{ $pengaduan->status == 'Menunggu' ? 'bi-clock' : ($pengaduan->status == 'Diproses' ? 'bi-arrow-repeat' : ($pengaduan->status == 'Selesai' ? 'bi-check-circle' : 'bi-x-circle')) }} mr-1"></i>
            {{ $pengaduan->status }}
        </span>
    </div>

    {{-- Flash message --}}
    @if(session('success'))
        <div class="mb-5 px-4 py-3 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm flex items-center gap-2">
            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 text-sm">

        {{-- ════ KOLOM KIRI (2/3) ════ --}}
        <div class="lg:col-span-2 space-y-5">

            {{-- Detail Laporan --}}
            <div class="bg-white rounded-radius border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="font-bold text-gray-700 uppercase text-[10px] tracking-widest flex items-center gap-2">
                        <i class="bi bi-file-text text-primary"></i> Isi Laporan
                    </h3>
                    <div class="flex gap-2">
                        <span class="px-2 py-1 bg-primary-light text-primary rounded-lg text-[10px] font-bold uppercase">
                            <i class="bi bi-tag-fill mr-1"></i>{{ $pengaduan->kategori }}
                        </span>
                        <span class="px-2 py-1 rounded-lg text-[10px] font-bold uppercase
                            {{ $pengaduan->urgensi == 'Tinggi' ? 'bg-red-50 text-red-600' : ($pengaduan->urgensi == 'Sedang' ? 'bg-amber-50 text-amber-600' : 'bg-blue-50 text-blue-600') }}">
                            <i class="bi bi-exclamation-triangle-fill mr-1"></i>{{ $pengaduan->urgensi }}
                        </span>
                    </div>
                </div>
                <div class="p-6">
                    <h2 class="text-lg font-bold text-gray-800 mb-3">{{ $pengaduan->judul }}</h2>
                    <p class="text-gray-600 leading-relaxed whitespace-pre-line text-sm">{{ $pengaduan->deskripsi }}</p>
                </div>
            </div>

            {{-- Bukti Foto --}}
            <div class="bg-white rounded-radius border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                    <h3 class="font-bold text-gray-700 uppercase text-[10px] tracking-widest flex items-center gap-2">
                        <i class="bi bi-images text-primary"></i> Bukti Foto Laporan
                    </h3>
                </div>
                <div class="p-6">
                    @if($pengaduan->foto)
                        <div class="relative group w-full rounded-xl overflow-hidden border border-gray-100 shadow-sm bg-gray-50"
                             style="max-height: 420px;">
                            <img src="{{ asset('storage/' . $pengaduan->foto) }}"
                                 class="w-full h-full object-contain max-h-[420px] transition-transform duration-300 group-hover:scale-[1.02]"
                                 alt="Bukti Foto Pengaduan #{{ $pengaduan->nomor_tiket }}">
                            <a href="{{ asset('storage/' . $pengaduan->foto) }}" target="_blank"
                               class="absolute top-3 right-3 px-3 py-1.5 bg-black/60 hover:bg-black/80 text-white rounded-lg text-[11px] font-bold flex items-center gap-1.5 transition-all opacity-0 group-hover:opacity-100">
                                <i class="bi bi-box-arrow-up-right"></i> Buka Full
                            </a>
                        </div>
                        <p class="mt-2 text-[10px] text-gray-400 text-center">
                            Foto yang diunggah pelapor &bull;
                            <a href="{{ asset('storage/' . $pengaduan->foto) }}" target="_blank" class="text-primary hover:underline font-bold">
                                <i class="bi bi-download mr-0.5"></i> Unduh
                            </a>
                        </p>
                    @else
                        <div class="flex flex-col items-center justify-center py-10 text-gray-300">
                            <i class="bi bi-image text-5xl mb-3"></i>
                            <p class="text-sm font-medium text-gray-400">Pelapor tidak menyertakan foto</p>
                            <p class="text-xs text-gray-300 mt-1">Bukti foto bersifat opsional</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Titik Koordinat & Peta --}}
            <div class="bg-white rounded-radius border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                    <h3 class="font-bold text-gray-700 uppercase text-[10px] tracking-widest flex items-center gap-2">
                        <i class="bi bi-geo-alt-fill text-primary"></i> Titik Koordinat Lokasi
                    </h3>
                </div>
                <div class="p-6">
                    @if($pengaduan->latitude && $pengaduan->longitude)
                        {{-- Info koordinat --}}
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mb-4">
                            <div class="bg-primary-light rounded-xl p-3">
                                <div class="text-[10px] text-gray-400 font-bold uppercase mb-1">Latitude</div>
                                <div class="font-mono font-bold text-gray-800 text-sm">{{ $pengaduan->latitude }}</div>
                            </div>
                            <div class="bg-primary-light rounded-xl p-3">
                                <div class="text-[10px] text-gray-400 font-bold uppercase mb-1">Longitude</div>
                                <div class="font-mono font-bold text-gray-800 text-sm">{{ $pengaduan->longitude }}</div>
                            </div>
                            <div class="bg-primary-light rounded-xl p-3 sm:col-span-1 flex items-center gap-2">
                                <a href="https://www.google.com/maps?q={{ $pengaduan->latitude }},{{ $pengaduan->longitude }}"
                                   target="_blank"
                                   class="w-full py-2 bg-primary text-white text-[11px] font-bold rounded-lg hover:bg-primary-dark transition-all flex items-center justify-center gap-1.5">
                                    <i class="bi bi-map-fill"></i> Buka Google Maps
                                </a>
                            </div>
                        </div>

                        @if($pengaduan->alamat_koordinat)
                            <div class="mb-4 px-4 py-2.5 bg-gray-50 border border-gray-100 rounded-xl flex items-start gap-2 text-xs text-gray-600">
                                <i class="bi bi-signpost text-primary mt-0.5 shrink-0"></i>
                                <span>{{ $pengaduan->alamat_koordinat }}</span>
                            </div>
                        @endif

                        {{-- Leaflet Map --}}
                        <div id="admin-map" class="w-full h-72 rounded-xl overflow-hidden border border-gray-200 shadow-sm"></div>
                    @else
                        <div class="flex flex-col items-center justify-center py-10 text-gray-300">
                            <i class="bi bi-geo-alt text-5xl mb-3"></i>
                            <p class="text-sm font-medium text-gray-400">Koordinat tidak tersedia</p>
                            <p class="text-xs text-gray-300 mt-1">Pelapor tidak menyertakan titik lokasi</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Thread Tanggapan --}}
            <div class="bg-white rounded-radius border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="font-bold text-gray-700 uppercase text-[10px] tracking-widest flex items-center gap-2">
                        <i class="bi bi-chat-left-dots-fill text-primary"></i> Diskusi & Tanggapan
                    </h3>
                    <span class="text-[10px] text-gray-400 font-bold">{{ $pengaduan->tanggapan->count() }} pesan</span>
                </div>
                <div class="p-6 space-y-4">
                    @forelse($pengaduan->tanggapan as $t)
                        <div class="flex gap-3 {{ $t->pengirim === 'Petugas' ? '' : 'flex-row-reverse' }}">
                            <div class="w-9 h-9 rounded-full flex items-center justify-center text-white font-bold text-[11px] shrink-0
                                {{ $t->pengirim === 'Petugas' ? 'bg-gradient-to-br from-primary to-[#2d7af0]' : 'bg-gradient-to-br from-amber-400 to-amber-600' }}">
                                {{ strtoupper(substr($t->nama_pengirim, 0, 2)) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 mb-1 {{ $t->pengirim === 'Petugas' ? '' : 'flex-row-reverse' }}">
                                    <span class="text-xs font-bold text-gray-700">{{ $t->nama_pengirim }}</span>
                                    <span class="px-1.5 py-0.5 rounded text-[9px] font-bold uppercase {{ $t->pengirim === 'Petugas' ? 'bg-primary-light text-primary' : 'bg-amber-50 text-amber-700' }}">{{ $t->pengirim }}</span>
                                    @if($t->is_internal)
                                        <span class="px-1.5 py-0.5 rounded text-[9px] font-bold uppercase bg-red-50 text-red-600">Internal</span>
                                    @endif
                                    <span class="text-[10px] text-gray-400">{{ $t->created_at->diffForHumans() }}</span>
                                </div>
                                <div class="px-4 py-2.5 rounded-lg text-sm leading-relaxed whitespace-pre-line
                                    {{ $t->pengirim === 'Petugas' ? 'bg-primary-light text-gray-700' : 'bg-amber-50 text-gray-700' }}">
                                    {{ $t->isi }}
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-400 text-xs py-4">Belum ada tanggapan. Tulis balasan pertama di bawah.</p>
                    @endforelse
                </div>

                {{-- Form Tanggapan --}}
                <form action="{{ route('admin.pengaduan.tanggapan.store', $pengaduan->id) }}" method="POST"
                    class="px-6 pb-6 border-t border-gray-100 pt-4 space-y-3">
                    @csrf
                    <textarea name="isi" rows="3" required minlength="3"
                        placeholder="Tulis tanggapan resmi Anda..."
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:border-primary focus:ring-2 focus:ring-primary-light outline-none transition-all resize-none text-sm"></textarea>
                    <div class="flex items-center justify-between gap-3 flex-wrap">
                        <label class="flex items-center gap-2 text-xs text-gray-600">
                            <input type="checkbox" name="is_internal" value="1" class="w-4 h-4 text-primary rounded">
                            Catatan internal (tidak ditampilkan ke pelapor)
                        </label>
                        <button type="submit"
                            class="px-5 py-2 bg-primary text-white font-bold rounded-lg hover:bg-primary-dark shadow-sm shadow-primary/20 transition-all text-xs flex items-center gap-2">
                            <i class="bi bi-send"></i> Kirim Tanggapan
                        </button>
                    </div>
                </form>
            </div>

            {{-- Data Pelapor --}}
            <div class="bg-white rounded-radius border border-gray-200 shadow-sm p-6">
                <h3 class="font-bold text-gray-700 uppercase text-[10px] tracking-widest border-b pb-3 mb-4 flex items-center gap-2">
                    <i class="bi bi-person text-primary"></i> Identitas Pelapor
                </h3>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-5">
                    <div>
                        <label class="block text-[10px] text-gray-400 font-bold uppercase mb-1">Nama Lengkap</label>
                        <p class="font-bold text-gray-800">{{ $pengaduan->nama_pelapor }}</p>
                    </div>
                    <div>
                        <label class="block text-[10px] text-gray-400 font-bold uppercase mb-1">Nomor HP/WhatsApp</label>
                        <p class="font-bold text-gray-800">
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $pengaduan->nomor_hp) }}"
                               target="_blank"
                               class="text-primary hover:underline flex items-center gap-1">
                                <i class="bi bi-whatsapp text-green-500"></i>{{ $pengaduan->nomor_hp }}
                            </a>
                        </p>
                    </div>
                    <div>
                        <label class="block text-[10px] text-gray-400 font-bold uppercase mb-1">RT / RW</label>
                        <p class="font-bold text-gray-800">{{ $pengaduan->rt_rw }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- ════ KOLOM KANAN (1/3) ════ --}}
        <div class="space-y-5">

            {{-- Form Update Status --}}
            <div class="bg-white rounded-radius border border-gray-200 shadow-sm p-6">
                <h3 class="font-bold text-gray-700 mb-4 flex items-center gap-2 text-xs uppercase tracking-wider">
                    <i class="bi bi-gear-fill text-primary"></i> Tindak Lanjut Petugas
                </h3>

                <form action="{{ route('admin.pengaduan.updateStatus', $pengaduan->id) }}" method="POST" class="space-y-4">
                    @csrf @method('PATCH')
                    <div>
                        <label class="text-[11px] font-bold text-gray-500 block mb-1.5">Status Laporan</label>
                        <select name="status"
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:border-primary focus:ring-2 focus:ring-primary-light outline-none transition-all text-sm">
                            @foreach(['Menunggu', 'Diproses', 'Selesai', 'Ditolak'] as $s)
                                <option value="{{ $s }}" {{ $pengaduan->status == $s ? 'selected' : '' }}>{{ $s }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-[11px] font-bold text-gray-500 block mb-1.5">Catatan / Balasan Petugas</label>
                        <textarea name="komentar_petugas" rows="5"
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:border-primary focus:ring-2 focus:ring-primary-light outline-none transition-all resize-none text-sm"
                            placeholder="Tuliskan progres atau tanggapan resmi...">{{ $pengaduan->komentar_petugas }}</textarea>
                    </div>
                    <button type="submit"
                        class="w-full py-2.5 bg-primary text-white font-bold rounded-lg hover:bg-primary-dark shadow-md shadow-primary/20 transition-all text-sm">
                        <i class="bi bi-check-lg mr-1"></i> Simpan Perubahan
                    </button>
                </form>
            </div>

            {{-- Rating dari Pelapor --}}
            @if($pengaduan->rating)
                <div class="bg-white rounded-radius border border-amber-100 shadow-sm p-5">
                    <h3 class="font-bold text-amber-600 text-xs uppercase tracking-wider mb-3 flex items-center gap-2">
                        <i class="bi bi-star-fill"></i> Rating dari Pelapor
                    </h3>
                    <div class="flex items-center gap-1 mb-2">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="bi {{ $i <= $pengaduan->rating->bintang ? 'bi-star-fill text-amber-400' : 'bi-star text-gray-300' }} text-xl"></i>
                        @endfor
                        <span class="ml-2 font-bold text-gray-700 text-sm">{{ $pengaduan->rating->bintang }}/5</span>
                    </div>
                    @if($pengaduan->rating->ulasan)
                        <div class="bg-amber-50 rounded-lg p-3 text-xs text-gray-700 italic leading-relaxed mb-2">
                            "{{ $pengaduan->rating->ulasan }}"
                        </div>
                    @endif
                    <div class="text-[10px] text-gray-400 flex items-center gap-1">
                        <i class="bi bi-person"></i> {{ $pengaduan->rating->nama_pelapor }} · {{ $pengaduan->rating->created_at->diffForHumans() }}
                    </div>
                </div>
            @endif

            {{-- Info Ringkas --}}
            <div class="bg-white rounded-radius border border-gray-200 shadow-sm p-5 space-y-3">
                <h3 class="font-bold text-gray-700 text-xs uppercase tracking-wider border-b pb-2 mb-3 flex items-center gap-2">
                    <i class="bi bi-info-circle text-primary"></i> Info Tiket
                </h3>
                @php
                    $infoItems = [
                        ['label' => 'Nomor Tiket',   'val' => '#' . $pengaduan->nomor_tiket, 'mono' => true],
                        ['label' => 'Kategori',      'val' => $pengaduan->kategori],
                        ['label' => 'Urgensi',       'val' => $pengaduan->urgensi],
                        ['label' => 'Tanggal Masuk', 'val' => $pengaduan->created_at->format('d M Y, H:i')],
                        ['label' => 'Terakhir Diubah', 'val' => $pengaduan->updated_at->format('d M Y, H:i')],
                    ];
                @endphp
                @foreach($infoItems as $item)
                    <div class="flex justify-between items-start gap-2">
                        <span class="text-[11px] text-gray-400 shrink-0">{{ $item['label'] }}</span>
                        <span class="text-[11px] font-bold text-gray-700 text-right {{ isset($item['mono']) ? 'font-mono text-primary' : '' }}">
                            {{ $item['val'] }}
                        </span>
                    </div>
                @endforeach
            </div>

            {{-- Hapus (superadmin only) --}}
            @if(Auth::user()->role === 'superadmin')
                <div class="bg-white rounded-radius border border-red-100 shadow-sm p-5">
                    <h3 class="font-bold text-red-600 text-xs uppercase tracking-wider mb-3 flex items-center gap-2">
                        <i class="bi bi-exclamation-triangle"></i> Zona Berbahaya
                    </h3>
                    <form action="{{ route('admin.pengaduan.destroy', $pengaduan->id) }}" method="POST"
                          onsubmit="return confirm('Hapus permanen tiket #{{ $pengaduan->nomor_tiket }}? Tindakan ini tidak dapat diurungkan.')">
                        @csrf @method('DELETE')
                        <button type="submit"
                            class="w-full py-2.5 bg-red-50 border border-red-200 text-red-600 font-bold rounded-lg hover:bg-red-600 hover:text-white transition-all text-xs">
                            <i class="bi bi-trash mr-1"></i> Hapus Pengaduan Ini
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    @if($pengaduan->latitude && $pengaduan->longitude)
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const lat = {{ $pengaduan->latitude }};
            const lng = {{ $pengaduan->longitude }};

            const map = L.map('admin-map').setView([lat, lng], 16);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);

            const icon = L.divIcon({
                className: '',
                html: `<div style="
                    width:36px;height:36px;
                    background:#1a56db;
                    border:3px solid white;
                    border-radius:50% 50% 50% 0;
                    transform:rotate(-45deg);
                    box-shadow:0 2px 8px rgba(0,0,0,0.3);">
                    <div style="
                        width:10px;height:10px;
                        background:white;
                        border-radius:50%;
                        position:absolute;top:50%;left:50%;
                        transform:translate(-50%,-50%) rotate(45deg);">
                    </div>
                </div>`,
                iconSize: [36, 36],
                iconAnchor: [18, 36],
                popupAnchor: [0, -36],
            });

            const popup = `
                <div style="font-family:sans-serif;font-size:12px;min-width:160px">
                    <strong style="font-size:13px">#{{ $pengaduan->nomor_tiket }}</strong><br>
                    <span style="color:#6b7280">{{ $pengaduan->nama_pelapor }}</span><br>
                    <span style="color:#6b7280">{{ $pengaduan->kategori }} &bull; {{ $pengaduan->urgensi }}</span>
                    @if($pengaduan->alamat_koordinat)
                    <br><small style="color:#9ca3af">{{ Str::limit($pengaduan->alamat_koordinat, 60) }}</small>
                    @endif
                </div>`;

            L.marker([lat, lng], { icon })
             .addTo(map)
             .bindPopup(popup)
             .openPopup();

            // Lingkaran radius ~50m
            L.circle([lat, lng], { radius: 50, color: '#1a56db', fillColor: '#1a56db', fillOpacity: 0.08, weight: 2 }).addTo(map);
        });
    </script>
    @endif
@endpush
