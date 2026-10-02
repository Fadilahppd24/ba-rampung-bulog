@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

{{-- =====================================================
     Font & style Dashboard sudah dipindahkan ke
     resources/css/app.css (bagian 'DASHBOARD DESIGN
     SYSTEM'). Tampilan halaman ini tidak berubah.
===================================================== --}}

<div class="dashboard-page w-full max-w-none space-y-7 overflow-x-hidden">

    {{-- =====================================================
        HERO
    ====================================================== --}}
<section class="hero-dashboard w-full max-w-none overflow-hidden">

    <img
        src="{{ asset('images/dashboard-bulog.jpg') }}"
        alt="Gudang BULOG"
        class="hero-dashboard-image absolute inset-0 h-full w-full object-cover"
    >

    <div class="hero-dashboard-overlay"></div>

    <div class="hero-content p-7 sm:p-10 lg:p-12">

            <div class="hero-copy">

                <div class="dashboard-kicker text-white/75 mb-4">
                    Sistem BA Rampung
                </div>

                <h1
                    class="dashboard-display text-white text-5xl sm:text-6xl lg:text-[4.75rem] xl:text-[5.1rem] leading-[.88] font-normal"
                >
                    Mengelola Data,
                    <br>

                    <span class="orange-text">
                        Menguatkan Ketahanan Pangan.
                    </span>
                </h1>

                <p class="mt-6 text-white/80 text-sm sm:text-base max-w-2xl leading-7">
                    Pantau dan kelola proses pengolahan gabah menjadi beras
                    hasil giling dengan lebih mudah, cepat, dan terintegrasi.
                </p>
            </div>




        </div>

    </section>


    {{-- =====================================================
        FILTER TAHUN
    ====================================================== --}}
    <div class="flex justify-end">

        <form method="GET">

            <div
                class="
                    flex items-center gap-3
                    rounded-full
                    bg-white
                    border border-slate-200
                    px-4 py-2
                    shadow-sm
                "
            >

                <span class="text-xs text-slate-500">
                    Tahun
                </span>

                <select
                    name="tahun"
                    onchange="this.form.submit()"
                    class="
                        border-0
                        outline-none
                        bg-transparent
                        text-sm
                        font-semibold
                        text-[#123F7A]
                        focus:ring-0
                    "
                >

                    @for($i=date('Y'); $i>=date('Y')-5; $i--)

                        <option
                            value="{{ $i }}"
                            @selected($tahun == $i)
                        >
                            {{ $i }}
                        </option>

                    @endfor

                </select>

            </div>

        </form>

    </div>


    {{-- =====================================================
        KPI
    ====================================================== --}}
    <section
        class="
            grid
            grid-cols-1
            sm:grid-cols-2
            xl:grid-cols-4
            gap-5
        "
    >

        {{-- TOTAL BA --}}
        <div class="glass-card rounded-3xl p-6">

            <div class="flex items-start justify-between">

                <div>

                    <p class="text-xs text-slate-500 uppercase tracking-wider">
                        Total BA Rampung
                    </p>

                    <p class="dashboard-display text-5xl font-semibold text-[#123F7A] mt-2">
                        {{ number_format($kpi['total_ba']) }}
                    </p>

                    <p class="text-xs text-slate-400 mt-2">
                        Dokumen terdaftar
                    </p>

                </div>

                <div class="kpi-icon bg-blue-50 text-[#123F7A]">
                    📄
                </div>

            </div>

        </div>


        {{-- GUDANG --}}
        <div class="glass-card rounded-3xl p-6">

            <div class="flex items-start justify-between">

                <div>

                    <p class="text-xs text-slate-500 uppercase tracking-wider">
                        Gudang Aktif
                    </p>

                    <p class="dashboard-display text-5xl font-semibold text-[#123F7A] mt-2">
                        {{ number_format($kpi['gudang_aktif']) }}
                    </p>

                    <p class="text-xs text-slate-400 mt-2">
                        Gudang terdaftar
                    </p>

                </div>

                <div class="kpi-icon bg-orange-50 text-orange-500">
                    🏠
                </div>

            </div>

        </div>


        {{-- MITRA --}}
        <div class="glass-card rounded-3xl p-6">

            <div class="flex items-start justify-between">

                <div>

                    <p class="text-xs text-slate-500 uppercase tracking-wider">
                        Mitra Pengolahan
                    </p>

                    <p class="dashboard-display text-5xl font-semibold text-[#123F7A] mt-2">
                        {{ number_format($kpi['mitra_pengolahan']) }}
                    </p>

                    <p class="text-xs text-slate-400 mt-2">
                        Mitra terdaftar
                    </p>

                </div>

                <div class="kpi-icon bg-blue-50 text-[#123F7A]">
                    🤝
                </div>

            </div>

        </div>


        {{-- PENYALURAN --}}
        <div class="glass-card rounded-3xl p-6">

            <div class="flex items-start justify-between">

                <div>

                    <p class="text-xs text-slate-500 uppercase tracking-wider">
                        Penyaluran Berjalan
                    </p>

                    <p class="dashboard-display text-5xl font-semibold text-[#123F7A] mt-2">
                        {{ number_format($kpi['penyaluran_berjalan']) }}
                    </p>

                    <p class="text-xs text-slate-400 mt-2">
                        Menunggu verifikasi
                    </p>

                </div>

                <div class="kpi-icon bg-orange-50 text-orange-500">
                    ✓
                </div>

            </div>

        </div>

    </section>


    {{-- =====================================================
        CHART AREA
    ====================================================== --}}
    <section
        class="
            grid
            grid-cols-1
            xl:grid-cols-3
            gap-6
            w-full
            min-w-0
        "
    >

        {{-- BAR CHART --}}
        <div
            class="
                soft-card
                rounded-3xl
                p-6
                xl:col-span-2
                chart-card
            "
        >

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">

                <div>

                    <p class="dashboard-kicker text-[#123F7A]">
                        Statistik
                    </p>

                    <h2
                        class="
                            dashboard-display
                            text-3xl
                            text-[#123F7A]
                            font-semibold
                        "
                    >
                        Rekap BA Rampung
                    </h2>

                    <p class="text-xs text-slate-400 mt-1">
                        Per bulan tahun {{ $tahun }}
                    </p>

                </div>

            </div>

            <div class="h-[330px]">

                <canvas id="chartPerBulan"></canvas>

            </div>

        </div>


        {{-- DONUT --}}
        <div
            class="
                soft-card
                rounded-3xl
                p-6
                chart-card
            "
        >

            <div>

                <p class="dashboard-kicker text-[#123F7A]">
                    Distribusi
                </p>

                <h2
                    class="
                        dashboard-display
                        text-3xl
                        text-[#123F7A]
                        font-semibold
                    "
                >
                    Pergudangan
                </h2>

                <p class="text-xs text-slate-400 mt-1">
                    Distribusi BA berdasarkan gudang
                </p>

            </div>


            <div class="relative h-[260px] mt-4">

                <canvas id="chartGudang"></canvas>

                <div
                    class="
                        absolute
                        inset-0
                        flex
                        items-center
                        justify-center
                        pointer-events-none
                    "
                >

                    <div class="text-center">

                        <p
                            class="
                                dashboard-display
                                text-5xl
                                font-semibold
                                text-[#123F7A]
                            "
                        >
                            {{ $kpi['total_ba'] }}
                        </p>

                        <p class="text-xs text-slate-500">
                            BA Rampung
                        </p>

                    </div>

                </div>

            </div>


            <div class="mt-5 space-y-3">

                @foreach($distribusiGudang as $d)

                    <div
                        class="
                            flex
                            justify-between
                            items-center
                            text-sm
                            py-1
                        "
                    >

                        <div class="flex items-center gap-2">

                            <span
                                class="
                                    w-2
                                    h-2
                                    rounded-full
                                    bg-[#123F7A]
                                "
                            ></span>

                            <span class="text-slate-600">
                                {{ $d->nama_gudang }}
                            </span>

                        </div>

                        <span class="font-semibold text-[#123F7A]">
                            {{ $d->jumlah }}
                        </span>

                    </div>

                @endforeach

            </div>

        </div>

    </section>


    {{-- =====================================================
        DATA BAWAH
    ====================================================== --}}
    <section
        class="
            grid
            grid-cols-1
            xl:grid-cols-3
            gap-6
            w-full
            min-w-0
        "
    >

        {{-- BA TERBARU --}}
        <div
            class="
                soft-card
                rounded-3xl
                p-6
                xl:col-span-2
            "
        >

            <div class="flex items-center justify-between mb-5">

                <div>

                    <p class="dashboard-kicker text-[#123F7A]">
                        Aktivitas
                    </p>

                    <h2
                        class="
                            dashboard-display
                            text-3xl
                            font-semibold
                            text-[#123F7A]
                        "
                    >
                        BA Rampung Terbaru
                    </h2>

                </div>

                <a
                    href="{{ route('ba-rampung.index') }}"
                    class="
                        text-sm
                        font-semibold
                        text-[#123F7A]
                        hover:text-orange-500
                        transition
                    "
                >
                    Lihat Semua →
                </a>

            </div>


            <div class="overflow-x-auto">

                <table class="w-full text-sm">

                    <thead>

                        <tr
                            class="
                                border-b
                                border-slate-100
                                text-[11px]
                                uppercase
                                tracking-wider
                                text-slate-400
                            "
                        >

                            <th class="py-3 text-left">
                                No
                            </th>

                            <th class="py-3 text-left">
                                Nomor BA
                            </th>

                            <th class="py-3 text-left">
                                Gudang
                            </th>

                            <th class="py-3 text-left">
                                Status
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @foreach($baTerbaru as $key => $ba)

                            <tr
                                class="
                                    activity-row
                                    border-b
                                    border-slate-50
                                    transition
                                "
                            >

                                <td class="py-4 text-slate-400">
                                    {{ $key + 1 }}
                                </td>

                                <td class="py-4 font-semibold text-[#123F7A]">
                                    {{ $ba->nomor_ba }}
                                </td>

                                <td class="py-4 text-slate-600">
                                    {{ $ba->gudang->nama_gudang ?? '-' }}
                                </td>

                                <td class="py-4">

                                    <x-status-badge
                                        :color="$ba->statusBadgeColor()"
                                        :label="$ba->statusLabel()"
                                    />

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>


        {{-- QUICK ACTION --}}
        <div
            class="
                soft-card
                rounded-3xl
                p-6
            "
        >

            <div>

                <p class="dashboard-kicker text-[#123F7A]">
                    Shortcut
                </p>

                <h2
                    class="
                        dashboard-display
                        text-3xl
                        font-semibold
                        text-[#123F7A]
                    "
                >
                    Quick Action
                </h2>

            </div>


            <div class="grid grid-cols-1 gap-3 mt-6">

                <a
                    href="{{ route('ba-rampung.create') }}"
                    class="
                        group
                        rounded-2xl
                        bg-[#123F7A]
                        text-white
                        p-4
                        flex
                        items-center
                        justify-between
                        hover:bg-[#0D315F]
                        transition
                    "
                >

                    <div class="flex items-center gap-3">

                        <span
                            class="
                                w-10
                                h-10
                                rounded-xl
                                bg-white/10
                                flex
                                items-center
                                justify-center
                            "
                        >
                            📄
                        </span>

                        <span>
                            <span class="block text-sm font-semibold">
                                Buat BA Rampung
                            </span>

                            <span class="block text-xs text-white/60 mt-1">
                                Buat dokumen baru
                            </span>
                        </span>

                    </div>

                    <span class="text-xl group-hover:translate-x-1 transition">
                        →
                    </span>

                </a>


                <a
                    href="{{ route('gudang.index') }}"
                    class="
                        rounded-2xl
                        border
                        border-slate-200
                        p-4
                        flex
                        items-center
                        gap-3
                        text-[#123F7A]
                        hover:border-[#123F7A]
                        hover:bg-blue-50
                        transition
                    "
                >

                    <span
                        class="
                            w-10
                            h-10
                            rounded-xl
                            bg-orange-50
                            flex
                            items-center
                            justify-center
                        "
                    >
                        🏠
                    </span>

                    <span>

                        <span class="block text-sm font-semibold">
                            Kelola Gudang
                        </span>

                        <span class="block text-xs text-slate-400 mt-1">
                            Master data gudang
                        </span>

                    </span>

                </a>


                <a
                    href="{{ route('mitra.index') }}"
                    class="
                        rounded-2xl
                        border
                        border-slate-200
                        p-4
                        flex
                        items-center
                        gap-3
                        text-[#123F7A]
                        hover:border-[#123F7A]
                        hover:bg-blue-50
                        transition
                    "
                >

                    <span
                        class="
                            w-10
                            h-10
                            rounded-xl
                            bg-blue-50
                            flex
                            items-center
                            justify-center
                        "
                    >
                        🤝
                    </span>

                    <span>

                        <span class="block text-sm font-semibold">
                            Kelola Mitra
                        </span>

                        <span class="block text-xs text-slate-400 mt-1">
                            Master data mitra
                        </span>

                    </span>

                </a>

            </div>


            {{-- TIPS --}}
            <div
                class="
                    mt-5
                    rounded-2xl
                    bg-orange-50
                    border
                    border-orange-100
                    p-4
                "
            >

                <div class="flex gap-3">

                    <div class="text-xl">
                        💡
                    </div>

                    <div>

                        <p class="text-sm font-semibold text-[#123F7A]">
                            Tips
                        </p>

                        <p class="text-xs text-slate-500 leading-5 mt-1">
                            Pastikan data gudang dan mitra selalu
                            diperbarui agar proses verifikasi lebih cepat.
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </section>


    {{-- =====================================================
        AKTIVITAS SISTEM
    ====================================================== --}}
    <section
        class="
            soft-card
            rounded-3xl
            p-6
        "
    >

        <div class="flex items-center justify-between mb-5">

            <div>

                <p class="dashboard-kicker text-[#123F7A]">
                    Sistem
                </p>

                <h2
                    class="
                        dashboard-display
                        text-3xl
                        font-semibold
                        text-[#123F7A]
                    "
                >
                    Aktivitas Terbaru
                </h2>

            </div>

        </div>


        <div class="space-y-1">

            @foreach($aktivitasTerbaru as $log)

                <div
                    class="
                        activity-row
                        flex
                        gap-4
                        items-start
                        rounded-2xl
                        p-4
                        transition
                    "
                >

                    <span
                        class="
                            mt-2
                            w-2
                            h-2
                            rounded-full
                            bg-orange-400
                            flex-shrink-0
                        "
                    ></span>

                    <div class="flex-1">

                        <p class="text-sm text-slate-700">

                            <b class="text-[#123F7A]">
                                {{ $log->user->name ?? 'System' }}
                            </b>

                            {{ $log->aktivitas }}

                        </p>

                        <p class="text-xs text-slate-400 mt-1">
                            {{ $log->created_at->diffForHumans() }}
                        </p>

                    </div>

                </div>

            @endforeach

        </div>

    </section>

</div>


{{-- =========================================================
    CHART.JS
    LOGIKA LAMA TETAP DIPERTAHANKAN
========================================================= --}}

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

document.addEventListener('DOMContentLoaded', function () {

    // ======================================================
    // BAR CHART BA PER BULAN
    // ======================================================

    const chartPerBulan =
        document.getElementById('chartPerBulan');

    if (chartPerBulan) {

        new Chart(chartPerBulan, {

            type: 'bar',

            data: {

                labels: @json(
                    collect($perBulan)->pluck('bulan')
                ),

                datasets: [{

                    label: 'Jumlah BA',

                    data: @json(
                        collect($perBulan)->pluck('jumlah')
                    ),

                    backgroundColor: '#123F7A',

                    borderRadius: 10,

                    barThickness: 25

                }]

            },

            options: {

                responsive: true,

                maintainAspectRatio: false,

                plugins: {

                    legend: {
                        display: false
                    }

                },

                scales: {

                    x: {

                        grid: {
                            display: false
                        },

                        ticks: {
                            font: {
                                family: 'Manrope'
                            }
                        }

                    },

                    y: {

                        beginAtZero: true,

                        ticks: {

                            precision: 0,

                            font: {
                                family: 'Manrope'
                            }

                        },

                        grid: {
                            color: 'rgba(18,63,122,.08)'
                        }

                    }

                }

            }

        });

    }


    // ======================================================
    // DONUT GUDANG
    // ======================================================

    const chartGudang =
        document.getElementById('chartGudang');

    if (chartGudang) {

        new Chart(chartGudang, {

            type: 'doughnut',

            data: {

                labels: @json(
                    $distribusiGudang->pluck('nama_gudang')
                ),

                datasets: [{

                    data: @json(
                        $distribusiGudang->pluck('jumlah')
                    ),

                    backgroundColor: [

                        '#123F7A',
                        '#2B67A5',
                        '#F59E0B',
                        '#4A90D9',
                        '#F97316'

                    ],

                    borderWidth: 0

                }]

            },

            options: {

                responsive: true,

                maintainAspectRatio: false,

                cutout: '70%',

                plugins: {

                    legend: {

                        display: false

                    }

                }

            }

        });

    }

});

</script>

@endsection