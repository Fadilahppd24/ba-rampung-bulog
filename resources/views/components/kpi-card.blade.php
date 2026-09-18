@props([
    'icon' => '📊',
    'label' => '',
    'value' => '',
    'sub' => null
])


<div 
class="
bg-white
rounded-2xl
border
border-gray-100
shadow-sm
p-5
flex
items-center
gap-4
transition
duration-300
hover:shadow-md
hover:-translate-y-1
">


{{-- ICON --}}

<div
class="
h-14
w-14
shrink-0
rounded-2xl
bg-blue-50
flex
items-center
justify-center
text-2xl
"
>

{{ $icon }}

</div>




{{-- CONTENT --}}

<div class="min-w-0">


<p class="
text-sm
text-gray-500
font-medium
truncate
">

{{ $label }}

</p>



<p class="
text-3xl
font-bold
text-gray-900
mt-1
">

{{ $value }}

</p>



@if($sub)

<p class="
text-xs
text-gray-500
mt-1
">

{{ $sub }}

</p>

@endif



</div>



</div>