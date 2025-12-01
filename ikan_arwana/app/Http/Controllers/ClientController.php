<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function dashboard(Request $request)
    {
        $search = $request->search;
        $sort = $request->sort;

        // MULAI QUERY
        $products = Product::query();

        // FILTER SEARCH
        if ($search) {
            $products->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // FILTER KATEGORI
        if ($request->has('category') && in_array($request->category, ['peliharaan', 'produk'])) {
            $products->where('category', $request->category);
        }

        // FILTER TERBARU / TERMURAH / TERMAHAL
        if ($sort == 'terbaru') {
            $products->orderBy('created_at', 'desc');
        } elseif ($sort == 'harga-asc') {
            $products->orderBy('price', 'asc'); // termurah
        } elseif ($sort == 'harga-desc') {
            $products->orderBy('price', 'desc'); // termahal
        }

        return view('dashboard.client', [
            'products' => $products->get(),
            'sort' => $sort,
            'category' => $request->category,
        ]);
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);

        return view('client.product-detail', compact('product'));
    }
}
