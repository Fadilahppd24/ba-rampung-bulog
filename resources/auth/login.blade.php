@extends('layouts.guest')

@section('title', 'Masuk')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4">
    <div class="w-full max-w-md">
        <div class="flex flex-col items-center mb-8">
            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-bulog-cream text-bulog-900 text-2xl font-bold mb-4">B</div>
            <h1 class="text-white text-xl font-semibold">bulog</h1>
            <p class="text-white/60 text-sm">Sistem Administrasi BA Rampung — Cabang Indramayu</p>
        </div>

        <div class="card p-8">
            <h2 class="text-lg font-semibold text-gray-900 mb-1">Masuk ke akun Anda</h2>
            <p class="text-sm text-gray-500 mb-6">Gunakan akun yang telah didaftarkan oleh Admin Sistem.</p>

            @if ($errors->any())
                <div class="rounded-xl bg-danger-bg text-danger-text px-4 py-3 text-sm mb-5">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.attempt') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="label" for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                           class="input" placeholder="nama@bulog.co.id">
                </div>

                <div>
                    <label class="label" for="password">Kata Sandi</label>
                    <input id="password" type="password" name="password" required class="input" placeholder="••••••••">
                </div>

                <label class="flex items-center gap-2 text-sm text-gray-600">
                    <input type="checkbox" name="remember" class="rounded border-gray-300 text-bulog-700 focus:ring-bulog-600">
                    Ingat saya
                </label>

                <button type="submit" class="btn-primary w-full">Masuk</button>
            </form>

            <div class="mt-6 rounded-lg bg-gray-50 p-4 text-xs text-gray-500 space-y-1">
                <p class="font-medium text-gray-600">Akun demo (seeder):</p>
                <p>Admin Gudang — admingudang@bulog.co.id / password</p>
                <p>Pimpinan Cabang — pimpinan@bulog.co.id / password</p>
                <p>Admin Sistem — adminsistem@bulog.co.id / password</p>
            </div>
        </div>

        <p class="text-center text-white/40 text-xs mt-6">© {{ date('Y') }} Perum BULOG Cabang Indramayu.</p>
    </div>
</div>
@endsection
