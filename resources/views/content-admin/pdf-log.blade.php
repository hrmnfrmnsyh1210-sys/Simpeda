<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Kunjungan - SiMPeDa</title>
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

        /* ─── SECTION HEADING ─── */
        .section-line {
            border-bottom: 2px solid #1a56db;
            padding-bottom: 5px;
            margin-bottom: 10px;
        }
        .section-title {
            font-size: 10px;
            font-weight: 800;
            color: #0f1f5c;
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }

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
        .td-name  { font-weight: 700; color: #1e293b; }
        .td-sub   { font-size: 8px; color: #94a3b8; margin-top: 1px; }

        .badge {
            display: inline;
            padding: 2px 6px;
            font-size: 7.5px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            background-color: #eef3ff;
            color: #1a56db;
        }

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
                <div class="doc-title">Laporan Kunjungan<br>Pengguna Sistem</div>
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
    @if($filterAction || $filterDari || $filterSampai)
        <div class="filter-banner">
            <strong>Filter Aktif:</strong>
            @if($filterAction) &nbsp;&#x2022; Aksi: &ldquo;{{ $filterAction }}&rdquo;@endif
            @if($filterDari) &nbsp;&#x2022; Dari: {{ \Carbon\Carbon::parse($filterDari)->format('d/m/Y') }}@endif
            @if($filterSampai) &nbsp;&#x2022; Sampai: {{ \Carbon\Carbon::parse($filterSampai)->format('d/m/Y') }}@endif
        </div>
    @endif

    {{-- ═══ TABEL DETAIL ═══ --}}
    <div class="section-line">
        <span class="section-title">Riwayat Kunjungan &amp; Aktivitas &mdash; {{ $logs->count() }} Data</span>
    </div>

    @if($logs->isEmpty())
        <div class="empty-state">Tidak ada data kunjungan/aktivitas yang ditemukan.</div>
    @else
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 22px; text-align: center;">No</th>
                    <th style="width: 85px;">Waktu</th>
                    <th style="width: 130px;">Pengguna</th>
                    <th style="width: 90px;">Aksi</th>
                    <th>Target &amp; Keterangan</th>
                    <th style="width: 80px;">IP Address</th>
                </tr>
            </thead>
            <tbody>
                @foreach($logs as $i => $log)
                    <tr class="{{ $i % 2 === 0 ? 'row-odd' : 'row-even' }}">
                        <td class="td-no">{{ $i + 1 }}</td>
                        <td>
                            {{ $log->created_at->format('d/m/Y') }}
                            <div class="td-sub">{{ $log->created_at->format('H:i:s') }}</div>
                        </td>
                        <td>
                            <span class="td-name">{{ $log->user->name ?? '—' }}</span>
                            <div class="td-sub">{{ $log->user->role ?? '' }}</div>
                        </td>
                        <td><span class="badge">{{ $log->action }}</span></td>
                        <td>
                            <span class="td-name">{{ $log->target }}</span>
                            <div class="td-sub">{{ $log->keterangan ?? '—' }}</div>
                        </td>
                        <td style="font-family: monospace; color: #64748b;">{{ $log->ip_address ?? '—' }}</td>
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
                Jumlah data: <strong>{{ $logs->count() }} entri</strong><br>
                &copy; {{ date('Y') }} SiMPeDa. Hak cipta dilindungi.
            </td>
        </tr>
    </table>

</div>
</body>
</html>
