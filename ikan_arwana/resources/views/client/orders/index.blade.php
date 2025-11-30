<x-client-layout>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-slate-900 mb-2">Pesanan Saya</h1>
        <p class="text-slate-500">Pantau status pesanan Anda</p>
    </div>

    <!-- Alerts -->
    @if(session('success'))
    <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl flex items-center gap-3 animate-fade-in-down">
        <i class="fa-solid fa-circle-check text-xl"></i>
        <div>
            <p class="font-bold">Berhasil!</p>
            <p class="text-sm">{{ session('success') }}</p>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl flex items-center gap-3 animate-fade-in-down">
        <i class="fa-solid fa-circle-exclamation text-xl"></i>
        <div>
            <p class="font-bold">Gagal!</p>
            <p class="text-sm">{{ session('error') }}</p>
        </div>
    </div>
    @endif

    <!-- Orders List -->
    <div class="space-y-4">
        @forelse($orders as $order)
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="p-6">
                <div class="flex flex-col md:flex-row justify-between items-start mb-4 gap-4">
                    <div>
                        <h3 class="font-bold text-slate-900">Order #{{ $order->order_number }}</h3>
                        <p class="text-sm text-slate-500">{{ $order->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    <span class="px-3 py-1 rounded-full text-xs font-bold 
                        {{ $order->status == 'pending' ? 'bg-amber-100 text-amber-600' : '' }}
                        {{ $order->status == 'processing' ? 'bg-blue-100 text-blue-600' : '' }}
                        {{ $order->status == 'shipped' ? 'bg-indigo-100 text-indigo-600' : '' }}
                        {{ $order->status == 'delivered' ? 'bg-emerald-100 text-emerald-600' : '' }}
                        {{ $order->status == 'cancelled' ? 'bg-red-100 text-red-600' : '' }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>

                <!-- Product List with Images -->
                <div class="space-y-3 mb-4">
                    @foreach($order->items as $item)
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 rounded-lg bg-slate-50 border border-slate-200 overflow-hidden flex-shrink-0">
                            @if($item->product && $item->product->image)
                                <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product_name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-300">
                                    <i class="fa-solid fa-image"></i>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1">
                            <h4 class="font-medium text-slate-900 text-sm">{{ $item->product_name }}</h4>
                            <p class="text-xs text-slate-500">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                        </div>
                        <div class="text-right">
                            <p class="font-medium text-slate-900 text-sm">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Cancellation Note -->
                @if($order->status == 'cancelled' && $order->cancellation_note)
                <div class="mb-4 p-4 bg-red-50 rounded-xl border border-red-100">
                    <h5 class="text-sm font-bold text-red-700 mb-1">Alasan Pembatalan:</h5>
                    <p class="text-sm text-red-600">{{ $order->cancellation_note }}</p>
                </div>
                @endif

                <div class="border-t border-slate-100 pt-4">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm text-slate-500">Total Pembayaran</p>
                            <p class="text-lg font-bold text-primary">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                        </div>
                        
                        @if($order->status == 'pending')
                        <button onclick="openCancelModal({{ $order->id }}, '{{ $order->order_number }}')" 
                                class="px-4 py-2 bg-red-50 text-red-600 rounded-xl font-medium hover:bg-red-100 transition text-sm">
                            <i class="fa-solid fa-ban mr-2"></i> Batalkan Pesanan
                        </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-12 text-center">
            <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300 text-2xl">
                <i class="fa-solid fa-clipboard-list"></i>
            </div>
            <h3 class="text-slate-900 font-medium mb-1">Belum ada pesanan</h3>
            <p class="text-slate-500 text-sm mb-4">Anda belum memiliki pesanan apapun.</p>
            <a href="{{ route('dashboard') }}" class="inline-block px-6 py-2.5 bg-primary text-white rounded-xl font-medium hover:bg-indigo-700 transition">
                <i class="fa-solid fa-shopping-bag mr-2"></i> Mulai Belanja
            </a>
        </div>
        @endforelse
    </div>

</div>

<!-- MODAL CANCEL -->
<div id="cancelModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="document.getElementById('cancelModal').classList.add('hidden')"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form id="cancelForm" method="POST" class="p-6">
                @csrf
                @method('PUT')
                <div class="flex justify-between items-center mb-5">
                    <h3 class="text-lg font-bold text-slate-900">Batalkan Pesanan <span id="cancelOrderNumber"></span></h3>
                    <button type="button" onclick="document.getElementById('cancelModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">
                        <i class="fa-solid fa-xmark text-xl"></i>
                    </button>
                </div>
                
                <div class="space-y-4">
                    <p class="text-sm text-slate-600">Apakah Anda yakin ingin membatalkan pesanan ini? Mohon berikan alasan pembatalan.</p>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Alasan Pembatalan</label>
                        <textarea name="reason" rows="3" class="w-full rounded-xl border-slate-200 focus:border-primary focus:ring-primary" placeholder="Contoh: Salah pesan produk, ingin ganti alamat, dll..." required></textarea>
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" onclick="document.getElementById('cancelModal').classList.add('hidden')" class="px-4 py-2 bg-slate-100 text-slate-600 rounded-xl font-medium hover:bg-slate-200 transition">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-xl font-medium hover:bg-red-700 transition">Konfirmasi Pembatalan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openCancelModal(id, orderNumber) {
        document.getElementById('cancelOrderNumber').innerText = '#' + orderNumber;
        document.getElementById('cancelForm').action = "/orders/" + id + "/cancel";
        document.getElementById('cancelModal').classList.remove('hidden');
    }
</script>

</x-client-layout>
