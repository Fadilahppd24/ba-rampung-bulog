@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
    <x-kpi-card icon="📋" label="Total BA Rampung" :value="number_format($kpi['total_ba'])" />
    <x-kpi-card icon="🏠" label="Gudang Aktif" :value="number_format($kpi['gudang_aktif'])" />
    <x-kpi-card icon="🤝" label="Mitra Pengolahan" :value="number_format($kpi['mitra_pengolahan'])" />
    <x-kpi-card icon="✅" label="Penyaluran Berjalan" :value="number_format($kpi['penyaluran_berjalan'])" sub="Menunggu verifikasi" />
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
    <div class="card p-5 lg:col-span-2">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-semibold text-gray-900">📊 Rekap BA Rampung per Bulan ({{ $tahun }})</h3>
        </div>
        <canvas id="chartPerBulan" height="110"></canvas>
    </div>

    <div class="card p-5">
        <h3 class="font-semibold text-gray-900 mb-4">📦 Distribusi Pergudangan</h3>
        @if ($distribusiGudang->isEmpty())
            <p class="text-sm text-gray-500">Belum ada data BA Rampung.</p>
        @else
            <canvas id="chartGudang" height="180"></canvas>
            <div class="mt-4 space-y-1.5">
                @foreach ($distribusiGudang as $d)
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-gray-600">{{ $d->nama_gudang }}</span>
                        <span class="font-medium text-gray-900">{{ $d->jumlah }}</span>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
    <div class="card p-5">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-semibold text-gray-900">🧾 BA Rampung Terbaru</h3>
            <a href="{{ route('ba-rampung.index') }}" class="text-sm text-bulog-700 hover:underline">Lihat Semua →</a>
        </div>

        @if ($baTerbaru->isEmpty())
            <p class="text-sm text-gray-500 py-6 text-center">Belum ada data BA Rampung.</p>
        @else
            <div class="divide-y divide-gray-100">
                @foreach ($baTerbaru as $ba)
                    <a href="{{ route('ba-rampung.show', $ba) }}" class="flex items-center justify-between py-3 hover:bg-gray-50 -mx-2 px-2 rounded-lg">
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ $ba->nomor_ba }}</p>
                            <p class="text-xs text-gray-500">{{ $ba->gudang->nama_gudang }} · {{ $ba->mitraPengolahan->nama_mitra }}</p>
                        </div>
                        <x-status-badge :color="$ba->statusBadgeColor()" :label="$ba->statusLabel()" />
                    </a>
                @endforeach
            </div>
        @endif
    </div>

    <div class="card p-5">
        <h3 class="font-semibold text-gray-900 mb-4">🕒 Aktivitas Terbaru</h3>
        @if ($aktivitasTerbaru->isEmpty())
            <p class="text-sm text-gray-500 py-6 text-center">Belum ada aktivitas tercatat.</p>
        @else
            <div class="space-y-4">
                @foreach ($aktivitasTerbaru as $log)
                    <div class="flex gap-3 text-sm">
                        <span class="mt-0.5 h-2 w-2 shrink-0 rounded-full bg-bulog-600"></span>
                        <div>
                            <p class="text-gray-800">
                                <span class="font-medium">{{ $log->user->name ?? 'Sistem' }}</span>
                                — {{ $log->aktivitas }}
                            </p>
                            <p class="text-xs text-gray-400">{{ $log->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

<div class="card p-5">
    <h3 class="font-semibold text-gray-900 mb-4">⚡ Aksi Cepat</h3>
    <div class="flex flex-wrap gap-3">
        @can('create', \App\Models\BaRampung::class)
            <a href="{{ route('ba-rampung.create') }}" class="btn-primary">➕ Buat BA Rampung</a>
        @endcan
        <a href="{{ route('ba-rampung.index') }}" class="btn-secondary">📄 Lihat Daftar BA</a>
    </div>
</div>

@endsection

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.4/chart.umd.min.js"></script>
<script>
    const bulanLabels = @json(collect($perBulan)->pluck('bulan'));
    const bulanData = @json(collect($perBulan)->pluck('jumlah'));

    new Chart(document.getElementById('chartPerBulan'), {
        type: 'bar',
        data: {
            labels: bulanLabels,
            datasets: [{
                label: 'Jumlah BA',
                data: bulanData,
                backgroundColor: '#1F4732',
                borderRadius: 6,
                maxBarThickness: 28,
            }],
        },
        options: {
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true, ticks: { precision: 0 } } },
        },
    });

    @if ($distribusiGudang->isNotEmpty())
    new Chart(document.getElementById('chartGudang'), {
        type: 'doughnut',
        data: {
            labels: @json($distribusiGudang->pluck('nama_gudang')),
            datasets: [{
                data: @json($distribusiGudang->pluck('jumlah')),
                backgroundColor: ['#1F4732', '#3D7A5A', '#EFE7D3', '#92650A', '#B42318', '#9CA3AF'],
                borderWidth: 0,
            }],
        },
        options: { plugins: { legend: { display: false } }, cutout: '65%' },
    });
    @endif
</script>
