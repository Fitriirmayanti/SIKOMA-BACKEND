<?php

namespace App\Http\Controllers\AdminPusat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Galeri;
use Illuminate\Support\Str;

class GaleriController extends Controller
{
    // 🔥 GET GALERI
   public function index(Request $request)
{
    $galeri = Galeri::latest()->get();

    return response()->json([
        'message' => 'Data galeri berhasil diambil',
        'data' => $galeri
    ]);
}

    // 🔥 STORE GALERI
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'keterangan' => 'nullable|string|max:255',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // 🔥 ambil file
        $file = $request->file('gambar');
        $namaFile = Str::slug($request->judul) . '-' . time() . '.' . $file->getClientOriginalExtension();

        // 🔥 pastikan folder ada
        $path = public_path('uploads/galeri');
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $file->move($path, $namaFile);

        $data = Galeri::create([
            'judul' => $request->judul,
            'keterangan' => $request->keterangan,
            'gambar' => $namaFile,
            'keygaleri' => $request->keygaleri ?? 'banner'
        ]);

        // 🔥 kalau API
        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Galeri berhasil ditambahkan',
                'data' => $data
            ]);
        }

        // 🔥 kalau web
        return redirect()->back()->with('success', 'Galeri berhasil ditambahkan.');
    }

    // 🔥 UPDATE
    public function update(Request $request, $id)
    {
        $galeri = Galeri::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'keterangan' => 'nullable|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $galeri->judul = $request->judul;
        $galeri->keterangan = $request->keterangan;

        if ($request->hasFile('gambar')) {
            $path = public_path('uploads/galeri/');

            // hapus lama
            if ($galeri->gambar && file_exists($path . $galeri->gambar)) {
                unlink($path . $galeri->gambar);
            }

            $file = $request->file('gambar');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $file->move($path, $filename);

            $galeri->gambar = $filename;
        }

        $galeri->save();

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Galeri berhasil diupdate',
                'data' => $galeri
            ]);
        }

        return redirect()->back()->with('success', 'Galeri berhasil diperbarui.');
    }

    // 🔥 DELETE
    public function destroy(Request $request, $id)
    {
        $galeri = Galeri::findOrFail($id);

        $path = public_path('uploads/galeri/');
        if ($galeri->gambar && file_exists($path . $galeri->gambar)) {
            unlink($path . $galeri->gambar);
        }

        $galeri->delete();

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Galeri berhasil dihapus'
            ]);
        }

        return redirect()->back()->with('success', 'Galeri berhasil dihapus.');
    }
}