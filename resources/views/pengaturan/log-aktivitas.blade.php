@extends('layouts.app')

@section('title', 'Log Aktivitas')

@section('content')

@include('pengaturan._tabs')

<div class="card p-5">
    <form method="GET" action="{{ route('pengaturan.log-aktivitas') }}" class="flex flex-col sm:flex-row gap-3">
        <select name="modul" class="input sm:max-w-xs" onchange="this.form.submit()">
            <option value="">Semua Modul</option>
            @foreach ($modulOptions as $m)
                <option value="{{ $m }}" @selected(request('modul') === $m)>{{ ucfirst(str_replace('_', ' ', $m)) }}</option>
            @endforeach
        </select>
        <select name="user_id" class="input sm:max-w-xs" onchange="this.form.submit()">
            <option value="">Semua User</option>
            @foreach ($users as $u)
                <option value="{{ $u->id }}" @selected((string) request('user_id') === (string) $u->id)>{{ $u->name }}</option>
            @endforeach
        </select>
    </form>
</div>

<div class="card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-y border-gray-100 text-left text-gray-500">
                    <th class="px-5 py-3 font-medium">User</th>
                    <th class="px-5 py-3 font-medium">Aktivitas</th>
                    <th class="px-5 py-3 font-medium">Modul</th>
                    <th class="px-5 py-3 font-medium">Keterangan</th>
                    <th class="px-5 py-3 font-medium">Waktu</th>
                    <th class="px-5 py-3 font-medium">IP</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse ($logs as $log)
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-3 font-medium text-gray-900">{{ $log->user->name ?? 'Sistem' }}</td>
                        <td class="px-5 py-3 text-gray-700">{{ $log->aktivitas }}</td>
                        <td class="px-5 py-3 text-gray-600">{{ ucfirst(str_replace('_', ' ', $log->modul)) }}</td>
                        <td class="px-5 py-3 text-gray-500">{{ $log->keterangan ?? '-' }}</td>
                        <td class="px-5 py-3 text-gray-500">{{ $log->created_at->format('d/m/Y H:i') }}</td>
                        <td class="px-5 py-3 text-gray-400">{{ $log->ip_address ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-5 py-16 text-center text-gray-500">
                            <p class="text-3xl mb-2">🕒</p>
                            Belum ada aktivitas tercatat.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($logs->hasPages())
        <div class="p-5">{{ $logs->links() }}</div>
    @endif
</div>

@endsection
