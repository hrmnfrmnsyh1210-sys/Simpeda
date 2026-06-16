<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pengaduan - SiMPeDa</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 10px;
            color: #1e293b;
            background: #ffffff;
            padding: 0;
        }
        a { text-decoration: none; color: inherit; }

        /* ─── HEADER ─── */
        .header-wrap {
            background-color: #1240a8;
            padding: 0;
            margin-bottom: 18px;
        }
        .header-inner {
            width: 100%;
            border-collapse: collapse;
        }
        .header-left {
            padding: 20px 24px;
            vertical-align: middle;
            width: 60%;
        }
        .header-right {
            padding: 20px 24px;
            vertical-align: middle;
            text-align: right;
            width: 40%;
        }
        .brand-name {
            font-size: 22px;
            font-weight: 900;
            color: #ffffff;
            letter-spacing: 1px;
        }
        .brand-sub {
            font-size: 9px;
            color: rgba(255,255,255,0.75);
            margin-top: 3px;
        }
        .doc-label {
            font-size: 8px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: rgba(255,255,255,0.6);
            margin-bottom: 4px;
        }
        .doc-title {
            font-size: 13px;
            font-weight: 800;
            color: #ffffff;
            line-height: 1.3;
        }
        .doc-meta {
            font-size: 8px;
            color: rgba(255,255,255,0.7);
            margin-top: 5px;
            line-height: 1.6;
        }

        /* ─── FILTER BANNER ─── */
        .filter-banner {
            background-color: #eff6ff;
            border: 1px solid #bfdbfe;
            padding: 7px 12px;
            margin-bottom: 14px;
            font-size: 9px;
            color: #1d4ed8;
        }
        .filter-banner strong { font-weight: 800; }

        /* ─── STAT CARDS ─── */
        .stats-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 6px;
            margin-bottom: 14px;
        }
        .stat-card {
            border: 1px solid #e2e8f0;
            padding: 12px 10px 10px;
            text-align: center;
            vertical-align: middle;
            width: 25%;
            background-color: #ffffff;
        }
        .stat-accent {
            height: 3px;
            margin: 0 auto 8px;
            width: 32px;
        }
        .stat-num {
            font-size: 22px;
            font-weight: 900;
            line-height: 1;
            margin-bottom: 4px;
        }
        .stat-lbl {
            font-size: 8px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }
        .c-blue   { color: #1a56db; }
        .c-red    { color: #dc2626; }
        .c-amber  { color: #d97706; }
        .c-green  { color: #16a34a; }
        .c-gray   { color: #64748b; }
        .bg-blue  { background-color: #1a56db; }
        .bg-red   { background-color: #dc2626; }
        .bg-amber { background-color: #d97706; }
        .bg-green { background-color: #16a34a; }

        /* ─── SECTION HEADING ─── */
        .section-heading {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        .section-heading td {
            padding: 0;
            vertical-align: middle;
        }
        .section-title {
            font-size: 10px;
            font-weight: 800;
            color: #0f1f5c;
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }
        .section-line {
            border-bottom: 2px solid #1a56db;
            padding-bottom: 5px;
            margin-bottom: 10px;
        }

        /* ─── BREAKDOWN BOXES ─── */
        .breakdown-outer {
            width: 100%;
            border-collapse: separate;
            border-spacing: 6px;
            margin-bottom: 14px;
        }
        .breakdown-box {
            border: 1px solid #e2e8f0;
            background-color: #f8fafc;
            padding: 12px 14px;
            vertical-align: top;
            width: 50%;
        }
        .bb-heading {
            font-size: 9px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            color: #475569;
            padding-bottom: 8px;
            border-bottom: 1px solid #e2e8f0;
            margin-bottom: 6px;
        }
        .bb-row-table {
            width: 100%;
            border-collapse: collapse;
        }
        .bb-row-table tr { border-bottom: 1px solid #f1f5f9; }
        .bb-row-table tr:last-child { border-bottom: none; }
        .bb-row-table td { padding: 5px 0; font-size: 9px; }
        .bb-lbl { color: #475569; }
        .bb-val { font-weight: 800; color: #1e293b; text-align: right; }

        /* ─── DATA TABLE ─── */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9px;
            margin-bottom: 16px;
        }
        .data-table thead tr {
            background-color: #0f1f5c;
        }
        .data-table thead th {
            color: #ffffff;
            padding: 8px 9px;
            font-size: 8px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            text-align: left;
            border: none;
        }
        .data-table tbody tr.row-even { background-color: #f8fafc; }
        .data-table tbody tr.row-odd  { background-color: #ffffff; }
        .data-table tbody td {
            padding: 7px 9px;
            border-bottom: 1px solid #e2e8f0;
            vertical-align: top;
        }
        .td-no    { text-align: center; color: #94a3b8; font-weight: 700; }
        .td-tiket { font-weight: 800; color: #1a56db; font-size: 8.5px; }
        .td-name  { font-weight: 700; color: #1e293b; }
        .td-sub   { font-size: 8px; color: #94a3b8; margin-top: 1px; }
        .td-judul { font-weight: 600; color: #334155; }

        /* ─── BADGES ─── */
        .badge {
            display: inline;
            padding: 2px 6px;
            font-size: 7.5px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
        .badge-menunggu { background-color: #fee2e2; color: #dc2626; }
        .badge-diproses { background-color: #fef3c7; color: #d97706; }
        .badge-selesai  { background-color: #dcfce7; color: #16a34a; }
        .badge-ditolak  { background-color: #f1f5f9; color: #64748b; }

        .urgency {
            display: inline;
            padding: 2px 6px;
            font-size: 7.5px;
            font-weight: 800;
            text-transform: uppercase;
        }
        .urgency-tinggi { background-color: #fee2e2; color: #dc2626; }
        .urgency-sedang { background-color: #fef3c7; color: #d97706; }
        .urgency-rendah { background-color: #dbeafe; color: #2563eb; }

        /* ─── EMPTY STATE ─── */
        .empty-state {
            text-align: center;
            padding: 28px;
            color: #94a3b8;
            font-style: italic;
            font-size: 10px;
            border: 1px solid #e2e8f0;
        }

        /* ─── FOOTER ─── */
        .footer-table {
            width: 100%;
            border-collapse: collapse;
            border-top: 1px solid #e2e8f0;
            padding-top: 10px;
            margin-top: 10px;
        }
        .footer-table td {
            padding-top: 10px;
            font-size: 8.5px;
            color: #94a3b8;
        }
        .footer-right { text-align: right; }
        .footer-table strong { color: #64748b; }

        /* ─── PAGE MARGINS ─── */
        .page-wrap { padding: 0 28px 20px; }
    </style>
</head>
<body>

{{-- ═══ HEADER ═══ --}}
<div class="header-wrap">
    <table class="header-inner">
        <tr>
            <td class="header-left">
                <div class="brand-name">SiMPeDa</div>
                <div class="brand-sub">Sistem Manajemen Pengaduan Desa</div>
            </td>
            <td class="header-right">
                <div class="doc-label">Laporan Resmi</div>
                <div class="doc-title">Summary Pengaduan<br>Masyarakat</div>
                <div class="doc-meta">
                    Dicetak: {{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM Y, HH:mm') }} WIB<br>
                    Oleh: {{ Auth::user()->name }} &mdash; {{ ucfirst(Auth::user()->role) }}
                </div>
            </td>
        </tr>
    </table>
</div>

<div class="page-wrap">

    {{-- ═══ FILTER AKTIF ═══ --}}
    @if($filterStatus || $filterKategori || $filterSearch)
        <div class="filter-banner">
            <strong>Filter Aktif:</strong>
            @if($filterSearch) &nbsp;&#x2022; Pencarian: &ldquo;{{ $filterSearch }}&rdquo;@endif
            @if($filterKategori) &nbsp;&#x2022; Kategori: {{ $filterKategori }}@endif
            @if($filterStatus) &nbsp;&#x2022; Status: {{ $filterStatus }}@endif
        </div>
    @endif

    {{-- ═══ STATISTIK ═══ --}}
    <table class="stats-table">
        <tr>
            <td class="stat-card">
                <div class="stat-accent bg-blue"></div>
                <div class="stat-num c-blue">{{ number_format($stats['total']) }}</div>
                <div class="stat-lbl c-blue">Total Laporan</div>
            </td>
            <td class="stat-card">
                <div class="stat-accent bg-red"></div>
                <div class="stat-num c-red">{{ number_format($stats['menunggu']) }}</div>
                <div class="stat-lbl c-red">Menunggu</div>
            </td>
            <td class="stat-card">
                <div class="stat-accent bg-amber"></div>
                <div class="stat-num c-amber">{{ number_format($stats['diproses']) }}</div>
                <div class="stat-lbl c-amber">Diproses</div>
            </td>
            <td class="stat-card">
                <div class="stat-accent bg-green"></div>
                <div class="stat-num c-green">{{ number_format($stats['selesai']) }}</div>
                <div class="stat-lbl c-green">Selesai</div>
            </td>
        </tr>
    </table>

    {{-- ═══ BREAKDOWN ═══ --}}
    @php $divider = $stats['total'] > 0 ? $stats['total'] : 1; @endphp
    <table class="breakdown-outer">
        <tr>
            {{-- Sebaran per Kategori --}}
            <td class="breakdown-box">
                <div class="bb-heading">Sebaran per Kategori</div>
                <table class="bb-row-table">
                    @foreach($byKategori as $kat => $jumlah)
                        @php $pct = round(($jumlah / $divider) * 100); $rem = 100 - $pct; @endphp
                        <tr>
                            <td class="bb-lbl">{{ $kat }}</td>
                            <td class="bb-val">{{ $jumlah }} &nbsp;<span class="c-gray">({{ $pct }}%)</span></td>
                        </tr>
                        <tr>
                            <td colspan="2" style="padding: 2px 0 5px;">
                                <table width="100%" cellspacing="0" cellpadding="0" style="border-collapse: collapse; height: 4px;">
                                    <tr>
                                        <td width="{{ $pct }}%" style="background-color: #1a56db; height: 4px;"></td>
                                        @if($rem > 0)<td width="{{ $rem }}%" style="background-color: #e2e8f0; height: 4px;"></td>@endif
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </td>

            {{-- Sebaran per Urgensi --}}
            <td class="breakdown-box">
                <div class="bb-heading">Sebaran per Urgensi</div>
                <table class="bb-row-table">
                    @foreach($byUrgensi as $urg => $jumlah)
                        @php
                            $pct    = round(($jumlah / $divider) * 100);
                            $rem    = 100 - $pct;
                            $urgClr = $urg === 'Tinggi' ? '#dc2626' : ($urg === 'Sedang' ? '#d97706' : '#1a56db');
                        @endphp
                        <tr>
                            <td class="bb-lbl">{{ $urg ?? '-' }}</td>
                            <td class="bb-val">{{ $jumlah }} &nbsp;<span class="c-gray">({{ $pct }}%)</span></td>
                        </tr>
                        <tr>
                            <td colspan="2" style="padding: 2px 0 5px;">
                                <table width="100%" cellspacing="0" cellpadding="0" style="border-collapse: collapse; height: 4px;">
                                    <tr>
                                        <td width="{{ $pct }}%" style="background-color: {{ $urgClr }}; height: 4px;"></td>
                                        @if($rem > 0)<td width="{{ $rem }}%" style="background-color: #e2e8f0; height: 4px;"></td>@endif
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </td>
        </tr>
    </table>

    {{-- ═══ TABEL DETAIL ═══ --}}
    <div class="section-line">
        <span class="section-title">Detail Pengaduan &mdash; {{ $pengaduans->count() }} Data</span>
    </div>

    @if($pengaduans->isEmpty())
        <div class="empty-state">Tidak ada data pengaduan yang ditemukan.</div>
    @else
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 22px; text-align: center;">No</th>
                    <th style="width: 78px;">No. Tiket</th>
                    <th style="width: 100px;">Pelapor</th>
                    <th>Judul Pengaduan</th>
                    <th style="width: 75px;">Kategori</th>
                    <th style="width: 52px; text-align: center;">Urgensi</th>
                    <th style="width: 62px; text-align: center;">Status</th>
                    <th style="width: 60px; text-align: center;">Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pengaduans as $i => $item)
                    <tr class="{{ $i % 2 === 0 ? 'row-odd' : 'row-even' }}">
                        <td class="td-no">{{ $i + 1 }}</td>
                        <td><span class="td-tiket">#{{ $item->nomor_tiket }}</span></td>
                        <td>
                            <span class="td-name">{{ $item->nama_pelapor }}</span>
                            @if($item->rt_rw)
                                <div class="td-sub">RT/RW {{ $item->rt_rw }}</div>
                            @endif
                        </td>
                        <td class="td-judul">{{ \Illuminate\Support\Str::limit($item->judul, 65) }}</td>
                        <td>{{ $item->kategori }}</td>
                        <td style="text-align: center;">
                            @php $urg = strtolower($item->urgensi ?? ''); @endphp
                            <span class="urgency urgency-{{ $urg }}">{{ strtoupper($item->urgensi ?? '-') }}</span>
                        </td>
                        <td style="text-align: center;">
                            @php $st = strtolower($item->status ?? ''); @endphp
                            <span class="badge badge-{{ $st }}">{{ $item->status }}</span>
                        </td>
                        <td style="text-align: center; color: #64748b;">{{ $item->created_at->format('d/m/Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    {{-- ═══ FOOTER ═══ --}}
    <table class="footer-table">
        <tr>
            <td>
                <strong>SiMPeDa</strong> &mdash; Sistem Manajemen Pengaduan Desa<br>
                Dokumen digenerate otomatis &mdash; bukan merupakan dokumen resmi yang disahkan tanda tangan.
            </td>
            <td class="footer-right">
                Jumlah data: <strong>{{ $pengaduans->count() }} pengaduan</strong><br>
                &copy; {{ date('Y') }} SiMPeDa. Hak cipta dilindungi.
            </td>
        </tr>
    </table>

</div>
</body>
</html>
