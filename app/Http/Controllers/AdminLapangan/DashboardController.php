<?php

namespace App\Http\Controllers\AdminLapangan;

use App\Http\Controllers\Controller;
use App\Models\LaporanKonservasi;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 🔥 TOTAL LAPORAN
        $total = LaporanKonservasi::count();

        // 🔥 DISETUJUI
        $laporanDisetujui = LaporanKonservasi::where('status', 1)->count();

        // 🔥 DITOLAK
        $laporanDitolak = LaporanKonservasi::where('status', 2)->count();

        // 🔥 PER DAERAH
        $laporanPerDaerah = LaporanKonservasi::select('daerahLokasi', DB::raw('COUNT(*) as total'))
            ->groupBy('daerahLokasi')
            ->get();

        return response()->json([
            'total_laporan' => $total,
            'disetujui' => $laporanDisetujui,
            'ditolak' => $laporanDitolak,
            'per_daerah' => $laporanPerDaerah
        ]);
    }
}