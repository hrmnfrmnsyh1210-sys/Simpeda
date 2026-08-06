<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class LogController extends Controller
{
    private function filteredQuery(Request $request)
    {
        $query = ActivityLog::with('user')->latest();

        if ($request->filled('action')) {
            $query->where('action', 'like', '%' . $request->action . '%');
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('dari_tanggal')) {
            $query->whereDate('created_at', '>=', $request->dari_tanggal);
        }

        if ($request->filled('sampai_tanggal')) {
            $query->whereDate('created_at', '<=', $request->sampai_tanggal);
        }

        return $query;
    }

    public function index(Request $request)
    {
        $logs = $this->filteredQuery($request)->paginate(20)->withQueryString();

        return view('content-admin.content-log', compact('logs'));
    }

    public function exportPdf(Request $request)
    {
        $logs = $this->filteredQuery($request)->get();

        $pdf = Pdf::loadView('content-admin.pdf-log', [
            'logs'           => $logs,
            'filterAction'   => $request->action,
            'filterDari'     => $request->dari_tanggal,
            'filterSampai'   => $request->sampai_tanggal,
        ])->setPaper('a4', 'landscape');

        $filename = 'laporan-kunjungan-' . now()->format('Ymd-His') . '.pdf';

        return $pdf->download($filename);
    }
}
