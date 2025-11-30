@extends('layouts.' . Auth::user()->role)

@section('content')

<div class="max-w-7xl mx-auto">

    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Manajemen Jadwal Pakan</h1>
            <p class="text-slate-500">Atur dan pantau jadwal pemberian pakan ikan.</p>
        </div>
        <button onclick="document.getElementById('modalTambah').classList.remove('hidden')" 
                class="px-5 py-2.5 bg-primary text-white font-medium rounded-xl hover:bg-indigo-700 transition shadow-lg shadow-indigo-500/30 flex items-center gap-2">
            <i class="fa-solid fa-plus"></i> Tambah Jadwal
        </button>
    </div>

    <!-- Filter Section -->
    <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm mb-8">
        <form method="GET" action="{{ route('manajemen.pakan.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            
            <div class="md:col-span-1">
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Cari Pakan</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fa-solid fa-search text-slate-400"></i>
                    </div>
                    <input type="text" name="pakan" value="{{ old('pakan', request('pakan')) }}" 
                           class="w-full pl-10 pr-4 py-2.5 rounded-xl border-slate-200 focus:border-primary focus:ring-primary text-sm"
                           placeholder="Contoh: Pelet...">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Kolam</label>
                <select name="kolam_id" class="w-full py-2.5 rounded-xl border-slate-200 focus:border-primary focus:ring-primary text-sm">
                    <option value="">Semua Kolam</option>
                    @foreach ($kolams as $kolam)
                        <option value="{{ $kolam->id }}" {{ old('kolam_id', request('kolam_id')) == $kolam->id ? 'selected' : '' }}>
                            {{ $kolam->nama_kolam }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tanggal</label>
                <input type="date" name="tanggal" value="{{ old('tanggal', request('tanggal')) }}" 
                       class="w-full py-2.5 rounded-xl border-slate-200 focus:border-primary focus:ring-primary text-sm">
            </div>

            <div>
                <button type="submit" class="w-full py-2.5 bg-slate-800 text-white font-medium rounded-xl hover:bg-slate-900 transition flex items-center justify-center gap-2">
                    <i class="fa-solid fa-filter"></i> Terapkan Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Table Section -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex justify-between items-center">
            <h3 class="font-bold text-lg text-slate-900">Daftar Jadwal</h3>
            <span class="px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-xs font-bold">
                Total: {{ count($jadwalPakan) }}
            </span>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-sm uppercase tracking-wider">
                        <th class="px-6 py-4 font-semibold">Kolam</th>
                        <th class="px-6 py-4 font-semibold">Waktu</th>
                        <th class="px-6 py-4 font-semibold">Sesi</th>
                        <th class="px-6 py-4 font-semibold">Jumlah</th>
                        <th class="px-6 py-4 font-semibold">Jenis Pakan</th>
                        <th class="px-6 py-4 font-semibold">Status</th>
                        <th class="px-6 py-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($jadwalPakan as $jadwal)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-6 py-4 font-medium text-slate-900">{{ $jadwal->kolam->nama_kolam }}</td>
                        <td class="px-6 py-4 text-slate-600">
                            <div class="flex items-center gap-2">
                                <i class="fa-regular fa-clock text-slate-400"></i>
                                {{ $jadwal->waktu }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-xs font-bold 
                                {{ $jadwal->sesi == 'Pagi' ? 'bg-amber-50 text-amber-600' : 'bg-orange-50 text-orange-600' }}">
                                {{ $jadwal->sesi }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-slate-600">{{ $jadwal->jumlah }}</td>
                        <td class="px-6 py-4 text-slate-600">{{ $jadwal->jenis_pakan }}</td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-xs font-bold 
                                {{ $jadwal->status == 'Aktif' ? 'bg-emerald-50 text-emerald-600' : 'bg-red-50 text-red-600' }}">
                                {{ $jadwal->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-2">
                                <button onclick='openEditModal(@json($jadwal))' class="text-blue-600 hover:text-blue-800 transition p-2 rounded-lg hover:bg-blue-50">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <button onclick="openDeleteModal({{ $jadwal->id }})" class="text-red-600 hover:text-red-800 transition p-2 rounded-lg hover:bg-red-50">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($jadwalPakan->isEmpty())
            <div class="p-12 text-center">
                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300 text-2xl">
                    <i class="fa-solid fa-bowl-food"></i>
                </div>
                <h3 class="text-slate-900 font-medium mb-1">Belum ada jadwal pakan</h3>
                <p class="text-slate-500 text-sm mb-4">Buat jadwal baru untuk mulai memberi pakan.</p>
                <button onclick="document.getElementById('modalTambah').classList.remove('hidden')" 
                        class="text-primary font-bold hover:underline">
                    Tambah Jadwal Sekarang
                </button>
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
            <form action="{{ route('manajemen.pakan.store') }}" method="POST" class="p-6">
                @csrf
                <div class="flex justify-between items-center mb-5">
                    <h3 class="text-lg font-bold text-slate-900">Tambah Jadwal Pakan</h3>
                    <button type="button" onclick="document.getElementById('modalTambah').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">
                        <i class="fa-solid fa-xmark text-xl"></i>
                    </button>
                </div>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Pilih Kolam</label>
                        <select name="kolam_id" class="w-full rounded-xl border-slate-200 focus:border-primary focus:ring-primary" required>
                            <option value="">-- Pilih Kolam --</option>
                            @foreach ($kolams as $kolam)
                                <option value="{{ $kolam->id }}">{{ $kolam->nama_kolam }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Waktu</label>
                            <input type="time" name="waktu" class="w-full rounded-xl border-slate-200 focus:border-primary focus:ring-primary" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Sesi</label>
                            <select name="sesi" class="w-full rounded-xl border-slate-200 focus:border-primary focus:ring-primary" required>
                                <option value="Pagi">Pagi</option>
                                <option value="Siang">Siang</option>
                                <option value="Sore">Sore</option>
                                <option value="Malam">Malam</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Jumlah</label>
                            <input type="number" name="jumlah" class="w-full rounded-xl border-slate-200 focus:border-primary focus:ring-primary" placeholder="Gram" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Jenis Pakan</label>
                            <select name="jenis_pakan" class="w-full rounded-xl border-slate-200 focus:border-primary focus:ring-primary" required>
                                <option value="Pelet">Pelet</option>
                                <option value="Worm">Worm</option>
                                <option value="Jangkrik">Jangkrik</option>
                                <option value="Udang">Udang</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" onclick="document.getElementById('modalTambah').classList.add('hidden')" class="px-4 py-2 bg-slate-100 text-slate-600 rounded-xl font-medium hover:bg-slate-200 transition">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-primary text-white rounded-xl font-medium hover:bg-indigo-700 transition">Simpan Jadwal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL EDIT -->
<div id="modalEdit" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="document.getElementById('modalEdit').classList.add('hidden')"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form id="formEdit" method="POST" class="p-6">
                @csrf
                @method('PUT')
                <div class="flex justify-between items-center mb-5">
                    <h3 class="text-lg font-bold text-slate-900">Edit Jadwal Pakan</h3>
                    <button type="button" onclick="document.getElementById('modalEdit').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">
                        <i class="fa-solid fa-xmark text-xl"></i>
                    </button>
                </div>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Pilih Kolam</label>
                        <select name="kolam_id" id="edit_kolam_id" class="w-full rounded-xl border-slate-200 focus:border-primary focus:ring-primary" required>
                            <option value="">-- Pilih Kolam --</option>
                            @foreach ($kolams as $kolam)
                                <option value="{{ $kolam->id }}">{{ $kolam->nama_kolam }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Waktu</label>
                            <input type="time" name="waktu" id="edit_waktu" class="w-full rounded-xl border-slate-200 focus:border-primary focus:ring-primary" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Sesi</label>
                            <select name="sesi" id="edit_sesi" class="w-full rounded-xl border-slate-200 focus:border-primary focus:ring-primary" required>
                                <option value="Pagi">Pagi</option>
                                <option value="Siang">Siang</option>
                                <option value="Sore">Sore</option>
                                <option value="Malam">Malam</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Jumlah</label>
                            <input type="number" name="jumlah" id="edit_jumlah" class="w-full rounded-xl border-slate-200 focus:border-primary focus:ring-primary" placeholder="Gram" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Jenis Pakan</label>
                            <select name="jenis_pakan" id="edit_jenis_pakan" class="w-full rounded-xl border-slate-200 focus:border-primary focus:ring-primary" required>
                                <option value="Pelet">Pelet</option>
                                <option value="Worm">Worm</option>
                                <option value="Jangkrik">Jangkrik</option>
                                <option value="Udang">Udang</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Status</label>
                        <select name="status" id="edit_status" class="w-full rounded-xl border-slate-200 focus:border-primary focus:ring-primary" required>
                            <option value="Aktif">Aktif</option>
                            <option value="Tidak Aktif">Tidak Aktif</option>
                        </select>
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" onclick="document.getElementById('modalEdit').classList.add('hidden')" class="px-4 py-2 bg-slate-100 text-slate-600 rounded-xl font-medium hover:bg-slate-200 transition">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-primary text-white rounded-xl font-medium hover:bg-indigo-700 transition">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL DELETE -->
<div id="modalDelete" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="document.getElementById('modalDelete').classList.add('hidden')"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-sm sm:w-full">
            <div class="p-6 text-center">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4 text-red-600 text-2xl">
                    <i class="fa-solid fa-trash-can"></i>
                </div>
                <h3 class="text-lg font-bold text-slate-900 mb-2">Hapus Jadwal?</h3>
                <p class="text-sm text-slate-500 mb-6">Data yang dihapus tidak dapat dikembalikan.</p>
                
                <form id="formDelete" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="flex justify-center gap-3">
                        <button type="button" onclick="document.getElementById('modalDelete').classList.add('hidden')" class="px-4 py-2 bg-slate-100 text-slate-600 rounded-xl font-medium hover:bg-slate-200 transition">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-xl font-medium hover:bg-red-700 transition">Ya, Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function openEditModal(data) {
        document.getElementById('modalEdit').classList.remove('hidden');
        document.getElementById('formEdit').action = "{{ route('manajemen.pakan.index') }}/" + data.id;
        
        document.getElementById('edit_kolam_id').value = data.kolam_id;
        document.getElementById('edit_waktu').value = data.waktu;
        document.getElementById('edit_sesi').value = data.sesi;
        document.getElementById('edit_jumlah').value = data.jumlah;
        document.getElementById('edit_jenis_pakan').value = data.jenis_pakan;
        document.getElementById('edit_status').value = data.status;
    }

    function openDeleteModal(id) {
        document.getElementById('modalDelete').classList.remove('hidden');
        document.getElementById('formDelete').action = "{{ route('manajemen.pakan.index') }}/" + id;
    }
</script>

@endsection
