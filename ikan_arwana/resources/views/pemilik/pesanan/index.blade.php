@extends('layouts.' . Auth::user()->role)

@section('content')

<div class="max-w-7xl mx-auto">

    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Kelola Pesanan</h1>
            <p class="text-slate-500">Kelola pesanan masuk dari pelanggan.</p>
        </div>
        
        <div class="flex gap-3">
            <a href="{{ route('pemilik.pesanan.export') }}" class="px-4 py-2 bg-emerald-600 text-white text-sm font-bold rounded-xl hover:bg-emerald-700 transition flex items-center gap-2 shadow-lg shadow-emerald-500/30">
                <i class="fa-solid fa-file-excel"></i> Export Excel
            </a>
        </div>
    </div>

    <!-- Table Section -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden" data-aos="fade-up">
        <div class="p-6 border-b border-slate-100 flex justify-between items-center">
            <h3 class="font-bold text-lg text-slate-900">Daftar Pesanan</h3>
            <span class="px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-xs font-bold">
                Total: {{ count($orders) }}
            </span>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-sm uppercase tracking-wider">
                        <th class="px-6 py-4 font-semibold">Order ID</th>
                        <th class="px-6 py-4 font-semibold">Pelanggan</th>
                        <th class="px-6 py-4 font-semibold">Tanggal</th>
                        <th class="px-6 py-4 font-semibold">Produk</th>
                        <th class="px-6 py-4 font-semibold">Total</th>
                        <th class="px-6 py-4 font-semibold">Status</th>
                        <th class="px-6 py-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($orders as $order)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-6 py-4 font-medium text-slate-900">#{{ $order->order_number }}</td>
                        <td class="px-6 py-4 text-slate-600">
                            <div class="font-medium text-slate-900">{{ $order->customer_name }}</div>
                            <div class="text-xs text-slate-400">{{ $order->customer_phone }}</div>
                        </td>
                        <td class="px-6 py-4 text-slate-600">{{ $order->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4 text-slate-600">
                            <div class="space-y-2">
                                @foreach($order->items as $item)
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-slate-50 border border-slate-200 overflow-hidden flex-shrink-0">
                                        @if($item->product && $item->product->image)
                                            <img src="{{ $item->product->image }}" alt="{{ $item->product_name }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-slate-300 text-xs">
                                                <i class="fa-solid fa-image"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-slate-900">{{ $item->product_name }}</div>
                                        <div class="text-xs text-slate-500">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </td>
                        <td class="px-6 py-4 font-bold text-primary">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-xs font-bold 
                                {{ $order->status == 'pending' ? 'bg-amber-100 text-amber-600' : '' }}
                                {{ $order->status == 'processing' ? 'bg-blue-100 text-blue-600' : '' }}
                                {{ $order->status == 'shipped' ? 'bg-indigo-100 text-indigo-600' : '' }}
                                {{ $order->status == 'delivered' ? 'bg-emerald-100 text-emerald-600' : '' }}
                                {{ $order->status == 'cancelled' ? 'bg-red-100 text-red-600' : '' }}">
                                {{ ucfirst($order->status) }}
                            </span>
                            @if($order->status == 'cancelled' && $order->cancellation_note)
                                <div class="mt-2 text-xs text-red-600 bg-red-50 p-2 rounded-lg border border-red-100">
                                    <strong>Alasan:</strong> {{ $order->cancellation_note }}
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <button onclick='openStatusModal(@json($order))' class="text-blue-600 hover:text-blue-800 transition p-2 rounded-lg hover:bg-blue-50">
                                <i class="fa-solid fa-pen-to-square"></i> Update Status
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                            <i class="fa-solid fa-clipboard-list text-4xl mb-3 text-slate-300"></i>
                            <p>Belum ada pesanan masuk.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- MODAL UPDATE STATUS -->
<div id="modalStatus" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="document.getElementById('modalStatus').classList.add('hidden')"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form id="formStatus" method="POST" class="p-6">
                @csrf
                @method('PUT')
                <div class="flex justify-between items-center mb-5">
                    <h3 class="text-lg font-bold text-slate-900">Update Status Pesanan</h3>
                    <button type="button" onclick="document.getElementById('modalStatus').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">
                        <i class="fa-solid fa-xmark text-xl"></i>
                    </button>
                </div>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Status Pesanan</label>
                        <select name="status" id="status_select" onchange="toggleCancellationNote(this.value)" class="w-full rounded-xl border-slate-200 focus:border-primary focus:ring-primary" required>
                            <option value="pending">Pending</option>
                            <option value="processing">Processing (Sedang Dikemas)</option>
                            <option value="shipped">Shipped (Sedang Dikirim)</option>
                            <option value="delivered">Delivered (Selesai)</option>
                            <option value="cancelled">Cancelled (Dibatalkan)</option>
                        </select>
                    </div>

                    <div id="cancellation_note_container" class="hidden">
                        <label class="block text-sm font-medium text-slate-700 mb-1">Alasan Pembatalan</label>
                        <textarea name="cancellation_note" rows="3" class="w-full rounded-xl border-slate-200 focus:border-primary focus:ring-primary" placeholder="Tuliskan alasan pembatalan..."></textarea>
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" onclick="document.getElementById('modalStatus').classList.add('hidden')" class="px-4 py-2 bg-slate-100 text-slate-600 rounded-xl font-medium hover:bg-slate-200 transition">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-primary text-white rounded-xl font-medium hover:bg-indigo-700 transition">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openStatusModal(order) {
        document.getElementById('modalStatus').classList.remove('hidden');
        document.getElementById('formStatus').action = "{{ route('pemilik.pesanan.index') }}/" + order.id + "/status";
        document.getElementById('status_select').value = order.status;
        
        // Populate cancellation note if exists
        const noteTextarea = document.querySelector('textarea[name="cancellation_note"]');
        if (order.cancellation_note) {
            noteTextarea.value = order.cancellation_note;
        } else {
            noteTextarea.value = '';
        }

        toggleCancellationNote(order.status);
    }

    function toggleCancellationNote(status) {
        const container = document.getElementById('cancellation_note_container');
        if (status === 'cancelled') {
            container.classList.remove('hidden');
        } else {
            container.classList.add('hidden');
        }
    }
</script>

@endsection
