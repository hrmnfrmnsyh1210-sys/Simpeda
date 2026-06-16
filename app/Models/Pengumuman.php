<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    protected $table = 'pengumumans';

    protected $fillable = [
        'user_id',
        'judul',
        'slug',
        'ringkasan',
        'isi',
        'gambar',
        'status',
        'tanggal_terbit',
        'views',
    ];

    protected $casts = [
        'tanggal_terbit' => 'datetime',
        'views'          => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
