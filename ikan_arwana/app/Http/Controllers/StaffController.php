<?php

namespace App\Http\Controllers;

use App\Models\Kolam;
use App\Models\MonitoringAir;
use App\Models\Product;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function dashboard(Request $req)
    {
        $daftar_kolam = Kolam::orderBy('nama_kolam')->get();

        // Get total counts
        $totalKolam = $daftar_kolam->count();
        $totalProduk = Product::count();

        if ($daftar_kolam->count() == 0) {
            return view('dashboard.staff')->with([
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

        return view('dashboard.staff', compact(
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

    public function productStock()
    {
        $products = Product::orderBy('name')->get();

        return view('staff.product-stock', compact('products'));
    }

    public function updateStock(Request $request, $id)
    {
        $request->validate([
            'stock' => 'required|integer|min:0',
        ]);

        $product = Product::findOrFail($id);
        $product->stock = $request->stock;
        $product->save();

        return redirect()->route('staff.product.stock')->with('success', 'Stok produk berhasil diperbarui!');
    }
}
