@extends('layouts.' . Auth::user()->role)

@section('content')

<div class="max-w-7xl mx-auto">

    {{-- ALERT --}}
    @if(isset($alert) && $alert)
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r-xl flex items-center gap-3">
            <i class="fa-solid fa-triangle-exclamation text-red-500 text-xl"></i>
            <p class="text-red-700 font-medium">{{ $alert }}</p>
        </div>
    @endif

    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Monitoring Kualitas Air</h1>
            <p class="text-slate-500">Pantau kondisi air kolam secara real-time.</p>
        </div>
        <button onclick="document.getElementById('modalTambah').classList.remove('hidden')" 
                class="px-5 py-2.5 bg-primary text-white font-medium rounded-xl hover:bg-indigo-700 transition shadow-lg shadow-indigo-500/30 flex items-center gap-2">
            <i class="fa-solid fa-plus"></i> Input Data Manual
        </button>
    </div>

    <!-- Filter Kolam -->
    <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm mb-8 flex items-center gap-4">
        <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-slate-500">
            <i class="fa-solid fa-filter"></i>
        </div>
        <div class="flex-1">
            <p class="text-xs text-slate-400 font-bold uppercase tracking-wider mb-1">Pilih Kolam</p>
            <form method="GET" action="{{ route('monitoring.air') }}">
                <select name="kolam" onchange="this.form.submit()" 
                        class="w-full md:w-64 bg-slate-50 border-none text-sm font-semibold text-slate-700 rounded-lg focus:ring-2 focus:ring-primary cursor-pointer py-2 pl-3 pr-10">
                    @foreach($daftar_kolam as $k)
                        <option value="{{ $k->id }}" {{ $kolam == $k->id ? 'selected' : '' }}>
                            {{ $k->nama_kolam }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>
    </div>

    @php
        $last = $data->last();

        function statusAir($value, $min, $max){
            if($value === null) return ['-', 'slate'];
            if($value < $min) return ['Bahaya', 'red'];
            if($value > $max) return ['Warning', 'amber'];
            return ['Normal', 'emerald'];
        }

        [$s_st,$s_color] = statusAir($last->suhu ?? null, 25, 30);
        [$p_st,$p_color] = statusAir($last->ph ?? null, 6.5, 8.5);
        [$o_st,$o_color] = statusAir($last->oksigen ?? null, 5, 12);
    @endphp

    <!-- Parameter Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Suhu -->
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-24 h-24 bg-blue-50 rounded-bl-full -mr-12 -mt-12 transition group-hover:scale-110"></div>
            <div class="relative z-10">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-slate-500 text-sm font-medium">Suhu Air</p>
                        <h3 class="text-3xl font-bold text-slate-900 mt-1">{{ $last->suhu ?? '-' }}°C</h3>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center text-blue-600">
                        <i class="fa-solid fa-temperature-half"></i>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-{{ $s_color }}-50 text-{{ $s_color }}-600">
                        {{ $s_st }}
                    </span>
                    <span class="text-xs text-slate-400">Ideal: 25-30°C</span>
                </div>
            </div>
        </div>

        <!-- pH -->
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-24 h-24 bg-teal-50 rounded-bl-full -mr-12 -mt-12 transition group-hover:scale-110"></div>
            <div class="relative z-10">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-slate-500 text-sm font-medium">pH Air</p>
                        <h3 class="text-3xl font-bold text-slate-900 mt-1">{{ $last->ph ?? '-' }}</h3>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-teal-100 flex items-center justify-center text-teal-600">
                        <i class="fa-solid fa-droplet"></i>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-{{ $p_color }}-50 text-{{ $p_color }}-600">
                        {{ $p_st }}
                    </span>
                    <span class="text-xs text-slate-400">Ideal: 6.5-8.5</span>
                </div>
            </div>
        </div>

        <!-- Oksigen -->
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-24 h-24 bg-cyan-50 rounded-bl-full -mr-12 -mt-12 transition group-hover:scale-110"></div>
            <div class="relative z-10">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-slate-500 text-sm font-medium">Oksigen (DO)</p>
                        <h3 class="text-3xl font-bold text-slate-900 mt-1">{{ $last->oksigen ?? '-' }} <span class="text-lg text-slate-400 font-normal">mg/L</span></h3>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-cyan-100 flex items-center justify-center text-cyan-600">
                        <i class="fa-solid fa-wind"></i>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-{{ $o_color }}-50 text-{{ $o_color }}-600">
                        {{ $o_st }}
                    </span>
                    <span class="text-xs text-slate-400">Min: 5 mg/L</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
            <h4 class="font-bold text-slate-900 mb-4">Grafik Suhu</h4>
            <div class="relative h-64">
                <canvas id="chartSuhu"></canvas>
            </div>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
            <h4 class="font-bold text-slate-900 mb-4">Grafik pH</h4>
            <div class="relative h-64">
                <canvas id="chartPh"></canvas>
            </div>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm lg:col-span-2">
            <h4 class="font-bold text-slate-900 mb-4">Grafik Oksigen</h4>
            <div class="relative h-64">
                <canvas id="chartOksigen"></canvas>
            </div>
        </div>
    </div>

    <!-- Export Button -->
    <div class="flex justify-end mb-4">
        <a href="{{ route('monitoring.air.export.excel', $kolam) }}" 
           class="px-4 py-2 bg-emerald-600 text-white font-medium rounded-xl hover:bg-emerald-700 transition flex items-center gap-2 shadow-lg shadow-emerald-500/20">
            <i class="fa-solid fa-file-excel"></i> Export Excel
        </a>
    </div>

    <!-- History Table -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100">
            <h3 class="font-bold text-lg text-slate-900">Riwayat Monitoring</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[600px]">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-sm uppercase tracking-wider">
                        <th class="px-6 py-4 font-semibold">Waktu</th>
                        <th class="px-6 py-4 font-semibold">Suhu (°C)</th>
                        <th class="px-6 py-4 font-semibold">pH</th>
                        <th class="px-6 py-4 font-semibold">Oksigen (mg/L)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($data as $row)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-6 py-4 text-slate-500 font-medium">
                                {{ $row->created_at->format('d M Y, H:i') }}
                            </td>
                            <td class="px-6 py-4 font-bold text-slate-700">{{ $row->suhu }}</td>
                            <td class="px-6 py-4 font-bold text-slate-700">{{ $row->ph }}</td>
                            <td class="px-6 py-4 font-bold text-slate-700">{{ $row->oksigen }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if($data->isEmpty())
            <div class="p-8 text-center text-slate-500">
                <p>Belum ada data monitoring.</p>
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
            <form action="{{ route('monitoring.air.store') }}" method="POST" class="p-6">
                @csrf
                <input type="hidden" name="kolam_id" value="{{ $kolam }}">
                
                <div class="flex justify-between items-center mb-5">
                    <h3 class="text-lg font-bold text-slate-900">Input Data Manual</h3>
                    <button type="button" onclick="document.getElementById('modalTambah').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">
                        <i class="fa-solid fa-xmark text-xl"></i>
                    </button>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Suhu (°C)</label>
                        <input type="number" step="0.1" name="suhu" class="w-full rounded-xl border-slate-200 focus:border-primary focus:ring-primary" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">pH</label>
                        <input type="number" step="0.1" name="ph" class="w-full rounded-xl border-slate-200 focus:border-primary focus:ring-primary" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Oksigen (mg/L)</label>
                        <input type="number" step="0.1" name="oksigen" class="w-full rounded-xl border-slate-200 focus:border-primary focus:ring-primary" required>
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" onclick="document.getElementById('modalTambah').classList.add('hidden')" class="px-4 py-2 bg-slate-100 text-slate-600 rounded-xl font-medium hover:bg-slate-200 transition">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-primary text-white rounded-xl font-medium hover:bg-indigo-700 transition">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const waktu   = @json($data->pluck('created_at')->map(fn($d)=>$d->format('d M H:i')));
const suhu    = @json($data->pluck('suhu'));
const ph      = @json($data->pluck('ph'));
const oksigen = @json($data->pluck('oksigen'));

function makeLineChart(id, label, data, color){
    new Chart(document.getElementById(id), {
        type: 'line',
        data: {
            labels: waktu,
            datasets: [{
                label: label,
                data: data,
                borderColor: color,
                backgroundColor: color + '20', // Opacity hex
                borderWidth: 2,
                tension: 0.4,
                fill: true,
                pointRadius: 3,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { grid: { borderDash: [4, 4] } },
                x: { grid: { display: false } }
            }
        }
    });
}

makeLineChart('chartSuhu', 'Suhu (°C)', suhu, '#3b82f6');
makeLineChart('chartPh', 'pH', ph, '#14b8a6');
makeLineChart('chartOksigen', 'Oksigen (mg/L)', oksigen, '#06b6d4');
</script>
@endpush
