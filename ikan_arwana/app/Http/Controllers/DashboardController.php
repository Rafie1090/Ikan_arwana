<?php

namespace App\Http\Controllers;

use App\Models\MonitoringAir;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function client()
    {
        return view('dashboard.client');
    }

    public function staff()
    {
        return view('dashboard.staff');
    }

    public function pemilik(Request $req)
    {
        $daftar_kolam = \App\Models\Kolam::orderBy('nama_kolam')->get();

        // Get total counts
        $totalKolam = $daftar_kolam->count();
        $totalProduk = \App\Models\Product::count();

        if ($daftar_kolam->count() == 0) {
            return view('dashboard.pemilik')->with([
                'kolam' => null,
                'last' => null,
                'status' => 'Belum Ada Kolam',
                'status_color' => 'secondary',
                'miniData' => collect(),
                'chartData' => collect(),
                'daftar_kolam' => $daftar_kolam,
                'totalKolam' => 0,
                'totalProduk' => $totalProduk,
                'jadwalHariIni' => collect(),
            ]);
        }

        $kolam = $req->kolam ?? $daftar_kolam->first()->id;

        $last = MonitoringAir::where('kolam_id', $kolam)
            ->orderBy('created_at', 'DESC')
            ->first();

        $status = 'Belum Ada Data';
        $status_color = 'secondary';

        if ($last) {
            if ($last->suhu < 25 || $last->suhu > 30) {
                $status = 'Suhu Tidak Ideal';
                $status_color = 'danger';
            } elseif ($last->ph < 6.5 || $last->ph > 8.5) {
                $status = 'pH Tidak Ideal';
                $status_color = 'warning';
            } elseif ($last->oksigen < 5) {
                $status = 'Oksigen Rendah';
                $status_color = 'danger';
            } else {
                $status = 'Normal';
                $status_color = 'success';
            }
        }

        // Mini chart data (last 10 records)
        $miniData = MonitoringAir::where('kolam_id', $kolam)
            ->orderBy('created_at', 'DESC')
            ->take(10)
            ->get()
            ->reverse();

        // Extended chart data (last 30 days for detailed charts)
        $chartData = MonitoringAir::where('kolam_id', $kolam)
            ->where('created_at', '>=', now()->subDays(30))
            ->orderBy('created_at', 'ASC')
            ->get();

        // Get today's feed schedules for selected kolam
        $jadwalHariIni = \App\Models\JadwalPakan::where('kolam_id', $kolam)
            ->whereDate('tanggal', today())
            ->orderBy('waktu', 'ASC')
            ->get();

        return view('dashboard.pemilik', compact(
            'kolam',
            'last',
            'status',
            'status_color',
            'miniData',
            'chartData',
            'daftar_kolam',
            'totalKolam',
            'totalProduk',
            'jadwalHariIni'
        ));
    }
}
