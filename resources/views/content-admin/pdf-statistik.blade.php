<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pengunjung - SiMPeDa</title>
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
            width: 55%;
        }
        .header-right {
            padding: 20px 24px;
            vertical-align: middle;
            text-align: right;
            width: 45%;
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

        /* ─── STAT CARDS ─── */
        .stats-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 6px;
            margin-bottom: 16px;
        }
        .stat-card {
            border: 1px solid #e2e8f0;
            padding: 12px 10px 10px;
            text-align: center;
            vertical-align: middle;
            width: 33.33%;
            background-color: #ffffff;
        }
        .stat-accent {
            height: 3px;
            margin: 0 auto 8px;
            width: 32px;
            background-color: #1a56db;
        }
        .stat-num {
            font-size: 22px;
            font-weight: 900;
            line-height: 1;
            margin-bottom: 4px;
            color: #1a56db;
        }
        .stat-lbl {
            font-size: 8px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: #64748b;
        }

        /* ─── SECTION HEADING ─── */
        .section-line {
            border-bottom: 2px solid #1a56db;
            padding-bottom: 5px;
            margin-bottom: 10px;
            margin-top: 18px;
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
            margin-bottom: 6px;
        }
        .data-table thead tr {
            background-color: #0f1f5c;
        }
        .data-table thead th {
            color: #ffffff;
            padding: 7px 9px;
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
            padding: 6px 9px;
            border-bottom: 1px solid #e2e8f0;
        }
        .td-jumlah { text-align: right; font-weight: 800; color: #1a56db; }

        /* ─── TWO COLUMN LAYOUT ─── */
        .two-col {
            width: 100%;
            border-collapse: separate;
            border-spacing: 10px 0;
        }
        .two-col-cell {
            width: 50%;
            vertical-align: top;
        }

        /* ─── FOOTER ─── */
        .footer-table {
            width: 100%;
            border-collapse: collapse;
            border-top: 1px solid #e2e8f0;
            padding-top: 10px;
            margin-top: 16px;
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
                <div class="doc-title">Laporan Statistik<br>Pengunjung Aplikasi</div>
                <div class="doc-meta">
                    Dicetak: {{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM Y, HH:mm') }} WIB<br>
                    Oleh: {{ Auth::user()->name }} &mdash; {{ ucfirst(Auth::user()->role) }}
                </div>
            </td>
        </tr>
    </table>
</div>

<div class="page-wrap">

    {{-- ═══ RINGKASAN ═══ --}}
    <table class="stats-table">
        <tr>
            <td class="stat-card">
                <div class="stat-accent"></div>
                <div class="stat-num">{{ number_format($ringkasan['hari_ini']) }}</div>
                <div class="stat-lbl">Pengunjung Hari Ini</div>
            </td>
            <td class="stat-card">
                <div class="stat-accent"></div>
                <div class="stat-num">{{ number_format($ringkasan['minggu_ini']) }}</div>
                <div class="stat-lbl">Pengunjung Minggu Ini</div>
            </td>
            <td class="stat-card">
                <div class="stat-accent"></div>
                <div class="stat-num">{{ number_format($ringkasan['bulan_ini']) }}</div>
                <div class="stat-lbl">Pengunjung Bulan Ini</div>
            </td>
        </tr>
    </table>

    {{-- ═══ HARIAN ═══ --}}
    <div class="section-line">
        <span class="section-title">Kunjungan Harian &mdash; 14 Hari Terakhir</span>
    </div>
    <table class="data-table">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th style="text-align: right;">Jumlah Pengunjung</th>
            </tr>
        </thead>
        <tbody>
            @foreach($harian as $i => $row)
                <tr class="{{ $i % 2 === 0 ? 'row-odd' : 'row-even' }}">
                    <td>{{ $row['label'] }}</td>
                    <td class="td-jumlah">{{ number_format($row['jumlah']) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- ═══ MINGGUAN & BULANAN (dua kolom) ═══ --}}
    <table class="two-col">
        <tr>
            <td class="two-col-cell">
                <div class="section-line">
                    <span class="section-title">Mingguan &mdash; 12 Minggu</span>
                </div>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Periode</th>
                            <th style="text-align: right;">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($mingguan as $i => $row)
                            <tr class="{{ $i % 2 === 0 ? 'row-odd' : 'row-even' }}">
                                <td>{{ $row['label'] }}</td>
                                <td class="td-jumlah">{{ number_format($row['jumlah']) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </td>
            <td class="two-col-cell">
                <div class="section-line">
                    <span class="section-title">Bulanan &mdash; 12 Bulan</span>
                </div>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Bulan</th>
                            <th style="text-align: right;">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bulanan as $i => $row)
                            <tr class="{{ $i % 2 === 0 ? 'row-odd' : 'row-even' }}">
                                <td>{{ $row['label'] }}</td>
                                <td class="td-jumlah">{{ number_format($row['jumlah']) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </td>
        </tr>
    </table>

    {{-- ═══ FOOTER ═══ --}}
    <table class="footer-table">
        <tr>
            <td>
                <strong>SiMPeDa</strong> &mdash; Sistem Manajemen Pengaduan Desa<br>
                Dokumen digenerate otomatis &mdash; bukan merupakan dokumen resmi yang disahkan tanda tangan.
            </td>
            <td class="footer-right">
                Pengunjung dihitung unik per sesi per hari.<br>
                &copy; {{ date('Y') }} SiMPeDa. Hak cipta dilindungi.
            </td>
        </tr>
    </table>

</div>
</body>
</html>
