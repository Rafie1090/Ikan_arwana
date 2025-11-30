<?php

namespace App\Http\Controllers\Pemilik;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->get();

        return view('dashboard.pemilik', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        // Upload image
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,   // ⬅ Stok dimasukkan
            'description' => $request->description,
            'image' => $imagePath,
        ]);

        return back()->with('success', 'Produk berhasil ditambahkan!');
    }

    public function list()
    {
        $products = Product::all();

        return view('pemilik.produk.list', compact('products'));
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Hapus gambar jika ada
        if ($product->image && file_exists(storage_path('app/public/'.$product->image))) {
            unlink(storage_path('app/public/'.$product->image));
        }

        $product->delete();

        return redirect()->route('pemilik.product.list')
            ->with('success', 'Produk berhasil dihapus.');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);

        return view('pemilik.produk.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        $product = Product::findOrFail($id);

        // Upload image baru kalau ada
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = $imagePath;
        }

        $product->name = $request->name;
        $product->price = $request->price;
        $product->stock = $request->stock;  // ⬅ stok diupdate
        $product->description = $request->description;
        $product->save();

        return redirect()->route('pemilik.product.list')->with('success', 'Produk berhasil diperbarui!');
    }

    // Halaman staff
    public function staffStockPage()
    {
        $products = Product::all();

        return view('staff.product_stock', compact('products'));
    }

    // Menambah stok dari halaman staff
    public function addStock(Request $request, $id)
    {
        $request->validate([
            'add_stock' => 'required|numeric|min:1',
        ]);

        $product = Product::findOrFail($id);
        $product->stock += $request->add_stock;
        $product->save();

        return back()->with('success', 'Stok berhasil ditambahkan!');
    }
}
