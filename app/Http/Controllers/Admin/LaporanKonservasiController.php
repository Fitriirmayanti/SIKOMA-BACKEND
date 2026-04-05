<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LaporanKonservasi;
use Illuminate\Support\Facades\Validator;

class LaporanKonservasiController extends Controller
{
    public function index()
    {
        $data = LaporanKonservasi::latest()->get();

        return response()->json([
            'message' => 'Data laporan berhasil diambil',
            'data' => $data
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judulLaporan' => 'required|string',
            'daerahLokasi' => 'required|string',
            'tanggalMulai' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

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
                'luasArea' => 0,
                'suratTugas' => '-',
                'fotoSebelum' => '-',
                'fotoSetelah' => '-',
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
        // 🔥 UPDATE LAPORAN
    public function update(Request $request, $id)
    {
        $data = LaporanKonservasi::find($id);

        // ❌ kalau tidak ada
        if (!$data) {
            return response()->json([
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        // ✅ update data
        $data->update([
            'judulLaporan' => $request->judulLaporan ?? $data->judulLaporan,
            'daerahLokasi' => $request->daerahLokasi ?? $data->daerahLokasi,
            'tanggalMulai' => $request->tanggalMulai ?? $data->tanggalMulai,
        ]);

        return response()->json([
            'message' => 'Laporan berhasil diupdate',
            'data' => $data
        ]);
    }
    // 🔥 DELETE LAPORAN
    public function destroy($id)
    {
        $data = LaporanKonservasi::find($id);

        // ❌ kalau tidak ada
        if (!$data) {
            return response()->json([
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        // ✅ hapus data
        $data->delete();

        return response()->json([
            'message' => 'Laporan berhasil dihapus'
        ]);
    }
    
}