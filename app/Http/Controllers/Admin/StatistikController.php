<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageVisit;
use Carbon\CarbonImmutable;

class StatistikController extends Controller
{
    public function index()
    {
        // Ambil rekap kunjungan harian (dihitung di level DB, kolom visited_date polos)
        // untuk 180 hari terakhir, lalu disusun ulang di PHP jadi bucket harian/mingguan/bulanan
        // agar tidak bergantung pada dialek SQL tertentu.
        $mulai = today()->subDays(179);

        $harianMentah = PageVisit::selectRaw('visited_date, count(*) as jumlah')
            ->where('visited_date', '>=', $mulai)
            ->groupBy('visited_date')
            ->pluck('jumlah', 'visited_date');

        // ── Bucket Harian: 14 hari terakhir ──
        $harian = collect(range(13, 0))->map(function ($i) use ($harianMentah) {
            $tanggal = today()->subDays($i);
            return [
                'label'  => $tanggal->translatedFormat('d M'),
                'jumlah' => $harianMentah[$tanggal->toDateString()] ?? 0,
            ];
        });

        // ── Bucket Mingguan: 12 minggu terakhir ──
        $mingguan = collect();
        for ($i = 11; $i >= 0; $i--) {
            $awalMinggu = CarbonImmutable::now()->subWeeks($i)->startOfWeek();
            $akhirMinggu = $awalMinggu->endOfWeek();
            $jumlah = 0;
            foreach ($harianMentah as $tanggal => $j) {
                $t = CarbonImmutable::parse($tanggal);
                if ($t->betweenIncluded($awalMinggu, $akhirMinggu)) {
                    $jumlah += $j;
                }
            }
            $mingguan->push([
                'label'  => $awalMinggu->format('d M') . ' - ' . $akhirMinggu->format('d M'),
                'jumlah' => $jumlah,
            ]);
        }

        // ── Bucket Bulanan: 12 bulan terakhir ──
        $bulanan = collect();
        for ($i = 11; $i >= 0; $i--) {
            $bulan = CarbonImmutable::now()->subMonths($i);
            $jumlah = 0;
            foreach ($harianMentah as $tanggal => $j) {
                if (CarbonImmutable::parse($tanggal)->isSameMonth($bulan)) {
                    $jumlah += $j;
                }
            }
            $bulanan->push([
                'label'  => $bulan->translatedFormat('M Y'),
                'jumlah' => $jumlah,
            ]);
        }

        $ringkasan = [
            'hari_ini'     => $harianMentah[today()->toDateString()] ?? 0,
            'minggu_ini'   => $mingguan->last()['jumlah'] ?? 0,
            'bulan_ini'    => $bulanan->last()['jumlah'] ?? 0,
        ];

        return view('content-admin.content-statistik-pengunjung', compact('harian', 'mingguan', 'bulanan', 'ringkasan'));
    }
}
