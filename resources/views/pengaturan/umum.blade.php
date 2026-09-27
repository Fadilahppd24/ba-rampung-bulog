@extends('layouts.app')

@section('title', 'Pengaturan Umum')

@section('content')

<div class="space-y-6 pb-8">

    {{-- HERO --}}
    <section class="relative overflow-hidden rounded-[2rem] min-h-[250px] shadow-xl">
        <img src="{{ asset('images/dashboard-bulog.jpg') }}" alt="Gudang BULOG" class="absolute inset-0 h-full w-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-r from-[#082F63]/85 via-[#123F7A]/55 to-[#082F63]/15"></div>
        <div class="relative z-10 flex min-h-[250px] items-end px-7 py-8 sm:px-10 lg:px-12">
            <div>
                <div class="dashboard-kicker text-white/80 mb-3">Pengaturan</div>
                <h1 class="dashboard-display text-white text-5xl sm:text-6xl lg:text-[4.5rem] leading-[.9] font-normal">
                    Pengaturan <span class="orange-text">Umum.</span>
                </h1>
                <p class="mt-4 max-w-2xl text-sm sm:text-base leading-7 text-white/80">
                    Kelola informasi dan konfigurasi dasar sistem BA Rampung.
                </p>
            </div>
        </div>
    </section>

    @include('pengaturan._tabs')

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-[minmax(0,1.35fr)_minmax(320px,.65fr)]">
        {{-- FORM --}}
        <form method="POST" action="{{ route('pengaturan.umum.update') }}" enctype="multipart/form-data" class="rounded-[1.5rem] border border-slate-200/80 bg-white/95 p-6 shadow-lg sm:p-7">
            @csrf

            <div class="mb-6">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50">🏢</div>
                    <div>
                        <h2 class="text-lg font-bold text-[#0B2545]">Informasi Cabang</h2>
                        <p class="text-sm text-slate-500">Kelola informasi dasar cabang BULOG.</p>
                    </div>
                </div>
            </div>

            <div class="space-y-5">
                <div>
                    <label class="mb-2 block text-xs font-bold uppercase tracking-wide text-slate-500">Nama Cabang</label>
                    <input type="text" name="nama_cabang" value="{{ old('nama_cabang', $pengaturan->nama_cabang) }}" required class="input w-full">
                </div>

                <div>
                    <label class="mb-2 block text-xs font-bold uppercase tracking-wide text-slate-500">Alamat Kantor</label>
                    <textarea name="alamat_kantor" rows="4" class="input w-full">{{ old('alamat_kantor', $pengaturan->alamat_kantor) }}</textarea>
                </div>

                <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-xs font-bold uppercase tracking-wide text-slate-500">Telepon</label>
                        <input type="text" name="telepon" value="{{ old('telepon', $pengaturan->telepon) }}" class="input w-full">
                    </div>
                    <div>
                        <label class="mb-2 block text-xs font-bold uppercase tracking-wide text-slate-500">Email</label>
                        <input type="email" name="email" value="{{ old('email', $pengaturan->email) }}" class="input w-full">
                    </div>
                </div>

                <div class="border-t border-slate-100 pt-5">
                    <label class="mb-2 block text-xs font-bold uppercase tracking-wide text-slate-500">Logo Cabang</label>
                    <div class="rounded-2xl border border-dashed border-slate-300 bg-[#F7F9FC] p-4">
                        <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
                            @if ($pengaturan->logo_path)
                                <img src="{{ \Illuminate\Support\Facades\Storage::url($pengaturan->logo_path) }}" alt="Logo" class="h-16 w-16 rounded-2xl border border-slate-200 bg-white object-contain p-2 shadow-sm">
                            @else
                                <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-[#123F7A] text-xl font-bold text-white">B</div>
                            @endif
                            <div class="min-w-0 flex-1">
                                <input type="file" name="logo" accept="image/*" class="input w-full bg-white">
                                <p class="mt-2 text-xs text-slate-400">Format JPG/PNG, ukuran maksimal 2MB.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="mb-2 block text-xs font-bold uppercase tracking-wide text-slate-500">Warna Tema</label>
                    <div class="flex flex-wrap items-center gap-3 rounded-2xl bg-[#F7F9FC] p-4">
                        <input type="color" name="warna_tema" value="{{ old('warna_tema', $pengaturan->warna_tema) }}" class="h-11 w-16 cursor-pointer rounded-xl border border-slate-200 bg-white p-1">
                        <div>
                            <p class="text-sm font-semibold text-slate-700">Warna utama sistem</p>
                            <p class="text-xs text-slate-400">{{ old('warna_tema', $pengaturan->warna_tema) }}</p>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end border-t border-slate-100 pt-5">
                    <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-[#123F7A] px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-900/10 transition hover:bg-[#0B3264]">💾 Simpan Perubahan</button>
                </div>
            </div>
        </form>

        {{-- PREVIEW --}}
        <div class="space-y-6">
            <div class="overflow-hidden rounded-[1.5rem] border border-slate-200/80 bg-white/95 shadow-lg">
                <div class="border-b border-slate-100 p-5">
                    <h2 class="font-bold text-[#0B2545]">Preview Tampilan</h2>
                    <p class="mt-1 text-sm text-slate-500">Contoh tampilan dengan pengaturan cabang saat ini.</p>
                </div>
                <div class="p-5">
                    <div class="overflow-hidden rounded-2xl border border-slate-200 shadow-sm">
                        <div class="relative h-40 overflow-hidden">
                            <img src="{{ asset('images/dashboard-bulog.jpg') }}" alt="Preview" class="absolute inset-0 h-full w-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-r from-[#082F63]/80 to-[#123F7A]/20"></div>
                            <div class="relative z-10 p-5 text-white">
                                <div class="text-[10px] font-semibold uppercase tracking-[.2em] text-white/70">Sistem BA Rampung</div>
                                <div class="mt-2 text-2xl font-semibold">{{ $pengaturan->nama_cabang ?: 'BULOG Indramayu' }}</div>
                            </div>
                        </div>
                        <div class="grid grid-cols-3 gap-2 bg-white p-3">
                            <div class="h-12 rounded-xl bg-blue-50"></div>
                            <div class="h-12 rounded-xl bg-orange-50"></div>
                            <div class="h-12 rounded-xl bg-slate-50"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="rounded-[1.5rem] border border-slate-200/80 bg-white/95 p-5 shadow-lg">
                <div class="flex items-start gap-3">
                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-orange-50">💡</div>
                    <div>
                        <h3 class="font-bold text-[#0B2545]">Panduan Singkat</h3>
                        <p class="mt-2 text-sm leading-6 text-slate-500">Beberapa pengaturan dapat memengaruhi tampilan seluruh sistem. Pastikan data yang dimasukkan sudah benar sebelum menyimpan perubahan.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
