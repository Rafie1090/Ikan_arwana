@extends('layouts.pemilik')

@section('content')

<div class="max-w-7xl mx-auto">

    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <div class="flex items-center gap-2 text-slate-500 mb-1">
                <a href="{{ url()->previous() }}" class="hover:text-primary transition">
                    <i class="fa-solid fa-arrow-left"></i> Kembali
                </a>
            </div>
            <h1 class="text-2xl font-bold text-slate-900">Daftar Produk</h1>
            <p class="text-slate-500">Kelola katalog produk yang dijual.</p>
        </div>
        <button onclick="document.getElementById('addModal').classList.remove('hidden')" 
                class="px-5 py-2.5 bg-primary text-white font-medium rounded-xl hover:bg-indigo-700 transition shadow-lg shadow-indigo-500/30 flex items-center gap-2">
            <i class="fa-solid fa-plus"></i> Tambah Produk
        </button>
    </div>

    <!-- Product Table -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden" data-aos="fade-up">
        <div class="p-6 border-b border-slate-100 flex justify-between items-center">
            <h3 class="font-bold text-lg text-slate-900">Katalog Produk</h3>
            <span class="px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-xs font-bold">
                Total: {{ count($products) }}
            </span>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-sm uppercase tracking-wider">
                        <th class="px-6 py-4 font-semibold text-center w-24">Gambar</th>
                        <th class="px-6 py-4 font-semibold">Nama Produk</th>
                        <th class="px-6 py-4 font-semibold">Harga</th>
                        <th class="px-6 py-4 font-semibold">Stok</th>
                        <th class="px-6 py-4 font-semibold">Kategori</th>
                        <th class="px-6 py-4 font-semibold">Deskripsi</th>
                        <th class="px-6 py-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($products as $product)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-6 py-4">
                            <div class="w-16 h-16 rounded-lg overflow-hidden border border-slate-200 bg-slate-50">
                                <img src="{{ $product->image }}" 
                                     class="w-full h-full object-cover" 
                                     alt="{{ $product->name }}">
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-900">{{ $product->name }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-bold text-primary">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-xs font-bold 
                                {{ $product->stock > 0 ? 'bg-emerald-50 text-emerald-600' : 'bg-red-50 text-red-600' }}">
                                {{ $product->stock }} Unit
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-600 capitalize">
                                {{ $product->category }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-slate-600 text-sm max-w-xs truncate">
                            {{ \Illuminate\Support\Str::limit($product->description, 50) }}
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <button onclick="openEditModal({{ $product->id }}, '{{ $product->name }}', '{{ $product->price }}', '{{ $product->stock }}', `{{ $product->description }}`, '{{ $product->image }}', '{{ $product->category }}')"
                                    class="text-blue-600 hover:text-blue-800 transition p-2 rounded-lg hover:bg-blue-50">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            
                            <form action="{{ route('pemilik.product.delete', $product->id) }}" method="POST" class="d-inline inline-block" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 hover:text-red-800 transition p-2 rounded-lg hover:bg-red-50">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-12 text-center">
                            <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300 text-2xl">
                                <i class="fa-solid fa-box-open"></i>
                            </div>
                            <h3 class="text-slate-900 font-medium mb-1">Belum ada produk</h3>
                            <p class="text-slate-500 text-sm">Tambahkan produk pertama Anda.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- MODAL TAMBAH -->
<div id="addModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="document.getElementById('addModal').classList.add('hidden')"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form action="{{ route('pemilik.product.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf
                <div class="flex justify-between items-center mb-5">
                    <h3 class="text-lg font-bold text-slate-900">Tambah Produk Baru</h3>
                    <button type="button" onclick="document.getElementById('addModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">
                        <i class="fa-solid fa-xmark text-xl"></i>
                    </button>
                </div>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Nama Produk</label>
                        <input type="text" name="name" class="w-full rounded-xl border-slate-200 focus:border-primary focus:ring-primary" required>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Harga (Rp)</label>
                            <input type="number" name="price" class="w-full rounded-xl border-slate-200 focus:border-primary focus:ring-primary" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Stok</label>
                            <input type="number" name="stock" class="w-full rounded-xl border-slate-200 focus:border-primary focus:ring-primary" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Kategori</label>
                        <select name="category" class="w-full rounded-xl border-slate-200 focus:border-primary focus:ring-primary" required>
                            <option value="peliharaan">Peliharaan (Ikan)</option>
                            <option value="produk">Produk (Pakan/Alat)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Deskripsi</label>
                        <textarea name="description" rows="3" class="w-full rounded-xl border-slate-200 focus:border-primary focus:ring-primary" required></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Gambar Produk</label>
                        <input type="file" name="image" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary file:text-white hover:file:bg-indigo-700" required>
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" onclick="document.getElementById('addModal').classList.add('hidden')" class="px-4 py-2 bg-slate-100 text-slate-600 rounded-xl font-medium hover:bg-slate-200 transition">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-primary text-white rounded-xl font-medium hover:bg-indigo-700 transition">Simpan Produk</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL EDIT -->
<div id="editModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="document.getElementById('editModal').classList.add('hidden')"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form id="editForm" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf
                @method('PUT')
                <div class="flex justify-between items-center mb-5">
                    <h3 class="text-lg font-bold text-slate-900">Edit Produk</h3>
                    <button type="button" onclick="document.getElementById('editModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">
                        <i class="fa-solid fa-xmark text-xl"></i>
                    </button>
                </div>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Nama Produk</label>
                        <input type="text" id="editName" name="name" class="w-full rounded-xl border-slate-200 focus:border-primary focus:ring-primary" required>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Harga (Rp)</label>
                            <input type="number" id="editPrice" name="price" class="w-full rounded-xl border-slate-200 focus:border-primary focus:ring-primary" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Stok</label>
                            <input type="number" id="editStock" name="stock" class="w-full rounded-xl border-slate-200 focus:border-primary focus:ring-primary" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Kategori</label>
                        <select id="editCategory" name="category" class="w-full rounded-xl border-slate-200 focus:border-primary focus:ring-primary" required>
                            <option value="peliharaan">Peliharaan (Ikan)</option>
                            <option value="produk">Produk (Pakan/Alat)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Deskripsi</label>
                        <textarea id="editDescription" name="description" rows="3" class="w-full rounded-xl border-slate-200 focus:border-primary focus:ring-primary" required></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Gambar Saat Ini</label>
                        <div class="flex items-center gap-4">
                            <img id="editImagePreview" src="" class="w-20 h-20 rounded-lg object-cover border border-slate-200">
                            <div class="flex-1">
                                <label class="block text-xs text-slate-500 mb-1">Ganti Gambar (Opsional)</label>
                                <input type="file" name="image" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" onclick="document.getElementById('editModal').classList.add('hidden')" class="px-4 py-2 bg-slate-100 text-slate-600 rounded-xl font-medium hover:bg-slate-200 transition">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-primary text-white rounded-xl font-medium hover:bg-indigo-700 transition">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openEditModal(id, name, price, stock, description, imageUrl, category) {
        document.getElementById('editName').value = name;
        document.getElementById('editPrice').value = price;
        document.getElementById('editStock').value = stock;
        document.getElementById('editDescription').value = description;
        document.getElementById('editImagePreview').src = imageUrl;
        document.getElementById('editCategory').value = category;

        document.getElementById('editForm').action = "/pemilik/produk/update/" + id;
        document.getElementById('editModal').classList.remove('hidden');
    }
</script>

@endsection
