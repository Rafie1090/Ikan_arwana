<x-client-layout>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- HEADER -->
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-slate-900 mb-2">Keranjang Belanja</h1>
            <p class="text-slate-500">Kelola produk yang akan Anda beli</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- LEFT: CART ITEMS -->
            <div class="lg:col-span-2 space-y-4">
                @forelse($cart as $item)
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 hover:shadow-md transition">
                        <div class="flex gap-4">
                            
                            <!-- Checkbox -->
                            <div class="flex-shrink-0 flex items-center">
                                <input type="checkbox" name="selected[]" value="{{ $item['id'] }}" 
                                       class="cart-item-checkbox w-5 h-5 text-primary border-slate-300 rounded focus:ring-primary"
                                       data-price="{{ $item['price'] }}"
                                       data-qty="{{ $item['qty'] }}">
                            </div>

                            <!-- Product Image -->
                            <div class="flex-shrink-0">
                                <img src="{{ asset('storage/' . $item['image']) }}" 
                                     class="w-24 h-24 md:w-32 md:h-32 rounded-xl object-cover border border-slate-100">
                            </div>

                            <!-- Product Info -->
                            <div class="flex-1 min-w-0">
                                <h3 class="text-lg font-bold text-slate-900 mb-1 truncate">{{ $item['name'] }}</h3>
                                <p class="text-sm text-slate-500 mb-3">{{ $item['category'] ?? 'Produk' }}</p>
                                
                                <div class="flex items-center gap-2 mb-3">
                                    <span class="text-xs text-slate-400">Stok:</span>
                                    <span class="px-2 py-0.5 bg-emerald-50 text-emerald-700 text-xs font-bold rounded">
                                        {{ $item['stock'] ?? '-' }}
                                    </span>
                                </div>

                                <div class="text-2xl font-bold text-primary mb-4">
                                    Rp {{ number_format($item['price'], 0, ',', '.') }}
                                </div>

                                <!-- Quantity Control -->
                                <form action="{{ route('cart.update', $item['id']) }}" method="POST" class="flex items-center gap-3">
                                    @csrf
                                    <span class="text-sm text-slate-600 font-medium">Jumlah:</span>
                                    <div class="flex items-center border border-slate-300 rounded-lg overflow-hidden">
                                        <button name="qty" value="{{ $item['qty'] - 1 }}" 
                                                {{ $item['qty'] <= 1 ? 'disabled' : '' }}
                                                class="px-4 py-2 hover:bg-slate-50 text-slate-600 transition disabled:opacity-50 disabled:cursor-not-allowed">
                                            <i class="fa-solid fa-minus text-sm"></i>
                                        </button>
                                        <span class="px-6 py-2 font-bold text-slate-900 bg-slate-50">{{ $item['qty'] }}</span>
                                        <button name="qty" value="{{ $item['qty'] + 1 }}" 
                                                {{ isset($item['stock']) && $item['qty'] >= $item['stock'] ? 'disabled' : '' }}
                                                class="px-4 py-2 hover:bg-slate-50 text-slate-600 transition disabled:opacity-50 disabled:cursor-not-allowed">
                                            <i class="fa-solid fa-plus text-sm"></i>
                                        </button>
                                    </div>
                                </form>

                                <!-- Subtotal -->
                                <div class="mt-4 pt-4 border-t border-slate-100 flex justify-between items-center">
                                    <span class="text-sm text-slate-500">Subtotal:</span>
                                    <span class="text-lg font-bold text-primary">
                                        Rp {{ number_format($item['price'] * $item['qty'], 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>

                            <!-- Delete Button -->
                            <div class="flex-shrink-0">
                                <form action="{{ route('cart.remove', $item['id']) }}" method="POST">
                                    @csrf
                                    <button class="w-10 h-10 rounded-full hover:bg-red-50 text-red-500 transition flex items-center justify-center" 
                                            onclick="return confirm('Hapus produk ini dari keranjang?')">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>

                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-12 text-center">
                        <div class="w-24 h-24 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300 text-4xl">
                            <i class="fa-solid fa-cart-shopping"></i>
                        </div>
                        <h3 class="text-slate-900 font-bold text-lg mb-2">Keranjang Kosong</h3>
                        <p class="text-slate-500 mb-6">Belum ada produk di keranjang Anda</p>
                        <a href="{{ route('dashboard') }}" class="inline-block px-6 py-3 bg-primary text-white rounded-xl hover:bg-indigo-700 transition font-medium">
                            <i class="fa-solid fa-arrow-left mr-2"></i> Mulai Belanja
                        </a>
                    </div>
                @endforelse
            </div>

            <!-- RIGHT: ORDER SUMMARY -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 sticky top-24">
                    <h3 class="font-bold text-lg text-slate-900 mb-6 pb-4 border-b border-slate-100">Ringkasan Pesanan</h3>

                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-500">Subtotal (<span id="total-items">0</span> item)</span>
                            <span class="font-semibold text-slate-900" id="subtotal-display">Rp 0</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-500">Ongkos Kirim</span>
                            <span class="font-bold text-emerald-600">Gratis</span>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-100 mb-6">
                        <div class="flex justify-between items-center">
                            <span class="font-bold text-slate-900">Total</span>
                            <span class="text-2xl font-bold text-primary" id="total-display">
                                Rp 0
                            </span>
                        </div>
                    </div>

                    @if(count($cart) > 0)
                        <form action="{{ route('checkout.index') }}" method="GET" id="checkout-form">
                            <button type="submit" id="checkout-btn" disabled
                               class="block w-full py-3.5 bg-primary text-white text-center font-bold rounded-xl hover:bg-indigo-700 transition shadow-lg shadow-indigo-200 mb-3 disabled:opacity-50 disabled:cursor-not-allowed">
                                <i class="fa-solid fa-credit-card mr-2"></i> Checkout
                            </button>
                        </form>
                    @endif

                    <a href="{{ route('dashboard') }}" 
                       class="block w-full py-3 bg-slate-100 text-slate-700 text-center font-medium rounded-xl hover:bg-slate-200 transition">
                        <i class="fa-solid fa-arrow-left mr-2"></i> Lanjut Belanja
                    </a>
                </div>
            </div>

        </div>

    </div>

    <!-- Selective Checkout Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('.cart-item-checkbox');
            const totalItemsEl = document.getElementById('total-items');
            const subtotalEl = document.getElementById('subtotal-display');
            const totalEl = document.getElementById('total-display');
            const checkoutBtn = document.getElementById('checkout-btn');
            const checkoutForm = document.getElementById('checkout-form');

            function formatRupiah(number) {
                return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number);
            }

            function updateSummary() {
                let totalItems = 0;
                let subtotal = 0;
                let hasSelection = false;

                // Clear existing hidden inputs
                const existingInputs = checkoutForm.querySelectorAll('input[name="selected_items[]"]');
                existingInputs.forEach(input => input.remove());

                checkboxes.forEach(checkbox => {
                    if (checkbox.checked) {
                        hasSelection = true;
                        const price = parseFloat(checkbox.dataset.price);
                        const qty = parseInt(checkbox.dataset.qty);
                        
                        totalItems += qty;
                        subtotal += (price * qty);

                        // Add hidden input to form
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'selected_items[]';
                        input.value = checkbox.value;
                        checkoutForm.appendChild(input);
                    }
                });

                totalItemsEl.textContent = totalItems;
                subtotalEl.textContent = formatRupiah(subtotal);
                totalEl.textContent = formatRupiah(subtotal); // Ongkir is 0

                if (hasSelection) {
                    checkoutBtn.removeAttribute('disabled');
                } else {
                    checkoutBtn.setAttribute('disabled', 'disabled');
                }
            }

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateSummary);
            });

            // Initial calculation
            updateSummary();
        });
    </script>
            </div>

        </div>

    </div>

    <!-- FIX BACK BUTTON -->
    <script>
        history.replaceState(null, '', location.href);
    </script>

</x-client-layout>
