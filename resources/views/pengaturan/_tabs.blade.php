@php
    $tabs = [
        'pengaturan.umum' => ['label' => 'Pengaturan Umum', 'icon' => '🏢'],
        'pengaturan.sistem' => ['label' => 'Pengaturan Sistem', 'icon' => '⚙️'],
        'pengaturan.backup' => ['label' => 'Backup & Restore', 'icon' => '💾'],
        'pengaturan.log-aktivitas' => ['label' => 'Log Aktivitas', 'icon' => '🕒'],
    ];
@endphp

<div class="card p-2 flex flex-wrap gap-1">
    @foreach ($tabs as $route => $tab)
        <a href="{{ route($route) }}"
           class="flex-1 min-w-[140px] text-center rounded-lg px-3 py-2.5 text-sm font-medium transition-colors {{ request()->routeIs($route) ? 'bg-bulog-700 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
            {{ $tab['icon'] }} {{ $tab['label'] }}
        </a>
    @endforeach
</div>
