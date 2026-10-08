@extends('layouts.app')

@section('title', 'Tambah Mitra Pengolahan')

@section('content')

<div class="mitra-page">
    <div class="mitra-page-header">
        <p class="mitra-eyebrow">MASTER DATA</p>
        <h1 class="mitra-page-title">
            Tambah <span>Mitra</span>
        </h1>
        <p class="mitra-page-subtitle">
            Tambahkan data mitra pengolahan baru ke dalam sistem.
        </p>
    </div>

    <form method="POST" action="{{ route('mitra.store') }}" class="mitra-form-card card p-6 space-y-5 w-full max-w-3xl mx-auto">

    @csrf

    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

        {{-- Kode Mitra --}}
        <div>
            <label class="label">Kode Mitra</label>
            <input
                type="text"
                name="kode_mitra"
                value="{{ old('kode_mitra') }}"
                required
                class="input"
                placeholder="MIT-006"
            >
        </div>

        {{-- Nama Mitra --}}
        <div>
            <label class="label">Nama Mitra</label>
            <input
                type="text"
                name="nama_mitra"
                value="{{ old('nama_mitra') }}"
                required
                class="input"
                placeholder="UD. Contoh Makmur"
            >
        </div>

        {{-- Penanggung Jawab --}}
        <div>
            <label class="label">Penanggung Jawab</label>
            <input
                type="text"
                name="penanggung_jawab"
                value="{{ old('penanggung_jawab') }}"
                class="input"
                placeholder="Nama penanggung jawab"
            >
        </div>

        {{-- Alamat --}}
        <div class="md:col-span-2">
            <label class="label">Alamat</label>
            <textarea
                name="alamat"
                rows="2"
                class="input"
                placeholder="Alamat lengkap mitra"
            >{{ old('alamat') }}</textarea>
        </div>

        {{-- Kecamatan --}}
        <div>
            <label class="label">Kecamatan</label>
            <input
                type="text"
                name="kecamatan"
                value="{{ old('kecamatan') }}"
                class="input"
                placeholder="Kecamatan"
            >
        </div>

        {{-- Desa --}}
        <div>
            <label class="label">Desa</label>
            <input
                type="text"
                name="desa"
                value="{{ old('desa') }}"
                class="input"
                placeholder="Desa"
            >
        </div>

        {{-- Nomor Telepon --}}
        <div>
            <label class="label">Nomor Telepon</label>
            <input
                type="text"
                name="nomor_telepon"
                value="{{ old('nomor_telepon') }}"
                class="input"
                placeholder="08xxxxxxxxxx"
            >
        </div>

        {{-- Email --}}
        <div>
            <label class="label">Email</label>
            <input
                type="email"
                name="email"
                value="{{ old('email') }}"
                class="input"
                placeholder="email@contoh.com"
            >
        </div>

        {{-- Status --}}
        <div>
            <label class="label">Status</label>
            <select name="status" class="input">
                <option
                    value="aktif"
                    @selected(old('status', 'aktif') === 'aktif')
                >
                    Aktif
                </option>

                <option
                    value="nonaktif"
                    @selected(old('status') === 'nonaktif')
                >
                    Nonaktif
                </option>
            </select>
        </div>

    </div>

    {{-- Tombol --}}
    <div class="flex justify-between pt-2">

        <a
            href="{{ route('mitra.index') }}"
            class="btn-secondary"
        >
            ← Kembali
        </a>

        <button
            type="submit"
            class="btn-primary"
        >
            💾 Simpan Mitra
        </button>

    </div>

</form>

    <style>
        .mitra-page {
            width: 100%;
            max-width: 980px;
            margin: 0 auto;
            padding: 2rem 1rem 3rem;
        }

        .mitra-page-header {
            width: 100%;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .mitra-eyebrow {
            margin: 0 0 .35rem;
            color: #64748b;
            font-size: .7rem;
            font-weight: 800;
            letter-spacing: .18em;
            text-transform: uppercase;
        }

        .mitra-page-title {
            margin: 0;
            color: #0b2545;
            font-family: Georgia, "Times New Roman", serif;
            font-size: clamp(2rem, 4vw, 3rem);
            line-height: 1.1;
            font-weight: 500;
        }

        .mitra-page-title span {
            color: #f28c28;
        }

        .mitra-page-subtitle {
            margin: .55rem auto 0;
            max-width: 560px;
            color: #64748b;
            font-size: .85rem;
        }

        .mitra-form-card {
            margin-left: auto !important;
            margin-right: auto !important;
            border: 1px solid rgba(148,163,184,.25);
            border-radius: 1.25rem;
            background: rgba(255,255,255,.96);
            box-shadow: 0 20px 55px rgba(15,23,42,.14);
        }

        .mitra-form-card .label {
            color: #334155;
            font-weight: 700;
        }

        .mitra-form-card .input {
            border-color: #dbe3ec;
            background: #f8fafc;
            color: #0f172a;
            transition: border-color .2s ease, box-shadow .2s ease, background-color .2s ease;
        }

        .mitra-form-card .input::placeholder {
            color: #94a3b8;
        }

        .mitra-form-card .input:focus {
            border-color: #123f7a;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(18,63,122,.10);
            outline: none;
        }

        /* Mode gelap */
        html.dark-theme .mitra-eyebrow {
            color: #94a3b8;
        }

        html.dark-theme .mitra-page-title {
            color: #f8fafc;
        }

        html.dark-theme .mitra-page-subtitle {
            color: #94a3b8;
        }

        html.dark-theme .mitra-form-card {
            border-color: #263b55;
            background: rgba(15,29,47,.96);
            box-shadow: 0 22px 60px rgba(0,0,0,.38);
        }

        html.dark-theme .mitra-form-card .label {
            color: #dbe7f5;
        }

        html.dark-theme .mitra-form-card .input {
            border-color: #334a64;
            background: #17283d;
            color: #f1f5f9;
        }

        html.dark-theme .mitra-form-card .input::placeholder {
            color: #71849b;
        }

        html.dark-theme .mitra-form-card .input:focus {
            border-color: #60a5fa;
            background: #1b3048;
            box-shadow: 0 0 0 3px rgba(96,165,250,.12);
        }

        @media (max-width: 768px) {
            .mitra-page {
                padding: 1.25rem .75rem 2rem;
            }

            .mitra-page-title {
                font-size: 2.1rem;
            }

            .mitra-form-card {
                padding: 1.25rem !important;
            }
        }
    </style>
</div>

@endsection