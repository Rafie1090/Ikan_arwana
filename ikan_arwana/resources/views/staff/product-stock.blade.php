@extends('layouts.staff')

@section('content')

<div class="max-w-6xl mx-auto">

    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-slate-900 mb-2">Kelola Stok Produk</h1>
        <p class="text-slate-500">Update stok produk yang tersedia</p>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl mb-6 flex items-center gap-3">
            <i class="fa-solid fa-circle-check text-emerald-600"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Products Table -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-600 uppercase tracking-wider">Produk</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-600 uppercase tracking-wider">Harga</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-600 uppercase tracking-wider">Stok Saat Ini</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-600 uppercase tracking-wider">Update Stok</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($products as $product)
                        <tr class="hover:bg-slate-50 transition">
                            <!-- Product Info -->
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" 
                                             class="w-16 h-16 rounded-lg object-cover border border-slate-100">
                                    @else
                                        <div class="w-16 h-16 rounded-lg bg-slate-100 flex items-center justify-center">
                                            <i class="fa-solid fa-fish text-slate-400 text-2xl"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <h4 class="font-bold text-slate-900">{{ $product->name }}</h4>
                                        <p class="text-sm text-slate-500 line-clamp-1">{{ Str::limit($product->description, 50) }}</p>
                                    </div>
                                </div>
                            </td>

                            <!-- Price -->
                            <td class="px-6 py-4">
                                <span class="font-bold text-primary">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            </td>

                            <!-- Current Stock -->
                            <td class="px-6 py-4">
                                <span class="px-3 py-1.5 rounded-full text-sm font-bold
                                    {{ $product->stock > 10 ? 'bg-emerald-50 text-emerald-700' : ($product->stock > 0 ? 'bg-amber-50 text-amber-700' : 'bg-red-50 text-red-700') }}">
                                    {{ $product->stock }} unit
                                </span>
                            </td>

                            <!-- Update Stock Form -->
                            <td class="px-6 py-4">
                                <form action="{{ route('staff.product.update-stock', $product->id) }}" method="POST" class="flex items-center gap-2">
                                    @csrf
                                    <input type="number" 
                                           name="stock" 
                                           value="{{ $product->stock }}" 
                                           min="0"
                                           class="w-24 px-3 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-sm"
                                           required>
                                    <button type="submit" 
                                            class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-indigo-700 transition font-medium text-sm flex items-center gap-2">
                                        <i class="fa-solid fa-check"></i> Update
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div class="w-16 h-16 rounded-full bg-slate-100 flex items-center justify-center">
                                        <i class="fa-solid fa-box-open text-slate-400 text-2xl"></i>
                                    </div>
                                    <p class="text-slate-500">Belum ada produk</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection
