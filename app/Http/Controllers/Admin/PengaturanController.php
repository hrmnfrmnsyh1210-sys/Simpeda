<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use App\Models\User;
use App\Models\ActivityLog;

class PengaturanController extends Controller
{
    public function index()
    {
        $stats = [
            'total_pengaduan' => Pengaduan::count(),
            'total_users'     => User::count(),
            'total_logs'      => ActivityLog::count(),
        ];

        return view('content-admin.content-pengaturan', compact('stats'));
    }
}
