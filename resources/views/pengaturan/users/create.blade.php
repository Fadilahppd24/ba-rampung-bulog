@extends('layouts.app')

@section('title', 'Tambah User')

@section('content')
<div class="space-y-5">
    @include('pengaturan._tabs')

    <div class="card p-6">
        <div class="mb-6">
            <h1 class="text-xl font-bold text-slate-800">Tambah User</h1>
            <p class="mt-1 text-sm text-slate-500">Buat akun Admin Kantor atau Admin Gudang.</p>
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
