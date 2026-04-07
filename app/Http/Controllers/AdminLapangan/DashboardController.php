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

        // 🔥 DATA PER BULAN (untuk chart)
        $chart = LaporanKonservasi::select(
                DB::raw('MONTH(tanggalMulai) as bulan'),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        // 🔥 FORMAT BULAN (BIAR BAGUS DI FRONTEND)
        $bulanMap = [
            1 => 'Jan', 2 => 'Feb', 3 => 'Mar',
            4 => 'Apr', 5 => 'Mei', 6 => 'Jun',
            7 => 'Jul', 8 => 'Agu', 9 => 'Sep',
            10 => 'Okt', 11 => 'Nov', 12 => 'Des'
        ];

        $chartFormatted = $chart->map(function ($item) use ($bulanMap) {
            return [
                'bulan' => $bulanMap[$item->bulan] ?? 'Unknown',
                'total' => $item->total
            ];
        });

        return response()->json([
            'total_laporan' => $total,
            'chart' => $chartFormatted
        ]);
    }
}