<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageVisit extends Model
{
    public $timestamps = false;

    protected $fillable = ['session_id', 'user_id', 'ip_address', 'visited_date'];

    protected $casts = [
        'visited_date' => 'date',
        'created_at'   => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
