@props(['icon' => '📊', 'label' => '', 'value' => '', 'sub' => null, 'accent' => 'bulog'])

<div class="card p-5 flex items-start gap-4">
    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-bulog-cream text-lg">
        {{ $icon }}
    </div>
    <div class="min-w-0">
        <p class="text-sm text-gray-500">{{ $label }}</p>
        <p class="text-2xl font-semibold text-gray-900 mt-0.5">{{ $value }}</p>
        @if ($sub)
            <p class="text-xs text-gray-500 mt-1">{{ $sub }}</p>
        @endif
    </div>
</div>
