<?php

namespace App\Http\Controllers\Beranda;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TentangController extends Controller
{
    //
    public function index()
    {
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

        return view('content-app.content-about', compact('faqs'));
    }
}
