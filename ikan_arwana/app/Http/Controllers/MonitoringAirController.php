<?php

namespace App\Http\Controllers;

use App\Exports\MonitoringAirExport;
use App\Models\Kolam;
use App\Models\MonitoringAir;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class MonitoringAirController extends Controller
{
    public function index(Request $req)
    {
        // Kolam yang dipilih
        $kolam = $req->kolam ?? 1;

        // Daftar kolam
        $daftar_kolam = Kolam::orderBy('nama_kolam')->get();

        // Data monitoring
        $data = MonitoringAir::where('kolam_id', $kolam)
            ->orderBy('created_at', 'ASC')
            ->get();

        $last = $data->last();

        // Alert otomatis
        $alert = null;
        if ($last) {
            if ($last->suhu < 25 || $last->suhu > 30) {
                $alert = 'Suhu tidak ideal!';
            } elseif ($last->ph < 6.5 || $last->ph > 8.5) {
                $alert = 'pH berada di luar batas aman!';
            } elseif ($last->oksigen < 5) {
                $alert = 'Oksigen terlalu rendah!';
            }
        }

        return view('pemilik.monitoring-air',
            compact('data', 'kolam', 'daftar_kolam', 'alert')
        );
    }

    public function store(Request $req)
    {
        MonitoringAir::create([
            'suhu' => $req->suhu,
            'ph' => $req->ph,
            'oksigen' => $req->oksigen,
            'kolam_id' => $req->kolam_id, // INI BENAR
        ]);

        return redirect()->route('monitoring.air', [
            'kolam' => $req->kolam_id,
        ]);
    }

    public function delete($id)
    {
        $row = MonitoringAir::findOrFail($id);
        $kolam = $row->kolam_id;
        $row->delete();

        return redirect()->route('monitoring.air', [
            'kolam' => $kolam,
        ]);
    }

    public function exportExcel($kolam)
    {
        return Excel::download(new MonitoringAirExport($kolam), 'monitoring-air.xlsx');
    }
}
