@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')


{{-- KPI CARD --}}
<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 mb-6">

    <x-kpi-card 
        icon="📋"
        label="Total BA Rampung"
        :value="number_format($kpi['total_ba'])"
    />

    <x-kpi-card 
        icon="🏠"
        label="Gudang Aktif"
        :value="number_format($kpi['gudang_aktif'])"
    />

    <x-kpi-card 
        icon="🤝"
        label="Mitra Pengolahan"
        :value="number_format($kpi['mitra_pengolahan'])"
    />

    <x-kpi-card 
        icon="✅"
        label="Penyaluran Berjalan"
        :value="number_format($kpi['penyaluran_berjalan'])"
        sub="Menunggu verifikasi"
    />

</div>




{{-- GRAFIK --}}
<div class="grid grid-cols-1 xl:grid-cols-3 gap-5 mb-6">


    {{-- Grafik BA --}}
    <div class="card p-6 xl:col-span-2">


        <div class="flex items-center gap-2 mb-5">

            <span>
                📊
            </span>

            <h3 class="font-semibold text-gray-900">
                Rekap BA Rampung per Bulan ({{ $tahun }})
            </h3>

        </div>



        <div class="relative h-[300px]">

            <canvas id="chartPerBulan"></canvas>

        </div>


    </div>





    {{-- Distribusi Gudang --}}
    <div class="card p-6">


        <div class="flex items-center gap-2 mb-5">

            <span>
                📦
            </span>

            <h3 class="font-semibold text-gray-900">
                Distribusi Pergudangan
            </h3>

        </div>




        @if ($distribusiGudang->isEmpty())


            <p class="text-sm text-gray-500">
                Belum ada data BA Rampung.
            </p>


        @else


        <div class="space-y-5">


            @foreach($distribusiGudang as $d)


            @php

            $persen = $distribusiGudang->max('jumlah') > 0
            ?
            ($d->jumlah / $distribusiGudang->max('jumlah')) * 100
            :
            0;

            @endphp



            <div>


                <div class="flex justify-between mb-2 text-sm">

                    <span class="text-gray-700">
                        {{ $d->nama_gudang }}
                    </span>


                    <span class="font-semibold text-gray-900">
                        {{ $d->jumlah }}
                    </span>


                </div>



                <div class="h-2 bg-gray-100 rounded-full overflow-hidden">


                    <div
                        class="h-full bg-[#D9A441] rounded-full"
                        style="width: {{ $persen }}%"
                    ></div>


                </div>


            </div>


            @endforeach


        </div>


        @endif


    </div>


</div>






{{-- DATA BAWAH --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-5 mb-6">


    {{-- BA TERBARU --}}
    <div class="card p-6">


        <div class="flex justify-between items-center mb-5">

            <h3 class="font-semibold text-gray-900">
                🧾 BA Rampung Terbaru
            </h3>


            <a 
            href="{{ route('ba-rampung.index') }}"
            class="text-sm text-bulog-700 hover:underline">
                Lihat Semua →
            </a>


        </div>




        @if($baTerbaru->isEmpty())


        <p class="text-center text-gray-500 py-6">
            Belum ada data BA Rampung.
        </p>



        @else



        <div class="divide-y divide-gray-100">


            @foreach($baTerbaru as $ba)


            <a
            href="{{ route('ba-rampung.show',$ba) }}"
            class="flex items-center justify-between py-3 hover:bg-gray-50 rounded-lg px-2"
            >


                <div>


                    <p class="text-sm font-semibold text-gray-900">
                        {{ $ba->nomor_ba }}
                    </p>


                    <p class="text-xs text-gray-500">
                        {{ $ba->gudang->nama_gudang }}
                        ·
                        {{ $ba->mitraPengolahan->nama_mitra }}
                    </p>


                </div>



                <x-status-badge 
                    :color="$ba->statusBadgeColor()"
                    :label="$ba->statusLabel()"
                />


            </a>


            @endforeach


        </div>



        @endif


    </div>






    {{-- AKTIVITAS --}}
    <div class="card p-6">


        <h3 class="font-semibold text-gray-900 mb-5">
            🕒 Aktivitas Terbaru
        </h3>




        @if($aktivitasTerbaru->isEmpty())


        <p class="text-center text-gray-500 py-6">
            Belum ada aktivitas tercatat.
        </p>



        @else



        <div class="space-y-5">


        @foreach($aktivitasTerbaru as $log)


            <div class="flex gap-3">


                <span class="mt-2 h-2 w-2 rounded-full bg-bulog-600"></span>


                <div>


                    <p class="text-sm text-gray-800">

                        <b>
                        {{ $log->user->name ?? 'Sistem' }}
                        </b>

                        — {{ $log->aktivitas }}

                    </p>


                    <p class="text-xs text-gray-400">
                        {{ $log->created_at->diffForHumans() }}
                    </p>


                </div>


            </div>


        @endforeach


        </div>


        @endif


    </div>


</div>





{{-- AKSI CEPAT --}}
<div class="card p-6">


<h3 class="font-semibold text-gray-900 mb-4">
    ⚡ Aksi Cepat
</h3>



<div class="flex gap-3 flex-wrap">


@can('create', \App\Models\BaRampung::class)

<a href="{{ route('ba-rampung.create') }}"
class="btn-primary">
➕ Buat BA Rampung
</a>

@endcan



<a href="{{ route('ba-rampung.index') }}"
class="btn-secondary">
📄 Lihat Daftar BA
</a>


</div>


</div>



@endsection






<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.4/chart.umd.min.js"></script>


<script>


const bulanLabels = @json(collect($perBulan)->pluck('bulan'));

const bulanData = @json(collect($perBulan)->pluck('jumlah'));



new Chart(document.getElementById('chartPerBulan'), {


type:'bar',


data:{


labels:bulanLabels,


datasets:[{

label:'Jumlah BA',

data:bulanData,

backgroundColor:'#D9A441',

borderRadius:8,

barThickness:25

}]


},



options:{


responsive:true,

maintainAspectRatio:false,


plugins:{


legend:{display:false}


},



scales:{


y:{


beginAtZero:true,


ticks:{


precision:0


}


}



}



}


});



</script>