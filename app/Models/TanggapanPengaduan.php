<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TanggapanPengaduan extends Model
{
    protected $table = 'tanggapan_pengaduans';

    protected $fillable = [
        'pengaduan_id',
        'user_id',
        'pengirim',
        'nama_pengirim',
        'isi',
        'is_internal',
    ];

    protected $casts = [
        'is_internal' => 'boolean',
    ];

    public function pengaduan()
    {
        return $this->belongsTo(Pengaduan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
