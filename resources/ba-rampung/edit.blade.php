@extends('layouts.app')

@section('title', 'Edit BA Rampung')

@php
    $beras = $baRampung->produksis->firstWhere('produk_sesudah', 'Beras (HGL)');
    $menir = $baRampung->produksis->firstWhere('produk_sesudah', 'Menir');
    $bekatul = $baRampung->produksis->firstWhere('produk_sesudah', 'Bekatul');

    $gabahAwal = $beras->kuantum_sebelum ?? 0;
@endphp


@section('content')

<form method="POST"
      action="{{ route('ba-rampung.update', $baRampung) }}"
      x-data="baForm({
        gabah: {{ old('kuantum_gabah', $gabahAwal) }},
        beras: {{ old('kuantum_beras', $beras->kuantum_sesudah ?? 0) }},
        menir: {{ old('kuantum_menir', $menir->kuantum_sesudah ?? 0) }},
        bekatul: {{ old('kuantum_bekatul', $bekatul->kuantum_sesudah ?? 0) }},
        tanggal: '{{ old('tanggal_ba', $baRampung->tanggal_ba->toDateString()) }}'
      })"
      class="space-y-6">

@csrf
@method('PUT')


{{-- DATA BA --}}
<div class="card p-6">

<h3 class="font-semibold text-gray-900 mb-5">
📄 1. Data BA Rampung — {{ $baRampung->nomor_ba }}
</h3>


<div class="grid grid-cols-1 md:grid-cols-2 gap-5">

<div>
<label class="label">Nomor BA</label>

<input type="text"
disabled
value="{{ $baRampung->nomor_ba }}"
class="input bg-gray-50 text-gray-500">

</div>


<div class="grid grid-cols-3 gap-3">

<div>
<label class="label">Hari</label>

<input type="text"
:value="hariNama"
disabled
class="input bg-gray-50 text-gray-500">

</div>


<div>
<label class="label">Tanggal BA</label>

<input type="date"
name="tanggal_ba"
x-model="tanggal"
required
class="input">

</div>


<div>
<label class="label">Tahun</label>

<input type="text"
:value="tahunNama"
disabled
class="input bg-gray-50 text-gray-500">

</div>

</div>



<div>
<label class="label">
Nomor Manufacturing Order (MO)
</label>

<input type="text"
name="nomor_mo"
value="{{ old('nomor_mo',$baRampung->nomor_mo) }}"
class="input">

</div>


<div>
<label class="label">
Nomor Purchase Order (PO)
</label>

<input type="text"
name="nomor_po"
value="{{ old('nomor_po',$baRampung->nomor_po) }}"
class="input">

</div>


</div>

</div>




{{-- PRODUKSI --}}

<div class="card p-6">

<h3 class="font-semibold text-gray-900 mb-5">
🌾 2. Pengolahan Gabah (GKP) menjadi Beras HGL
</h3>


<table class="w-full text-sm">

<thead>

<tr class="bg-bulog-beige/60">

<th colspan="2">Sebelum</th>
<th colspan="2">Sesudah</th>
<th>Rendemen</th>

</tr>

</thead>


<tbody>


<tr>

<td class="px-4 py-3">
Gabah (GKP)
</td>


<td>

<input type="number"
step="0.01"
name="kuantum_gabah"
x-model.number="gabah"
required
class="input">

</td>


<td>
Beras (HGL)
</td>


<td>

<input type="number"
step="0.01"
name="kuantum_beras"
x-model.number="beras"
required
class="input">

</td>


<td x-text="rendemen(beras)+' %'"></td>


</tr>



<tr>

<td colspan="2"></td>

<td>
Menir
</td>


<td>

<input type="number"
step="0.01"
name="kuantum_menir"
x-model.number="menir"
class="input">

</td>


<td x-text="rendemen(menir)+' %'"></td>

</tr>




<tr>

<td colspan="2"></td>

<td>
Bekatul
</td>


<td>

<input type="number"
step="0.01"
name="kuantum_bekatul"
x-model.number="bekatul"
class="input">

</td>


<td x-text="rendemen(bekatul)+' %'"></td>


</tr>


</tbody>

</table>


</div>





{{-- PIHAK TERLIBAT --}}

<div class="card p-6">


<h3 class="font-semibold text-gray-900 mb-5">
🤝 3. Pihak Yang Terlibat
</h3>


<label class="label">
Pihak Kesatu (Gudang)
</label>


<select name="gudang_id"
class="input"
required>


@foreach($gudangs as $g)

<option value="{{ $g->id }}"
@selected(old('gudang_id',$baRampung->gudang_id)==$g->id)>
{{ $g->nama_gudang }}
</option>

@endforeach


</select>




<label class="label mt-4">
Pihak Kedua (Mitra Pengolahan)
</label>


<select name="mitra_pengolahan_id"
class="input"
required>


@foreach($mitras as $m)

<option value="{{ $m->id }}"
@selected(old('mitra_pengolahan_id',$baRampung->mitra_pengolahan_id)==$m->id)>
{{ $m->nama_mitra }}
</option>

@endforeach


</select>


</div>





{{-- PENANDATANGAN --}}

<div class="card p-6">


<h3 class="font-semibold text-gray-900 mb-5">
✍️ 4. Penandatangan Pihak Kesatu
</h3>


<label class="label">
Nama Penandatangan
</label>


<input type="text"
name="nama_penandatangan"
value="{{ old('nama_penandatangan',$baRampung->nama_penandatangan) }}"
required
class="input">



<label class="label mt-4">
Jabatan
</label>


<input type="text"
name="jabatan_penandatangan"
value="{{ old('jabatan_penandatangan',$baRampung->jabatan_penandatangan) }}"
required
class="input">


</div>





{{-- PIMPINAN --}}

<div class="card p-6">


<h3 class="font-semibold text-gray-900 mb-5">
👔 5. Mengetahui
</h3>


<label class="label">
Pimpinan Cabang BULOG
</label>


<select name="pimpinan_cabang_id"
class="input"
required>


@foreach($pimpinans as $p)

<option value="{{ $p->id }}"
@selected(old('pimpinan_cabang_id',$baRampung->pimpinan_cabang_id)==$p->id)>
{{ $p->nama }}
</option>

@endforeach


</select>


</div>





{{-- CATATAN --}}

<div class="card p-6">


<label class="label">
Catatan
</label>


<textarea name="catatan"
rows="3"
class="input">{{ old('catatan',$baRampung->catatan) }}</textarea>


</div>





<div class="flex justify-between">


<a href="{{route('ba-rampung.show',$baRampung)}}"
class="btn-secondary">
← Kembali
</a>



<div class="flex gap-3">


<button type="submit"
name="action"
value="draft"
class="btn-secondary">
💾 Simpan Draft
</button>


<button type="submit"
name="action"
value="submit"
class="btn-primary">
✅ Simpan & Kirim Verifikasi
</button>


</div>


</div>



</form>


@endsection