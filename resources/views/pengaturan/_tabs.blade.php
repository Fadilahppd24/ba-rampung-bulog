@php
    $tabs = [
        'pengaturan.umum' => ['label' => 'Pengaturan Umum', 'icon' => '🏢'],
        'pengaturan.sistem' => ['label' => 'Pengaturan Sistem', 'icon' => '⚙️'],
        'pengaturan.backup' => ['label' => 'Backup & Restore', 'icon' => '💾'],
        'pengaturan.log-aktivitas' => ['label' => 'Log Aktivitas', 'icon' => '🕒'],
    ];
@endphp

<div class="rounded-[1.25rem] border border-slate-200/80 bg-white/95 p-2 shadow-lg backdrop-blur-md">
    <div class="grid grid-cols-1 gap-1 sm:grid-cols-2 xl:grid-cols-4">
        @foreach ($tabs as $route => $tab)
            <a href="{{ route($route) }}"
               class="inline-flex items-center justify-center gap-2 rounded-xl px-4 py-3 text-sm font-semibold transition-all {{ request()->routeIs($route) ? 'bg-[#123F7A] text-white shadow-md' : 'text-slate-500 hover:bg-blue-50 hover:text-[#123F7A]' }}">
                <span>{{ $tab['icon'] }}</span>
                <span>{{ $tab['label'] }}</span>
            </a>
        @endforeach
    </div>
</div>
