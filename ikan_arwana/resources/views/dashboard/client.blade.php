<x-client-layout>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- SEARCH BAR -->
        <div class="mb-8">
            <form method="GET" action="{{ route('dashboard') }}" class="max-w-2xl mx-auto">
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" 
                           class="w-full px-6 py-4 rounded-2xl border border-slate-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none text-slate-800 placeholder-slate-400 shadow-sm"
                           placeholder="Cari produk arwana, pakan, atau perlengkapan...">
                    <button class="absolute right-2 top-1/2 -translate-y-1/2 px-6 py-2.5 bg-primary text-white rounded-xl hover:bg-indigo-700 transition font-medium">
                        <i class="fa-solid fa-magnifying-glass mr-2"></i> Cari
                    </button>
                </div>
            </form>
        </div>

        <!-- FILTER BAR -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4 mb-8 flex flex-wrap items-center gap-4">
            <span class="text-sm font-bold text-slate-700">Kategori:</span>
            <a href="{{ route('dashboard') }}" class="px-4 py-2 rounded-full text-sm font-medium transition {{ !request('category') ? 'bg-primary text-white shadow-md shadow-indigo-200' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                Semua
            </a>
            <a href="{{ route('dashboard', ['category' => 'peliharaan']) }}" class="px-4 py-2 rounded-full text-sm font-medium transition {{ request('category') == 'peliharaan' ? 'bg-primary text-white shadow-md shadow-indigo-200' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                Peliharaan
            </a>
            <a href="{{ route('dashboard', ['category' => 'produk']) }}" class="px-4 py-2 rounded-full text-sm font-medium transition {{ request('category') == 'produk' ? 'bg-primary text-white shadow-md shadow-indigo-200' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                Produk
            </a>

            <div class="h-6 w-px bg-slate-200 mx-2"></div>

            <span class="text-sm font-bold text-slate-700">Urutkan:</span>
            <a href="?sort=terkait" class="px-4 py-2 rounded-full text-sm font-medium transition {{ request('sort') == 'terkait' || !request('sort') ? 'bg-primary text-white shadow-md shadow-indigo-200' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                Terkait
            </a>
            <a href="?sort=terbaru" class="px-4 py-2 rounded-full text-sm font-medium transition {{ request('sort') == 'terbaru' ? 'bg-primary text-white shadow-md shadow-indigo-200' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                Terbaru
            </a>
            <a href="?sort=terlaris" class="px-4 py-2 rounded-full text-sm font-medium transition {{ request('sort') == 'terlaris' ? 'bg-primary text-white shadow-md shadow-indigo-200' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                Terlaris
            </a>
            
            <div class="ml-auto">
                <select onchange="window.location.href='?sort='+this.value" class="bg-slate-50 border-slate-200 text-sm rounded-xl focus:ring-primary focus:border-primary py-2 px-4">
                    <option value="">Harga</option>
                    <option value="harga-asc" {{ request('sort') == 'harga-asc' ? 'selected' : '' }}>Termurah</option>
                    <option value="harga-desc" {{ request('sort') == 'harga-desc' ? 'selected' : '' }}>Termahal</option>
                </select>
            </div>
        </div>

        <!-- ADVERTISEMENT BANNERS -->
        <div class="mb-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Banner 1 (Large - 2 columns) -->
                <div class="md:col-span-2 bg-gradient-to-r from-orange-400 to-pink-500 rounded-2xl overflow-hidden h-48 flex items-center justify-center relative group cursor-pointer hover:shadow-xl transition">
                    <div class="absolute inset-0 bg-black/10 group-hover:bg-black/0 transition"></div>
                    <div class="relative z-10 text-center text-white p-6">
                        <p class="text-sm font-medium mb-2">PROMO SPESIAL</p>
                        <h3 class="text-3xl font-bold mb-2">Diskon 15%</h3>
                        <p class="text-sm opacity-90">Untuk produk pilihan</p>
                    </div>
                </div>

                <!-- Banner 2 (Small) -->
                <div class="bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl overflow-hidden h-48 flex items-center justify-center relative group cursor-pointer hover:shadow-xl transition">
                    <div class="absolute inset-0 bg-black/10 group-hover:bg-black/0 transition"></div>
                    <div class="relative z-10 text-center text-white p-6">
                        <p class="text-sm font-medium mb-2">GRATIS ONGKIR</p>
                        <h3 class="text-2xl font-bold">100% ORI</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- PRODUCT GRID -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse ($products as $product)
                <div class="group bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition duration-300">
                    <!-- Image -->
                    <div class="relative pt-[100%] overflow-hidden bg-slate-100">
                        <img src="{{ $product->image }}" 
                             class="absolute inset-0 w-full h-full object-cover transition duration-500 group-hover:scale-110">
                        
                        <!-- Badge -->
                        <div class="absolute top-3 left-3">
                            <span class="bg-primary text-white text-xs font-bold px-2 py-1 rounded-lg shadow-lg capitalize">
                                {{ $product->category }}
                            </span>
                        </div>

                        <!-- Quick Actions -->
                        <div class="absolute bottom-3 right-3 flex gap-2 opacity-0 group-hover:opacity-100 transition duration-300">
                            <a href="{{ route('product.detail', $product->id) }}" 
                               class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-slate-700 hover:text-primary hover:scale-110 transition shadow-lg" 
                               title="Lihat Detail">
                                <i class="fa-regular fa-eye"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="p-4">
                        <h3 class="text-sm font-semibold text-slate-800 line-clamp-2 mb-2 h-10 leading-snug group-hover:text-primary transition">
                            {{ $product->name }}
                        </h3>
                        
                        <p class="text-xs text-slate-500 mb-3 line-clamp-2">
                            {{ Str::limit($product->description, 50) }}
                        </p>

                        <div class="flex items-end justify-between mb-3">
                            <div>
                                <div class="text-lg font-bold text-primary">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                            </div>
                        </div>

                        <form action="{{ route('cart.add', $product->id) }}" method="POST">
                            @csrf
                            <button class="w-full py-2.5 bg-primary text-white font-medium rounded-xl hover:bg-indigo-700 transition flex items-center justify-center gap-2 shadow-md shadow-indigo-200">
                                <i class="fa-solid fa-cart-plus"></i> Tambah
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-16 text-center">
                    <div class="w-24 h-24 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300 text-4xl">
                        <i class="fa-solid fa-box-open"></i>
                    </div>
                    <h3 class="text-slate-900 font-bold text-lg mb-2">Produk Tidak Ditemukan</h3>
                    <p class="text-slate-500 mb-4">Coba kata kunci lain atau reset filter.</p>
                    <a href="{{ route('dashboard') }}" class="inline-block px-6 py-2.5 bg-primary text-white rounded-xl hover:bg-indigo-700 transition font-medium">
                        Lihat Semua Produk
                    </a>
                </div>
            @endforelse
        </div>

    </div>

</x-client-layout>
