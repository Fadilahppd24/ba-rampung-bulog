@extends('layouts.app')

@section('title', 'Log Aktivitas')

@section('content')

<style>
    /* =========================================================
       LOG AKTIVITAS — THEME AWARE
       Dark styles are ONLY active when html.dark-theme exists.
       Light mode intentionally falls back to the existing
       application's .card/.input/Tailwind styles.
       ========================================================= */

    html.dark-theme .log-aktivitas-page .log-card {
        background:
            linear-gradient(
                135deg,
                rgba(7, 29, 52, .90) 0%,
                rgba(8, 39, 68, .84) 52%,
                rgba(13, 57, 94, .72) 100%
            ) !important;
        border: 1px solid rgba(135, 184, 228, .20) !important;
        box-shadow:
            0 18px 48px rgba(0, 8, 20, .30),
            inset 0 1px 0 rgba(255,255,255,.05) !important;
        backdrop-filter: blur(20px) saturate(125%) !important;
        -webkit-backdrop-filter: blur(20px) saturate(125%) !important;
        color: #E8F1FA !important;
    }

    html.dark-theme .log-aktivitas-page .log-input {
        background:
            linear-gradient(
                135deg,
                rgba(5, 23, 42, .92),
                rgba(10, 43, 73, .84)
            ) !important;
        color: #F4F8FC !important;
        border-color: rgba(128, 178, 224, .24) !important;
    }

    html.dark-theme .log-aktivitas-page .log-input option {
        background: #0B2139 !important;
        color: #F4F8FC !important;
    }

    html.dark-theme .log-aktivitas-page .log-table-head {
        border-color: rgba(148, 163, 184, .18) !important;
        color: #AFC4D8 !important;
    }

    html.dark-theme .log-aktivitas-page .log-row {
        border-color: rgba(148, 163, 184, .13) !important;
    }

    html.dark-theme .log-aktivitas-page .log-row:hover {
        background: rgba(255,255,255,.045) !important;
    }

    html.dark-theme .log-aktivitas-page .log-user {
        color: #F1F6FB !important;
    }

    html.dark-theme .log-aktivitas-page .log-activity {
        color: #D4E2EF !important;
    }

    html.dark-theme .log-aktivitas-page .log-module {
        color: #B9D0E5 !important;
    }

    html.dark-theme .log-aktivitas-page .log-muted,
    html.dark-theme .log-aktivitas-page .log-empty {
        color: #94ABC0 !important;
    }

    html.dark-theme .log-aktivitas-page .log-pagination {
        border-top-color: rgba(148,163,184,.13) !important;
    }
</style>

<div class="log-aktivitas-page space-y-4">

@include('pengaturan._tabs')

<div class="card p-5 log-card">
    <form method="GET" action="{{ route('pengaturan.log-aktivitas') }}" class="flex flex-col sm:flex-row gap-3">
        <select name="modul" class="input log-input sm:max-w-xs" onchange="this.form.submit()">
            <option value="">Semua Modul</option>
            @foreach ($modulOptions as $m)
                <option value="{{ $m }}" @selected(request('modul') === $m)>{{ ucfirst(str_replace('_', ' ', $m)) }}</option>
            @endforeach
        </select>
        <select name="user_id" class="input log-input sm:max-w-xs" onchange="this.form.submit()">
            <option value="">Semua User</option>
            @foreach ($users as $u)
                <option value="{{ $u->id }}" @selected((string) request('user_id') === (string) $u->id)>{{ $u->name }}</option>
            @endforeach
        </select>
    </form>
</div>

<div class="card overflow-hidden log-card">
    <div class="overflow-x-auto">
        <table class="w-full text-sm log-table">
            <thead>
                <tr class="border-y border-gray-100 text-left text-gray-500 log-table-head">
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
                    <tr class="hover:bg-gray-50 log-row">
                        <td class="px-5 py-3 font-medium text-gray-900 log-user">{{ $log->user->name ?? 'Sistem' }}</td>
                        <td class="px-5 py-3 text-gray-700 log-activity">{{ $log->aktivitas }}</td>
                        <td class="px-5 py-3 text-gray-600 log-module">{{ ucfirst(str_replace('_', ' ', $log->modul)) }}</td>
                        <td class="px-5 py-3 text-gray-500 log-muted">{{ $log->keterangan ?? '-' }}</td>
                        <td class="px-5 py-3 text-gray-500 log-muted">{{ $log->created_at->format('d/m/Y H:i') }}</td>
                        <td class="px-5 py-3 text-gray-400 log-muted">{{ $log->ip_address ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-5 py-16 text-center text-gray-500 log-empty">
                            <p class="text-3xl mb-2">🕒</p>
                            Belum ada aktivitas tercatat.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($logs->hasPages())
        <div class="p-5 log-pagination">{{ $logs->links() }}</div>
    @endif
</div>

</div>

@endsection
