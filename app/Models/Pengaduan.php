<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    protected $fillable = [
        'user_id',
        'nomor_tiket',
        'kategori',
        'nama_pelapor',
        'nomor_hp',
        'rt_rw',
        'urgensi',
        'judul',
        'status',
        'komentar_petugas',
        'deskripsi',
        'foto',
        'latitude',
        'longitude',
        'alamat_koordinat',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tanggapan()
    {
        return $this->hasMany(TanggapanPengaduan::class);
    }

    public function rating()
    {
        return $this->hasOne(RatingPengaduan::class);
    }
}
