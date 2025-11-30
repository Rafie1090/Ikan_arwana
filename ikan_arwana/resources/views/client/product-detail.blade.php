<x-client-layout>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- BREADCRUMB -->
        <div class="flex items-center gap-2 text-sm text-slate-500 mb-6">
            <a href="{{ route('dashboard') }}" class="hover:text-primary transition">Produk</a>
            <i class="fa-solid fa-chevron-right text-xs"></i>
            <span class="text-slate-800 font-medium">{{ $product->name }}</span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
            
            <!-- PRODUCT IMAGE -->
            <div>
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden p-6">
                    <div class="aspect-square rounded-xl overflow-hidden border border-slate-100 mb-4 relative group">
                        <img src="{{ asset('storage/' . $product->image) }}" 
                             class="w-full h-full object-cover" 
                             id="mainImage">
                        <div class="absolute inset-0 bg-black/5 opacity-0 group-hover:opacity-100 transition pointer-events-none"></div>
                    </div>
                </div>
            </div>

            <!-- PRODUCT INFO -->
            <div>
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                    <span class="inline-block px-3 py-1 bg-primary/10 text-primary text-xs font-bold rounded-full mb-3">
                        PREMIUM
                    </span>
                    
                    <h1 class="text-2xl md:text-3xl font-bold text-slate-900 mb-4">{{ $product->name }}</h1>
                    
                    <div class="flex items-center gap-4 mb-6 pb-6 border-b border-slate-100">
                        <div class="flex items-center gap-1 text-yellow-400">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star-half-stroke"></i>
                        </div>
                        <span class="text-sm text-slate-500">4.9 (1.2k penilaian)</span>
                        <span class="text-sm text-slate-500">|</span>
                        <span class="text-sm text-slate-500">3.5k Terjual</span>
                    </div>

                    <!-- Price Section -->
                    <div class="bg-slate-50 p-5 rounded-xl mb-6">
                        <p class="text-sm text-slate-500 mb-1">Harga</p>
                        <h2 class="text-3xl font-bold text-primary">Rp {{ number_format($product->price, 0, ',', '.') }}</h2>
                    </div>

                    <!-- Stock -->
                    <div class="flex items-center gap-3 mb-6 pb-6 border-b border-slate-100">
                        <span class="text-sm text-slate-500">Stok Tersedia:</span>
                        <span class="px-3 py-1 bg-emerald-50 text-emerald-700 text-sm font-bold rounded-full">
                            {{ $product->stock }} Unit
                        </span>
                    </div>

                    <!-- Form -->
                    @if($product->stock > 0)
                        <form action="{{ route('cart.add', $product->id) }}" method="POST">
                            @csrf
                            
                            <!-- Quantity -->
                            <div class="flex items-center gap-6 mb-6">
                                <span class="text-sm text-slate-600 font-medium w-20">Kuantitas</span>
                                <div class="flex items-center border border-slate-300 rounded-lg overflow-hidden">
                                    <button type="button" onclick="updateQty(-1)" class="px-4 py-2 hover:bg-slate-50 text-slate-600 transition">
                                        <i class="fa-solid fa-minus text-sm"></i>
                                    </button>
                                    <input type="number" name="quantity" id="qty" value="1" min="1" max="{{ $product->stock }}" 
                                           class="w-16 text-center border-none focus:ring-0 p-2 text-slate-900 font-medium" readonly>
                                    <button type="button" onclick="updateQty(1)" class="px-4 py-2 hover:bg-slate-50 text-slate-600 transition">
                                        <i class="fa-solid fa-plus text-sm"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="flex gap-3">
                                <button type="submit" class="flex-1 px-6 py-3.5 bg-primary text-white font-bold rounded-xl hover:bg-indigo-700 transition flex items-center justify-center gap-2 shadow-lg shadow-indigo-200">
                                    <i class="fa-solid fa-cart-plus"></i> Masukkan Keranjang
                                </button>
                            </div>
                        </form>
                    @else
                        <div class="bg-red-50 border border-red-200 rounded-xl p-4 text-center">
                            <p class="text-red-700 font-bold">Stok Habis</p>
                            <p class="text-red-600 text-sm">Produk ini sedang tidak tersedia</p>
                        </div>
                    @endif

                    <!-- Guarantee -->
                    <div class="mt-6 pt-6 border-t border-slate-100 grid grid-cols-2 gap-4 text-sm">
                        <div class="flex items-center gap-2 text-slate-600">
                            <i class="fa-solid fa-shield-halved text-primary"></i>
                            <span>Garansi Ikan Hidup</span>
                        </div>
                        <div class="flex items-center gap-2 text-slate-600">
                            <i class="fa-solid fa-truck-fast text-primary"></i>
                            <span>Pengiriman Cepat</span>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- DESCRIPTION -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 mb-8">
            <h3 class="font-bold text-lg text-slate-800 mb-4 pb-4 border-b border-slate-100">Deskripsi Produk</h3>
            <div class="text-slate-600 leading-relaxed whitespace-pre-line">
                {{ $product->description }}
            </div>
        </div>

        <!-- SPECIFICATIONS -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <h3 class="font-bold text-lg text-slate-800 mb-4 pb-4 border-b border-slate-100">Spesifikasi</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="flex justify-between py-3 border-b border-slate-50">
                    <span class="text-slate-500">Kategori</span>
                    <span class="text-slate-900 font-medium">Arwana</span>
                </div>
                <div class="flex justify-between py-3 border-b border-slate-50">
                    <span class="text-slate-500">Stok</span>
                    <span class="text-slate-900 font-medium">{{ $product->stock }} Unit</span>
                </div>
                <div class="flex justify-between py-3 border-b border-slate-50">
                    <span class="text-slate-500">Kondisi</span>
                    <span class="text-slate-900 font-medium">Baru</span>
                </div>
                <div class="flex justify-between py-3 border-b border-slate-50">
                    <span class="text-slate-500">Berat</span>
                    <span class="text-slate-900 font-medium">500 gram</span>
                </div>
            </div>
        </div>

    </div>

    <script>
        function updateQty(change) {
            const input = document.getElementById('qty');
            let newVal = parseInt(input.value) + change;
            if (newVal >= 1 && newVal <= {{ $product->stock }}) {
                input.value = newVal;
            }
        }
    </script>

</x-client-layout>
