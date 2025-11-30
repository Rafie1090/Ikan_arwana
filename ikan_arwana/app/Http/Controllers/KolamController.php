<?php

namespace App\Http\Controllers;

use App\Models\Kolam;
use Illuminate\Http\Request;

class KolamController extends Controller
{
    public function index()
    {
        $kolam = Kolam::orderBy('created_at', 'DESC')->get();

        // Statistik
        $total_kolam = Kolam::count();
        $kolam_aktif = Kolam::where('status', 'aktif')->count();

        return view('pemilik.kolam.index', compact(
            'kolam', 'total_kolam', 'kolam_aktif'
        ));
    }

    public function store(Request $req)
    {
        Kolam::create([
            'nama_kolam' => $req->nama_kolam,
            'lokasi' => $req->lokasi,
            'deskripsi' => $req->deskripsi,
            'status' => $req->status,
        ]);

        return back()->with('success', 'Kolam berhasil ditambahkan');
    }

    public function update(Request $req, $id)
    {
        Kolam::findOrFail($id)->update([
            'nama_kolam' => $req->nama_kolam,
            'lokasi' => $req->lokasi,
            'deskripsi' => $req->deskripsi,
            'status' => $req->status,
        ]);

        return back()->with('success', 'Kolam berhasil diperbarui');
    }

    public function delete($id)
    {
        Kolam::findOrFail($id)->delete();

        return back()->with('success', 'Kolam berhasil dihapus');
    }
}
