<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientOrderController extends Controller
{
    public function index()
    {
        $orders = \App\Models\Order::with('items.product')->where('user_id', Auth::id())->orderBy('created_at', 'desc')->get(); 

        return view('client.orders.index', compact('orders'));
    }
    public function cancel(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|max:255',
        ]);

        $order = \App\Models\Order::where('user_id', Auth::id())->findOrFail($id);

        if ($order->status != 'pending') {
            return back()->with('error', 'Pesanan tidak dapat dibatalkan karena sudah diproses.');
        }

        $order->status = 'cancelled';
        $order->cancellation_note = $request->reason;
        $order->save();

        return back()->with('success', 'Pesanan berhasil dibatalkan.');
    }
}
