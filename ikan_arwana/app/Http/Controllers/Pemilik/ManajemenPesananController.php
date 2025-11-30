<?php

namespace App\Http\Controllers\Pemilik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ManajemenPesananController extends Controller
{
    public function index()
    {
        $orders = \App\Models\Order::with(['user', 'items.product'])->orderBy('created_at', 'desc')->get();
        return view('pemilik.pesanan.index', compact('orders'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
            'cancellation_note' => 'nullable|string',
        ]);

        $order = \App\Models\Order::findOrFail($id);
        $order->status = $request->status;
        
        if ($request->status == 'cancelled') {
            $order->cancellation_note = $request->cancellation_note;
        }

        $order->save();

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui!');
    }

    public function export()
    {
        // Placeholder for export logic
        return back()->with('success', 'Fitur Export Excel akan segera hadir!');
    }
}
