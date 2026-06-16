<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RatingPengaduan extends Model
{
    protected $table = 'rating_pengaduans';

    protected $fillable = [
        'pengaduan_id',
        'nama_pelapor',
        'bintang',
        'ulasan',
    ];

    protected $casts = [
        'bintang' => 'integer',
    ];

    public function pengaduan()
    {
        return $this->belongsTo(Pengaduan::class);
    }
}
