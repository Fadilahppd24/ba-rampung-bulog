@extends('layouts.app')

@section('title', 'Log Aktivitas')

@section('content')

<style>

    /* Header Log Aktivitas — selaras dengan Manajemen User */
    .la-header {
        position: relative;
        overflow: hidden;
        min-height: 205px;
        border: 1px solid rgba(255,255,255,.18);
        border-top: 2px solid #F28C28;
        border-radius: 24px;
        padding: 30px 44px;
        background: linear-gradient(135deg, rgba(8,42,78,.86) 0%, rgba(18,67,116,.72) 48%, rgba(30,88,145,.52) 100%);
        box-shadow: 0 18px 45px rgba(5,25,48,.18), inset 0 1px 0 rgba(255,255,255,.10);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
    }
    .la-header::before {
        content: "";
        position: absolute;
        inset: 0;
        pointer-events: none;
        background: radial-gradient(circle at 88% 22%, rgba(242,140,40,.20) 0, rgba(242,140,40,.08) 16%, transparent 38%),
                    linear-gradient(90deg, rgba(7,34,62,.12), transparent 55%);
    }
    .la-header-content {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 24px;
        min-height: 140px;
    }
    .la-header-copy { min-width: 0; }
    .la-back {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        margin-bottom: 18px;
        color: rgba(235,243,252,.78);
        font-size: 12px;
        font-weight: 700;
        text-decoration: none;
        transition: .2s ease;
    }
    .la-back:hover { color: #fff; transform: translateX(-2px); }
    .la-kicker {
        margin-bottom: 5px;
        color: rgba(235,243,252,.82);
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .28em;
        text-transform: uppercase;
    }
    .la-title {
        margin: 0;
        color: #fff;
        font-family: Georgia, "Times New Roman", serif;
        font-size: clamp(42px, 4vw, 58px);
        line-height: .98;
        font-weight: 400;
        letter-spacing: -.035em;
    }
    .la-title-accent { color: #F28C28; }
    .la-subtitle {
        margin-top: 13px;
        color: rgba(239,246,255,.84);
        font-size: 14px;
        line-height: 1.5;
    }
    .la-status-card {
        flex-shrink: 0;
        min-width: 160px;
        padding: 12px 16px;
        border: 1px solid rgba(255,255,255,.12);
        border-radius: 16px;
        background: rgba(7,31,57,.30);
        box-shadow: inset 0 1px 0 rgba(255,255,255,.06);
        backdrop-filter: blur(8px);
    }
    .la-status-label {
        display: block;
        margin-bottom: 4px;
        color: rgba(224,235,247,.62);
        font-size: 9px;
        font-weight: 800;
        letter-spacing: .18em;
        text-transform: uppercase;
    }
    .la-status-value {
        display: flex;
        align-items: center;
        gap: 7px;
        color: #fff;
        font-size: 12px;
        font-weight: 700;
    }
    .la-status-value::before {
        content: "";
        width: 9px;
        height: 9px;
        flex-shrink: 0;
        border-radius: 50%;
        background: #34D399;
        box-shadow: 0 0 0 4px rgba(52,211,153,.12), 0 0 12px rgba(52,211,153,.35);
    }
    @media (max-width: 640px) {
        .la-header { min-height: 0; padding: 22px 20px; border-radius: 18px; }
        .la-header-content { min-height: 0; align-items: flex-start; flex-direction: column; }
        .la-title { font-size: 40px; }
        .la-status-card { width: 100%; }
    }

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

{{-- HEADER: mengikuti desain Manajemen User --}}
<section class="la-header">
    <div class="la-header-content">
        <div class="la-header-copy">
            <a href="{{ route('dashboard') }}" class="la-back">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 12H5"/>
                    <path d="M12 19l-7-7 7-7"/>
                </svg>
                Kembali ke Dashboard
            </a>
            <div class="la-kicker">PENGATURAN</div>
            <h1 class="la-title">Log <span class="la-title-accent">Aktivitas</span></h1>
            <p class="la-subtitle">Pantau riwayat aktivitas pengguna dan perubahan pada sistem.</p>
        </div>
        <div class="la-status-card">
            <span class="la-status-label">Status Data</span>
            <span class="la-status-value">Riwayat aktivitas tercatat</span>
        </div>
    </div>
</section>

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
