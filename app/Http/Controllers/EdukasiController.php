<?php

namespace App\Http\Controllers;

use App\Models\Edukasi;

class EdukasiController extends Controller
{
    public function index()
    {
        $data = Edukasi::latest()->get();

        return response()->json([
            'message' => 'Data edukasi berhasil diambil',
            'data' => $data
        ]);
    }
}