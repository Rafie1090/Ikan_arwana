@extends('layouts.' . Auth::user()->role)

@section('content')

<div class="max-w-7xl mx-auto">

    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Manajemen Kolam</h1>
            <p class="text-slate-500">Kelola data kolam budidaya kamu di sini.</p>
        </div>
        <button onclick="document.getElementById('modalTambah').classList.remove('hidden')" 
                class="px-5 py-2.5 bg-primary text-white font-medium rounded-xl hover:bg-indigo-700 transition shadow-lg shadow-indigo-500/30 flex items-center gap-2">
            <i class="fa-solid fa-plus"></i> Tambah Kolam
        </button>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <!-- Total Kolam -->
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 text-xl">
                <i class="fa-solid fa-water"></i>
            </div>
            <div>
                <p class="text-slate-500 text-sm font-medium">Total Kolam</p>
                <h3 class="text-2xl font-bold text-slate-900">{{ $total_kolam }}</h3>
            </div>
        </div>

        <!-- Kolam Aktif -->
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600 text-xl">
                <i class="fa-solid fa-check-circle"></i>
            </div>
            <div>
                <p class="text-slate-500 text-sm font-medium">Kolam Aktif</p>
                <h3 class="text-2xl font-bold text-slate-900">{{ $kolam_aktif }}</h3>
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100">
            <h3 class="font-bold text-lg text-slate-900">Daftar Kolam</h3>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-sm uppercase tracking-wider">
                        <th class="px-6 py-4 font-semibold">Nama Kolam</th>
                        <th class="px-6 py-4 font-semibold">Deskripsi</th>
                        <th class="px-6 py-4 font-semibold">Status</th>
                        <th class="px-6 py-4 font-semibold">Dibuat</th>
                        <th class="px-6 py-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($kolam as $row)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-900">{{ $row->nama_kolam }}</div>
                            <div class="text-xs text-slate-400">ID: {{ $row->id }}</div>
                        </td>
                        <td class="px-6 py-4 text-slate-600 max-w-xs truncate">{{ $row->deskripsi ?? '-' }}</td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-xs font-bold 
                                {{ $row->status == 'aktif' ? 'bg-emerald-50 text-emerald-600' : 'bg-slate-100 text-slate-500' }}">
                                {{ ucfirst($row->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-slate-600 text-sm">
                            {{ $row->created_at->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <button onclick="document.getElementById('editKolam{{ $row->id }}').classList.remove('hidden')" 
                                    class="text-blue-600 hover:text-blue-800 transition p-2 rounded-lg hover:bg-blue-50">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            
                            <form action="{{ route('pemilik.kolam.delete', $row->id) }}" method="POST" class="d-inline inline-block" onsubmit="return confirm('Yakin ingin menghapus?')">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 hover:text-red-800 transition p-2 rounded-lg hover:bg-red-50">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>

                    <!-- MODAL EDIT -->
                    <div id="editKolam{{ $row->id }}" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="document.getElementById('editKolam{{ $row->id }}').classList.add('hidden')"></div>
                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                <form action="{{ route('pemilik.kolam.update', $row->id) }}" method="POST" class="p-6">
                                    @csrf
                                    <div class="flex justify-between items-center mb-5">
                                        <h3 class="text-lg font-bold text-slate-900">Edit Kolam</h3>
                                        <button type="button" onclick="document.getElementById('editKolam{{ $row->id }}').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">
                                            <i class="fa-solid fa-xmark text-xl"></i>
                                        </button>
                                    </div>
                                    
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-medium text-slate-700 mb-1">Nama Kolam</label>
                                            <input type="text" name="nama_kolam" value="{{ $row->nama_kolam }}" class="w-full rounded-xl border-slate-200 focus:border-primary focus:ring-primary" required>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-slate-700 mb-1">Deskripsi</label>
                                            <textarea name="deskripsi" class="w-full rounded-xl border-slate-200 focus:border-primary focus:ring-primary" rows="3">{{ $row->deskripsi }}</textarea>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-slate-700 mb-1">Status</label>
                                            <select name="status" class="w-full rounded-xl border-slate-200 focus:border-primary focus:ring-primary">
                                                <option value="aktif" {{ $row->status=='aktif'?'selected':'' }}>Aktif</option>
                                                <option value="nonaktif" {{ $row->status=='nonaktif'?'selected':'' }}>Nonaktif</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mt-6 flex justify-end gap-3">
                                        <button type="button" onclick="document.getElementById('editKolam{{ $row->id }}').classList.add('hidden')" class="px-4 py-2 bg-slate-100 text-slate-600 rounded-xl font-medium hover:bg-slate-200 transition">Batal</button>
                                        <button type="submit" class="px-4 py-2 bg-primary text-white rounded-xl font-medium hover:bg-indigo-700 transition">Simpan Perubahan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        @if(count($kolam) == 0)
            <div class="p-8 text-center text-slate-500">
                <i class="fa-solid fa-water text-4xl mb-3 text-slate-300"></i>
                <p>Belum ada data kolam.</p>
            </div>
        @endif
    </div>

</div>

<!-- MODAL TAMBAH -->
<div id="modalTambah" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="document.getElementById('modalTambah').classList.add('hidden')"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form action="{{ route('pemilik.kolam.store') }}" method="POST" class="p-6">
                @csrf
                <div class="flex justify-between items-center mb-5">
                    <h3 class="text-lg font-bold text-slate-900">Tambah Kolam Baru</h3>
                    <button type="button" onclick="document.getElementById('modalTambah').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">
                        <i class="fa-solid fa-xmark text-xl"></i>
                    </button>
                </div>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Nama Kolam</label>
                        <input type="text" name="nama_kolam" class="w-full rounded-xl border-slate-200 focus:border-primary focus:ring-primary" placeholder="Contoh: Kolam A1" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Deskripsi</label>
                        <textarea name="deskripsi" class="w-full rounded-xl border-slate-200 focus:border-primary focus:ring-primary" rows="3" placeholder="Keterangan tambahan..."></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Status</label>
                        <select name="status" class="w-full rounded-xl border-slate-200 focus:border-primary focus:ring-primary">
                            <option value="aktif">Aktif</option>
                            <option value="nonaktif">Nonaktif</option>
                        </select>
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" onclick="document.getElementById('modalTambah').classList.add('hidden')" class="px-4 py-2 bg-slate-100 text-slate-600 rounded-xl font-medium hover:bg-slate-200 transition">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-primary text-white rounded-xl font-medium hover:bg-indigo-700 transition">Tambah Kolam</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
