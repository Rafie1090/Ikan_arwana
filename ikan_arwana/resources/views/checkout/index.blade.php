<x-client-layout>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- HEADER -->
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-slate-900 mb-2">Checkout</h1>
            <p class="text-slate-500">Lengkapi informasi pengiriman Anda</p>
        </div>

        <form action="{{ route('checkout.process') }}" method="POST">
            @csrf
            
            @foreach($cart as $id => $item)
                <input type="hidden" name="selected_items[]" value="{{ $id }}">
            @endforeach
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- LEFT: SHIPPING FORM -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 mb-6">
                        <h3 class="font-bold text-lg text-slate-900 mb-6 pb-4 border-b border-slate-100">
                            <i class="fa-solid fa-truck text-primary mr-2"></i> Informasi Pengiriman
                        </h3>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                                <input type="text" name="name" required 
                                       class="w-full px-4 py-3 rounded-xl border-slate-200 focus:border-primary focus:ring-primary"
                                       placeholder="Masukkan nama lengkap Anda">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">Nomor Telepon <span class="text-red-500">*</span></label>
                                <input type="tel" name="phone" required 
                                       class="w-full px-4 py-3 rounded-xl border-slate-200 focus:border-primary focus:ring-primary"
                                       placeholder="08xxxxxxxxxx">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">Alamat Lengkap <span class="text-red-500">*</span></label>
                                <textarea name="address" rows="4" required 
                                          class="w-full px-4 py-3 rounded-xl border-slate-200 focus:border-primary focus:ring-primary"
                                          placeholder="Jalan, Nomor Rumah, RT/RW, Kelurahan, Kecamatan, Kota, Provinsi, Kode Pos"></textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">Catatan (Opsional)</label>
                                <textarea name="notes" rows="2" 
                                          class="w-full px-4 py-3 rounded-xl border-slate-200 focus:border-primary focus:ring-primary"
                                          placeholder="Contoh: Warna ikan yang diinginkan, waktu pengiriman, dll"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- PAYMENT METHOD -->
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                        <h3 class="font-bold text-lg text-slate-900 mb-6 pb-4 border-b border-slate-100">
                            <i class="fa-solid fa-credit-card text-primary mr-2"></i> Metode Pembayaran
                        </h3>

                        <div class="space-y-3">
                            <label class="flex items-center p-4 border-2 border-slate-200 rounded-xl cursor-pointer hover:border-primary transition">
                                <input type="radio" name="payment_method" value="cod" class="w-5 h-5 text-primary focus:ring-primary" checked>
                                <div class="ml-4 flex-1">
                                    <div class="font-bold text-slate-900">Cash on Delivery (COD)</div>
                                    <div class="text-sm text-slate-500">Bayar saat barang diterima</div>
                                </div>
                                <i class="fa-solid fa-money-bill-wave text-2xl text-emerald-500"></i>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- RIGHT: ORDER SUMMARY -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 sticky top-24">
                        @php
                            $totalItems = collect($cart)->sum('qty');
                            $subtotal = collect($cart)->sum(fn($i) => $i['price'] * $i['qty']);
                            $ongkir = 0;
                            $totalAkhir = $subtotal + $ongkir;
                        @endphp

                        <h3 class="font-bold text-lg text-slate-900 mb-6 pb-4 border-b border-slate-100">Ringkasan Pesanan</h3>

                        <!-- Product List -->
                        <div class="space-y-3 mb-6 max-h-64 overflow-y-auto">
                            @foreach($cart as $item)
                                <div class="flex gap-3 pb-3 border-b border-slate-50">
                                    <img src="{{ $item['image'] }}" 
                                         class="w-16 h-16 rounded-lg object-cover border border-slate-100">
                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-sm font-semibold text-slate-900 truncate">{{ $item['name'] }}</h4>
                                        <p class="text-xs text-slate-500">{{ $item['qty'] }} x Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                                        <p class="text-sm font-bold text-primary mt-1">
                                            Rp {{ number_format($item['price'] * $item['qty'], 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Summary -->
                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between text-sm">
                                <span class="text-slate-500">Subtotal ({{ $totalItems }} item)</span>
                                <span class="font-semibold text-slate-900">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-slate-500">Ongkos Kirim</span>
                                <span class="font-bold text-emerald-600">
                                    {{ $ongkir == 0 ? 'Gratis' : 'Rp ' . number_format($ongkir, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>

                        <div class="pt-4 border-t border-slate-100 mb-6">
                            <div class="flex justify-between items-center">
                                <span class="font-bold text-slate-900">Total Pembayaran</span>
                                <span class="text-2xl font-bold text-primary">
                                    Rp {{ number_format($totalAkhir, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>

                        <button type="submit" 
                                class="block w-full py-3.5 bg-primary text-white text-center font-bold rounded-xl hover:bg-indigo-700 transition shadow-lg shadow-indigo-200 mb-3">
                            <i class="fa-solid fa-check-circle mr-2"></i> Buat Pesanan
                        </button>

                        <a href="{{ route('cart.index') }}" 
                           class="block w-full py-3 bg-slate-100 text-slate-700 text-center font-medium rounded-xl hover:bg-slate-200 transition">
                            <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Keranjang
                        </a>
                    </div>
                </div>

            </div>
        </form>

    </div>

</x-client-layout>
