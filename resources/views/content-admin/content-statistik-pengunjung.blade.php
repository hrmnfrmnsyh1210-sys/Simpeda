@extends('layout-admin.main-layout-admin')

@section('title', 'Statistik Pengunjung')

@section('content')

    {{-- Header --}}
    <div class="mb-6">
        <div class="flex items-center gap-2 text-sm text-gray-500 mb-2">
            <a href="{{ route('admin.dashboard') }}" class="text-primary hover:underline">Dashboard</a>
            <i class="bi bi-chevron-right text-[10px]"></i>
            <span class="text-gray-400">Statistik Pengunjung</span>
        </div>
        <h1 class="font-grotesk text-2xl font-bold text-gray-800 tracking-tight">Statistik Pengunjung</h1>
        <p class="text-sm text-gray-500 mt-1">Jumlah pengunjung unik aplikasi (dihitung per sesi per hari).</p>
    </div>

    {{-- Kartu Ringkasan --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="bg-white p-4 rounded-radius border border-[#e2e8f0] shadow-sm flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center text-lg" style="background-color:#eef3ff; color:#1a56db;">
                <i class="bi bi-calendar-day"></i>
            </div>
            <div>
                <div class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Pengunjung Hari Ini</div>
                <div class="font-grotesk text-xl font-bold text-gray-800">{{ number_format($ringkasan['hari_ini']) }}</div>
            </div>
        </div>
        <div class="bg-white p-4 rounded-radius border border-[#e2e8f0] shadow-sm flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center text-lg" style="background-color:#f0fdf4; color:#16a34a;">
                <i class="bi bi-calendar-week"></i>
            </div>
            <div>
                <div class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Pengunjung Minggu Ini</div>
                <div class="font-grotesk text-xl font-bold text-gray-800">{{ number_format($ringkasan['minggu_ini']) }}</div>
            </div>
        </div>
        <div class="bg-white p-4 rounded-radius border border-[#e2e8f0] shadow-sm flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center text-lg" style="background-color:#fffbeb; color:#d97706;">
                <i class="bi bi-calendar-month"></i>
            </div>
            <div>
                <div class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Pengunjung Bulan Ini</div>
                <div class="font-grotesk text-xl font-bold text-gray-800">{{ number_format($ringkasan['bulan_ini']) }}</div>
            </div>
        </div>
    </div>

    {{-- Chart --}}
    <div class="bg-white rounded-radius border border-[#e2e8f0] shadow-sm p-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-5">
            <h3 class="font-bold text-sm text-gray-700 flex items-center gap-2">
                <i class="bi bi-graph-up text-primary"></i> Tren Kunjungan
            </h3>
            <div class="flex gap-1 bg-bg-base rounded-lg p-1 w-fit" id="periode-toggle">
                <button type="button" data-periode="harian" class="periode-btn px-3 py-1.5 rounded-md text-xs font-bold transition-all bg-primary text-white">Harian</button>
                <button type="button" data-periode="mingguan" class="periode-btn px-3 py-1.5 rounded-md text-xs font-bold transition-all text-gray-500">Mingguan</button>
                <button type="button" data-periode="bulanan" class="periode-btn px-3 py-1.5 rounded-md text-xs font-bold transition-all text-gray-500">Bulanan</button>
            </div>
        </div>
        <div style="height: 320px;">
            <canvas id="chart-pengunjung"></canvas>
        </div>
    </div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
<script>
    const datasetPengunjung = {
        harian: {
            labels: {!! json_encode($harian->pluck('label')) !!},
            data: {!! json_encode($harian->pluck('jumlah')) !!},
        },
        mingguan: {
            labels: {!! json_encode($mingguan->pluck('label')) !!},
            data: {!! json_encode($mingguan->pluck('jumlah')) !!},
        },
        bulanan: {
            labels: {!! json_encode($bulanan->pluck('label')) !!},
            data: {!! json_encode($bulanan->pluck('jumlah')) !!},
        },
    };

    const ctx = document.getElementById('chart-pengunjung');
    const chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: datasetPengunjung.harian.labels,
            datasets: [{
                label: 'Pengunjung',
                data: datasetPengunjung.harian.data,
                borderColor: '#1a56db',
                backgroundColor: 'rgba(26, 86, 219, 0.1)',
                tension: 0.3,
                fill: true,
                pointRadius: 3,
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true, ticks: { precision: 0 } } },
        },
    });

    document.querySelectorAll('.periode-btn').forEach((btn) => {
        btn.addEventListener('click', () => {
            const periode = btn.dataset.periode;

            document.querySelectorAll('.periode-btn').forEach((b) => {
                b.classList.remove('bg-primary', 'text-white');
                b.classList.add('text-gray-500');
            });
            btn.classList.add('bg-primary', 'text-white');
            btn.classList.remove('text-gray-500');

            chart.data.labels = datasetPengunjung[periode].labels;
            chart.data.datasets[0].data = datasetPengunjung[periode].data;
            chart.update();
        });
    });
</script>
@endpush
