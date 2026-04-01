<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LaporanKonservasiController extends Controller
{
    public function index()
    {
        return view('admin.laporan.index');
    }

    public function store(Request $request)
    {
        // validasi backend
        $request->validate([
            'judul' => 'required|string',
            'lokasi' => 'required|string',
            'tanggal' => 'required|date',
        ]);

        // logic simpan ke database (nanti)
        return back()->with('success', 'Laporan berhasil disimpan');
    }
}
