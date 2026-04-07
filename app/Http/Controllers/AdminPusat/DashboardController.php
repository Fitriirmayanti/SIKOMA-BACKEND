<?php

namespace App\Http\Controllers\AdminPusat;

use App\Http\Controllers\Controller;
use App\Models\LaporanKonservasi;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // =========================
        // 🔥 CARD
        // =========================
        $total = LaporanKonservasi::count();

        $disetujui = LaporanKonservasi::where('status', 1)->count();

        $ditolak = LaporanKonservasi::where('status', 2)->count();

        $feedback = 3; // sementara (nanti bisa dari tabel)

        // =========================
        // 🔥 CHART PER BULAN
        // =========================
        $perBulan = LaporanKonservasi::select(
                DB::raw('MONTH(created_at) as bulan'),
                DB::raw('COUNT(*) as total')
            )
            ->whereYear('created_at', date('Y'))
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $bulanMap = [
            1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr',
            5 => 'Mei', 6 => 'Jun', 7 => 'Jul', 8 => 'Agu',
            9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'
        ];

        $chart = $perBulan->map(function ($item) use ($bulanMap) {
            return [
                'bulan' => $bulanMap[$item->bulan],
                'total' => $item->total
            ];
        });

        // =========================
        // 🔥 PER DAERAH
        // =========================
        $perDaerah = LaporanKonservasi::select(
                'daerahLokasi',
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('daerahLokasi')
            ->orderByDesc('total')
            ->get();

        // =========================
        // 🔥 RESPONSE FINAL
        // =========================
        return response()->json([
            'summary' => [
                'total_laporan' => $total,
                'disetujui' => $disetujui,
                'ditolak' => $ditolak,
                'feedback' => $feedback,
            ],
            'chart' => $chart,
            'per_daerah' => $perDaerah
        ]);
    }
}