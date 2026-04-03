<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LaporanKonservasi;

class LaporanKonservasiController extends Controller
{
    // 🔥 GET DATA LAPORAN
    public function index()
    {
        $data = LaporanKonservasi::latest()->get();

        return response()->json([
            'message' => 'Data laporan berhasil diambil',
            'data' => $data
        ]);
    }

    // 🔥 TAMBAH LAPORAN
    public function store(Request $request)
    {
        // ✅ VALIDASI
        $request->validate([
            'judulLaporan' => 'required|string',
            'daerahLokasi' => 'required|string',
            'tanggalMulai' => 'required|date',
        ]);

        try {
        $data = LaporanKonservasi::create([
            'pengirim' => 1,
            'judulLaporan' => $request->judulLaporan,
            'jenisKegiatan' => 'umum',
            'tanggalMulai' => $request->tanggalMulai,
            'tanggalSelesai' => $request->tanggalMulai,
            'keterangan' => '-',
            'daerahLokasi' => $request->daerahLokasi,
            'kabupaten' => '-',
            'kecamatan' => '-',
            'lokasiKegiatan' => '-',
            'latitude' => 0,
            'longitude' => 0,
            'luasArea' => '0',
            'suratTugas' => '-',        // 🔥 FIX DI SINI
            'fotoSebelum' => '-',       // biar aman
            'fotoSetelah' => '-',       // biar aman
            'status' => 0
        ]);

            return response()->json([
                'message' => 'Laporan berhasil disimpan',
                'data' => $data
            ], 201);

        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Gagal menyimpan laporan',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}