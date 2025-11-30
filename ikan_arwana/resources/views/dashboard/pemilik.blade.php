@extends('layouts.pemilik')

@section('content')

<div class="max-w-6xl mx-auto">

    <!-- Header & Filter -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Dashboard Overview</h1>
            <p class="text-slate-500">Pantau kondisi kolam dan bisnis Anda hari ini.</p>
        </div>

        @if($daftar_kolam->count() > 0)
        <div class="bg-white p-1.5 rounded-xl border border-slate-200 shadow-sm flex items-center">
            <form method="GET" action="{{ route('pemilik.dashboard') }}" class="flex items-center gap-2">
                <span class="text-xs font-semibold text-slate-500 px-2">Pilih Kolam:</span>
                <select name="kolam" onchange="this.form.submit()" 
                        class="bg-slate-50 border-none text-sm font-medium text-slate-700 rounded-lg focus:ring-0 cursor-pointer py-1.5 pl-3 pr-8">
                    @foreach($daftar_kolam as $k)
                        <option value="{{ $k->id }}" {{ $kolam == $k->id ? 'selected' : '' }}>{{ $k->nama_kolam }}</option>
                    @endforeach
                </select>
            </form>
        </div>
        @endif
    </div>

    <!-- STATS CARDS -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        
        <!-- Card 1: Total Produk -->
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition">
            <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 mb-4">
                <i class="fa-solid fa-box text-xl"></i>
            </div>
            <p class="text-slate-500 text-sm font-medium">Total Produk</p>
            <h3 class="text-2xl font-bold text-slate-900 mt-1">{{ $totalProduk }}</h3>
            <div class="flex items-center gap-1 mt-2 text-xs font-medium text-slate-500 bg-slate-50 px-2 py-1 rounded-full w-fit">
                <i class="fa-solid fa-fish"></i> Produk Arwana
            </div>
        </div>

        <!-- Card 2 -->
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition">
            <div class="w-12 h-12 rounded-xl bg-cyan-50 flex items-center justify-center text-cyan-600 mb-4">
                <i class="fa-solid fa-droplet text-xl"></i>
            </div>
            <p class="text-slate-500 text-sm font-medium">Kualitas Air</p>
            <h3 class="text-2xl font-bold mt-1 {{ $status == 'Normal' ? 'text-emerald-600' : 'text-red-600' }}">
                {{ $status }}
            </h3>
            @if($last)
            <p class="text-xs text-slate-400 mt-2">
                Suhu: {{ $last->suhu }}°C • pH: {{ $last->ph }}
            </p>
            @else
            <p class="text-xs text-slate-400 mt-2">Belum ada data</p>
            @endif
        </div>

        <!-- Card 3: Jadwal Pakan Hari Ini -->
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition">
            <div class="w-12 h-12 rounded-xl bg-amber-50 flex items-center justify-center text-amber-600 mb-4">
                <i class="fa-solid fa-calendar-day text-xl"></i>
            </div>
            <p class="text-slate-500 text-sm font-medium">Jadwal Pakan Hari Ini</p>
            @if($jadwalHariIni->count() > 0)
                <h3 class="text-2xl font-bold text-slate-900 mt-1">{{ $jadwalHariIni->count() }}x</h3>
                <p class="text-xs text-slate-400 mt-2">Berikutnya: {{ $jadwalHariIni->first()->waktu }}</p>
            @else
                <h3 class="text-2xl font-bold text-slate-400 mt-1">--</h3>
                <p class="text-xs text-slate-400 mt-2">Belum ada jadwal</p>
            @endif
        </div>

        <!-- Card 4: Total Kolam -->
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600 mb-4">
                <i class="fa-solid fa-water text-xl"></i>
            </div>
            <p class="text-slate-500 text-sm font-medium">Total Kolam</p>
            <h3 class="text-2xl font-bold text-slate-900 mt-1">{{ $totalKolam }}</h3>
            <div class="flex items-center gap-1 mt-2 text-xs font-medium text-cyan-600 bg-cyan-50 px-2 py-1 rounded-full w-fit">
                <i class="fa-solid fa-check-circle"></i> Aktif
            </div>
        </div>

    </div>

    <!-- CHART SECTION -->
    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm mb-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="font-bold text-lg text-slate-900">Grafik Suhu Air</h3>
                <p class="text-sm text-slate-500">Monitoring suhu real-time 24 jam terakhir</p>
            </div>
            <a href="{{ route('monitoring.air', ['kolam' => $kolam]) }}" 
               class="px-4 py-2 bg-slate-50 text-slate-600 text-sm font-medium rounded-lg hover:bg-slate-100 transition">
                Lihat Detail
            </a>
        </div>
        <div class="relative h-64 w-full">
            <canvas id="grafikSuhu"></canvas>
        </div>
    </div>

    <!-- QUICK MENU -->
    <h3 class="font-bold text-lg text-slate-900 mb-4">Menu Cepat</h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <a href="{{ route('pemilik.product.list') }}" class="group bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md hover:border-primary/30 transition">
            <div class="w-14 h-14 rounded-2xl bg-indigo-50 text-primary flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition">
                <i class="fa-solid fa-box-open"></i>
            </div>
            <h4 class="font-bold text-slate-900 mb-1">Manajemen Produk</h4>
            <p class="text-sm text-slate-500">Tambah, edit, dan kelola stok produk.</p>
        </a>

        <a href="{{ route('pemilik.pesanan.index') }}" class="group bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md hover:border-emerald-500/30 transition">
            <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition">
                <i class="fa-solid fa-clipboard-check"></i>
            </div>
            <h4 class="font-bold text-slate-900 mb-1">Manajemen Pesanan</h4>
            <p class="text-sm text-slate-500">Proses pesanan dari pelanggan.</p>
        </a>



    </div>

</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
let waktu   = @json($miniData->pluck('created_at')->map(fn($d)=>$d->format('H:i')));
let suhu    = @json($miniData->pluck('suhu'));

if (waktu.length === 0) {
    waktu = ['No Data'];
    suhu  = [0];
}

new Chart(document.getElementById('grafikSuhu'), {
    type: 'line',
    data: {
        labels: waktu,
        datasets: [{
            label: 'Suhu (°C)',
            data: suhu,
            borderColor: '#4F46E5',
            backgroundColor: (context) => {
                const ctx = context.chart.ctx;
                const gradient = ctx.createLinearGradient(0, 0, 0, 200);
                gradient.addColorStop(0, 'rgba(79, 70, 229, 0.2)');
                gradient.addColorStop(1, 'rgba(79, 70, 229, 0)');
                return gradient;
            },
            borderWidth: 3,
            fill: true,
            tension: 0.4,
            pointRadius: 0,
            pointHoverRadius: 6
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { 
            legend: { display: false },
            tooltip: {
                backgroundColor: '#1e293b',
                padding: 12,
                titleFont: { size: 13 },
                bodyFont: { size: 13 },
                cornerRadius: 8,
                displayColors: false
            }
        },
        scales: {
            y: { 
                grid: { borderDash: [4, 4], color: '#e2e8f0' },
                ticks: { color: '#64748b' }
            },
            x: {
                grid: { display: false },
                ticks: { color: '#64748b' }
            }
        },
        interaction: {
            intersect: false,
            mode: 'index',
        },
    }
});
</script>
@endpush
