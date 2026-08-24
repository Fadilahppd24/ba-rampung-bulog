@props(['title' => 'Dashboard', 'breadcrumbs' => []])

<header class="sticky top-0 z-20 flex items-center justify-between border-b border-black/5 bg-white/95 backdrop-blur px-4 py-4 lg:px-8">
    <div class="flex items-center gap-3">
        <button @click="sidebarOpen = !sidebarOpen" class="rounded-lg p-2 hover:bg-gray-100 lg:hidden">
            <span class="text-xl">☰</span>
        </button>
        <div>
            <h1 class="text-xl font-semibold text-gray-900">{{ $title }}</h1>
            @if (count($breadcrumbs))
                <p class="text-xs text-gray-500 mt-0.5">
                    @foreach ($breadcrumbs as $crumb)
                        {{ $crumb }}@if (! $loop->last) <span class="mx-1">›</span> @endif
                    @endforeach
                </p>
            @endif
        </div>
    </div>

    <div class="flex items-center gap-4">
        <button class="relative rounded-lg p-2 hover:bg-gray-100">
            <span class="text-xl">🔔</span>
        </button>
        <div class="flex items-center gap-3">
            <div class="h-9 w-9 rounded-full bg-bulog-100 flex items-center justify-center text-bulog-800 font-semibold">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div class="hidden sm:block text-right">
                <p class="text-sm font-medium text-gray-900 leading-tight">{{ auth()->user()->name }}</p>
                <p class="text-xs text-gray-500">{{ auth()->user()->roleLabel() }}</p>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="text-xs text-gray-500 hover:text-bulog-700 underline decoration-dotted">Keluar</button>
            </form>
        </div>
    </div>
</header>
