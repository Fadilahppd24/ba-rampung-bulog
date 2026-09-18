@extends('layouts.app')

@section('title','Dashboard')

@section('content')

<div class="space-y-6">


{{-- HEADER --}}
<div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5">


<div>
<h1 class="text-3xl font-bold text-gray-900">
Selamat Datang, {{ auth()->user()->name }}!
</h1>

<p class="text-gray-500 mt-1">
Pantau dan kelola data BA Rampung dengan lebih mudah dan cepat.
</p>

</div>



<form method="GET">

<div class="flex items-center gap-3">

<span class="text-sm text-gray-500">
📅 Tahun
</span>


<select
name="tahun"
onchange="this.form.submit()"
class="
rounded-xl
border-gray-200
shadow-sm
px-4
py-2
text-sm
bg-white
">

@for($i=date('Y');$i>=date('Y')-5;$i--)

<option
value="{{ $i }}"
@selected($tahun==$i)
>
{{ $i }}
</option>

@endfor


</select>


</div>

</form>


</div>





{{-- KPI --}}

<div class="
grid
grid-cols-1
sm:grid-cols-2
xl:grid-cols-4
gap-5
">


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






{{-- CHART AREA --}}

<div class="
grid
grid-cols-1
xl:grid-cols-3
gap-6
">



{{-- BAR CHART --}}

<div class="
bg-white
rounded-2xl
border
border-gray-100
shadow-sm
p-6
xl:col-span-2
">


<div class="flex justify-between items-center mb-5">


<h3 class="font-bold text-gray-900">
📊 Rekap BA Rampung per Bulan ({{ $tahun }})
</h3>


</div>



<div class="h-[330px]">

<canvas id="chartPerBulan"></canvas>

</div>


</div>







{{-- DONUT --}}

<div
class="
bg-white
rounded-2xl
border
border-gray-100
shadow-sm
p-6
">


<h3 class="font-bold text-gray-900 mb-5">
📦 Distribusi Pergudangan
</h3>



<div class="relative h-[260px]">


<canvas id="chartGudang"></canvas>



<div
class="
absolute
inset-0
flex
items-center
justify-center
pointer-events-none
">

<div class="text-center">

<p class="text-3xl font-bold text-gray-900">
{{ $kpi['total_ba'] }}
</p>

<p class="text-xs text-gray-500">
BA Rampung
</p>

</div>

</div>


</div>






<div class="mt-5 space-y-3">


@foreach($distribusiGudang as $d)


<div class="
flex
justify-between
text-sm
">


<div class="flex gap-2 items-center">


<span class="
w-2
h-2
rounded-full
bg-bulog-600
"></span>


<span class="text-gray-600">
{{ $d->nama_gudang }}
</span>


</div>



<span class="font-semibold">
{{ $d->jumlah }}
</span>



</div>



@endforeach


</div>



</div>


</div>






{{-- DATA BAWAH --}}

<div class="
grid
grid-cols-1
xl:grid-cols-2
gap-6
">



{{-- BA TERBARU --}}

<div class="
bg-white
rounded-2xl
shadow-sm
border
p-6
">


<div class="
flex
justify-between
mb-5
">

<h3 class="font-bold">
🧾 BA Rampung Terbaru
</h3>


<a
href="{{route('ba-rampung.index')}}"
class="text-sm text-blue-600"
>
Lihat Semua →
</a>

</div>



<div class="overflow-x-auto">

<table class="w-full text-sm">


<thead>

<tr class="bg-gray-50 text-gray-600">

<th class="p-3 text-left">
No
</th>


<th class="p-3 text-left">
Nomor BA
</th>


<th class="p-3 text-left">
Gudang
</th>


<th class="p-3 text-left">
Status
</th>


</tr>

</thead>



<tbody>


@foreach($baTerbaru as $key=>$ba)


<tr class="border-b">


<td class="p-3">
{{$key+1}}
</td>


<td class="p-3 font-medium">
{{$ba->nomor_ba}}
</td>


<td class="p-3">
{{$ba->gudang->nama_gudang ?? '-'}}
</td>


<td class="p-3">

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






{{-- AKTIVITAS --}}

<div
class="
bg-white
rounded-2xl
shadow-sm
border
p-6
">


<h3 class="font-bold mb-5">
🕒 Aktivitas Terbaru
</h3>



<div class="space-y-5">


@foreach($aktivitasTerbaru as $log)


<div class="flex gap-3">


<span class="
mt-2
w-3
h-3
rounded-full
bg-blue-500
"></span>



<div>


<p class="text-sm">

<b>
{{$log->user->name ?? 'System'}}
</b>

{{$log->aktivitas}}

</p>


<p class="text-xs text-gray-400">

{{$log->created_at->diffForHumans()}}

</p>


</div>


</div>


@endforeach



</div>


</div>


</div>





</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

document.addEventListener('DOMContentLoaded', function(){


    // ==========================
    // BAR CHART BA PER BULAN
    // ==========================

    const chartPerBulan = document.getElementById('chartPerBulan');


    if(chartPerBulan){

        new Chart(chartPerBulan, {

            type:'bar',

            data:{

                labels:@json(
                    collect($perBulan)->pluck('bulan')
                ),

                datasets:[{

                    label:'Jumlah BA',

                    data:@json(
                        collect($perBulan)->pluck('jumlah')
                    ),


                    backgroundColor:'#1F4732',

                    borderRadius:10,

                    barThickness:25

                }]

            },


            options:{


                responsive:true,

                maintainAspectRatio:false,


                plugins:{

                    legend:{
                        display:false
                    }

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


    }





    // ==========================
    // DONUT GUDANG
    // ==========================


    const chartGudang =
        document.getElementById('chartGudang');



    if(chartGudang){


        new Chart(chartGudang,{


            type:'doughnut',



            data:{


                labels:@json(
                    $distribusiGudang->pluck('nama_gudang')
                ),



                datasets:[{


                    data:@json(
                        $distribusiGudang->pluck('jumlah')
                    ),



                    backgroundColor:[

                        '#1F4732',
                        '#3D7A5A',
                        '#F5B83D',
                        '#2563EB',
                        '#EF4444'

                    ],



                    borderWidth:0


                }]


            },



            options:{


                responsive:true,

                maintainAspectRatio:false,


                cutout:'70%',



                plugins:{


                    legend:{


                        display:false


                    }


                }



            }



        });


    }



});


</script>

@endsection