@extends('layouts.app')

@section('title', 'Tambah User')

@section('content')

<style>
    /* =========================================================
       TAMBAH USER — LIGHT / DARK MODE
       Hanya visual halaman Tambah User.
       Tidak mengubah form, route, validation, atau backend.
    ========================================================= */

    .user-create-page {
        --uc-card: rgba(255, 255, 255, .96);
        --uc-text: #0B2545;
        --uc-muted: #64748B;
        --uc-label: #334155;
        --uc-border: #E2E8F0;
        --uc-input: #FFFFFF;
        --uc-input-text: #0F172A;
        --uc-placeholder: #94A3B8;
    }

    .user-create-page .card {
        background: var(--uc-card);
        border-color: var(--uc-border);
        color: var(--uc-text);
    }

    .user-create-page h1 {
        color: var(--uc-text);
    }

    .user-create-page .create-subtitle {
        color: var(--uc-muted);
    }

    .user-create-page label {
        color: var(--uc-label) !important;
    }

    .user-create-page .input {
        background: var(--uc-input) !important;
        color: var(--uc-input-text) !important;
        border-color: var(--uc-border) !important;
    }

    .user-create-page .input::placeholder {
        color: var(--uc-placeholder) !important;
    }

    .user-create-page .input:focus {
        border-color: #123F7A !important;
        box-shadow: 0 0 0 3px rgba(18, 63, 122, .12) !important;
    }

    .user-create-page .create-help {
        color: #94A3B8 !important;
    }

    .user-create-page .create-divider {
        border-color: var(--uc-border) !important;
    }

    /* =========================
       DARK MODE
    ========================= */

    html.dark-theme .user-create-page {
        --uc-card: rgba(8, 29, 50, .96);
        --uc-text: #F1F5F9;
        --uc-muted: #A8B7C9;
        --uc-label: #DCE7F2;
        --uc-border: rgba(148, 163, 184, .24);
        --uc-input: rgba(4, 22, 39, .92);
        --uc-input-text: #F1F5F9;
        --uc-placeholder: #71859C;
    }

    html.dark-theme .user-create-page .card {
        background: var(--uc-card) !important;
        border-color: var(--uc-border) !important;
        color: var(--uc-text) !important;
        box-shadow: 0 20px 55px rgba(0, 0, 0, .25);
    }

    html.dark-theme .user-create-page h1 {
        color: #F1F5F9 !important;
    }

    html.dark-theme .user-create-page .create-subtitle {
        color: #A8B7C9 !important;
    }

    html.dark-theme .user-create-page label {
        color: #DCE7F2 !important;
    }

    html.dark-theme .user-create-page .input {
        background: rgba(4, 22, 39, .92) !important;
        color: #F1F5F9 !important;
        border-color: rgba(148, 163, 184, .28) !important;
    }

    html.dark-theme .user-create-page .input:focus {
        border-color: #5D8FCB !important;
        box-shadow: 0 0 0 3px rgba(93, 143, 203, .16) !important;
    }

    html.dark-theme .user-create-page .input::placeholder {
        color: #71859C !important;
    }

    html.dark-theme .user-create-page .create-help {
        color: #8FA3B8 !important;
    }

    html.dark-theme .user-create-page .create-divider {
        border-color: rgba(148, 163, 184, .18) !important;
    }

    html.dark-theme .user-create-page select option {
        background: #081D32 !important;
        color: #F1F5F9 !important;
    }

    html.dark-theme .user-create-page .bg-red-50 {
        background: rgba(127, 29, 29, .20) !important;
        border-color: rgba(248, 113, 113, .25) !important;
        color: #FCA5A5 !important;
    }
</style>

<div class="user-create-page space-y-5">
    @include('pengaturan._tabs')

    <div class="card p-6">
        <div class="mb-6">
            <h1 class="text-xl font-bold text-slate-800">Tambah User</h1>
            <p class="create-subtitle mt-1 text-sm">Buat akun Admin Kantor atau Admin Gudang.</p>
        </div>

        @if($errors->any())
            <div class="mb-5 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                <ul class="list-disc space-y-1 pl-5">
                    @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('pengaturan.users.store') }}" class="space-y-5" id="user-form">
            @csrf
            @include('pengaturan.users._form', ['mode' => 'create'])
        </form>
    </div>
</div>
@endsection
