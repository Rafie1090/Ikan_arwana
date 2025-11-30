<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $cart = session('cart', []);
        $selectedItems = $request->input('selected_items', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong');
        }

        // Filter cart if selected_items are provided
        if (!empty($selectedItems)) {
            $cart = array_intersect_key($cart, array_flip($selectedItems));
        }

        if (empty($cart)) {
             return redirect()->route('cart.index')->with('error', 'Tidak ada produk yang dipilih');
        }

        return view('checkout.index', compact('cart'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'payment_method' => 'required|in:cod,transfer',
            'selected_items' => 'required|array|min:1',
        ]);

        $cart = session('cart', []);
        $selectedItems = $request->input('selected_items', []);
        
        // Filter cart based on selected items
        $itemsToProcess = array_intersect_key($cart, array_flip($selectedItems));

        if (empty($itemsToProcess)) {
            return redirect()->route('cart.index')->with('error', 'Tidak ada produk yang dipilih untuk diproses');
        }

        // Create Order for EACH item
        foreach ($itemsToProcess as $id => $details) {
            $itemSubtotal = $details['price'] * $details['qty'];
            $itemOngkir = 0; // Ongkir per item (currently 0)
            $itemTotal = $itemSubtotal + $itemOngkir;

            $order = \App\Models\Order::create([
                'user_id' => auth()->id(),
                'order_number' => 'ORD-' . strtoupper(uniqid()),
                'customer_name' => $request->name,
                'customer_phone' => $request->phone,
                'customer_address' => $request->address,
                'notes' => $request->notes,
                'subtotal' => $itemSubtotal,
                'shipping_cost' => $itemOngkir,
                'total' => $itemTotal,
                'payment_method' => $request->payment_method,
                'status' => 'pending',
            ]);

            \App\Models\OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $id,
                'product_name' => $details['name'],
                'price' => $details['price'],
                'quantity' => $details['qty'],
                'subtotal' => $itemSubtotal,
            ]);
            
            // Remove processed item from cart
            unset($cart[$id]);
        }

        // Update session cart with remaining items
        session()->put('cart', $cart);

        return redirect()->route('client.orders.index')->with('success', 'Pesanan berhasil dibuat! Silakan cek status masing-masing item.');
    }
}
