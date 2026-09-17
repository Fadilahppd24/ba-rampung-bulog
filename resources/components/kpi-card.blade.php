@props([
'icon',
'label',
'value',
'sub'=>null
])


<div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">

<div class="flex items-center gap-4">


<div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center text-xl">
{{ $icon }}
</div>


<div>

<p class="text-sm text-gray-500">
{{ $label }}
</p>


<h2 class="text-3xl font-bold text-gray-900">
{{ $value }}
</h2>


@if($sub)

<p class="text-xs text-yellow-600 mt-1">
{{ $sub }}
</p>

@endif


</div>


</div>

</div>