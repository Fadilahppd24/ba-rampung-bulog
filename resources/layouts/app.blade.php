<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — Sistem BA Rampung BULOG Indramayu</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-bulog-cream/40 text-gray-900 antialiased" x-data="{ sidebarOpen: false }">

    <div class="flex min-h-screen">
        @include('components.sidebar')

        <div class="flex-1 flex flex-col min-w-0">
            <x-header :title="trim($__env->yieldContent('title', 'Dashboard'))" :breadcrumbs="$breadcrumbs ?? []" />

            <main class="flex-1 p-4 lg:p-8 space-y-6">
                @if (session('success'))
                    <div class="rounded-xl bg-success-bg text-success-text px-4 py-3 text-sm font-medium">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="rounded-xl bg-danger-bg text-danger-text px-4 py-3 text-sm">
                        <p class="font-medium mb-1">Terdapat kesalahan pada form:</p>
                        <ul class="list-disc list-inside space-y-0.5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

</body>
</html>
