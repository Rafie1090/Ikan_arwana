<?php

namespace App\Http\Controllers\Pemilik;

use App\Http\Controllers\Controller;
use App\Models\JadwalPakan;
use App\Models\Kolam;
use Illuminate\Http\Request;

class ManajemenPakanController extends Controller
{
    public function index(Request $request)
    {
        $kolams = Kolam::all();

        $jadwalPakanQuery = JadwalPakan::query();

        if ($request->kolam_id) {
            $jadwalPakanQuery->where('kolam_id', $request->kolam_id);
        }

        if ($request->tanggal) {
            $jadwalPakanQuery->whereDate('tanggal', $request->tanggal);
        }

        if ($request->pakan) {
            $jadwalPakanQuery->where('jenis_pakan', 'like', '%'.$request->pakan.'%');
        }

        $jadwalPakan = $jadwalPakanQuery->get();

        return view('pemilik.manajemen-pakan', [
            'kolams' => $kolams,
            'jadwalPakan' => $jadwalPakan,
            'kolam_id' => $request->kolam_id,
            'tanggal' => $request->tanggal,
            'pakan' => $request->pakan,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kolam_id' => 'required|exists:kolams,id',
            'waktu' => 'required',
            'sesi' => 'required|string',
            'jumlah' => 'required|numeric',
            'jenis_pakan' => 'required|string',
        ]);

        JadwalPakan::create([
            'kolam_id' => $validated['kolam_id'],
            'waktu' => $validated['waktu'],
            'sesi' => $validated['sesi'],
            'jumlah' => $validated['jumlah'],
            'jenis_pakan' => $validated['jenis_pakan'],
            'tanggal' => now()->toDateString(),  // auto tanggal hari ini
            'status' => 'Aktif',
        ]);

        return redirect()->route('manajemen.pakan.index')
            ->with('success', 'Jadwal pakan berhasil ditambahkan!');
    }
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'kolam_id' => 'required|exists:kolams,id',
            'waktu' => 'required',
            'sesi' => 'required|string',
            'jumlah' => 'required|numeric',
            'jenis_pakan' => 'required|string',
            'status' => 'required|string',
        ]);

        JadwalPakan::findOrFail($id)->update($validated);

        return redirect()->route('manajemen.pakan.index')
            ->with('success', 'Jadwal pakan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        JadwalPakan::findOrFail($id)->delete();

        return redirect()->route('manajemen.pakan.index')
            ->with('success', 'Jadwal pakan berhasil dihapus!');
    }
}
