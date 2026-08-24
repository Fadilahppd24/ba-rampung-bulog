@props(['color' => 'gray', 'label' => ''])

@php
    $classes = match ($color) {
        'green' => 'bg-success-bg text-success-text',
        'yellow' => 'bg-warning-bg text-warning-text',
        'red' => 'bg-danger-bg text-danger-text',
        'blue' => 'bg-info-bg text-info-text',
        default => 'bg-gray-100 text-gray-600',
    };
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-medium $classes"]) }}>
    <span class="h-1.5 w-1.5 rounded-full bg-current"></span>
    {{ $label }}
</span>
