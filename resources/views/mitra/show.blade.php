@extends('layouts.app')

@section('title', 'Detail Mitra Pengolahan')

@section('content')
<style>
    .mitra-detail-page { color: #1e293b; }
    .mitra-detail-hero {
        display: flex; align-items: flex-end; justify-content: space-between;
        gap: 24px; margin: 0 auto 24px; width: 100%;
    }
    .mitra-detail-eyebrow {
        margin: 0 0 7px; color: #dbeafe; font-size: 11px; font-weight: 800;
        letter-spacing: .28em; text-transform: uppercase;
    }
    .mitra-detail-heading {
        margin: 0; color: #fff; font-family: Georgia, 'Times New Roman', serif;
        font-size: clamp(34px, 4.5vw, 52px); font-weight: 500; line-height: 1.05;
        text-shadow: 0 2px 12px rgba(0,0,0,.18);
    }
    .mitra-detail-heading span { color: #F28C28; }
    .mitra-detail-subtitle { margin: 9px 0 0; color: rgba(255,255,255,.82); font-size: 13px; }
    .mitra-detail-actions { display:flex; flex-wrap:wrap; align-items:center; justify-content:flex-end; gap:10px; }
    .mitra-detail-btn {
        display:inline-flex; align-items:center; justify-content:center; gap:8px;
        min-height:42px; padding:10px 16px; border-radius:11px; font-size:13px;
        font-weight:700; text-decoration:none; transition:all .2s ease;
    }
    .mitra-detail-btn-back { color:#fff; background:rgba(18,45,79,.72); border:1px solid rgba(255,255,255,.65); }
    .mitra-detail-btn-back:hover { background:#123F7A; transform:translateY(-1px); }
    .mitra-detail-btn-edit { color:#fff; background:#F28C28; border:1px solid #F28C28; box-shadow:0 5px 16px rgba(242,140,40,.2); }
    .mitra-detail-btn-edit:hover { background:#dc7413; border-color:#dc7413; transform:translateY(-1px); }
    .mitra-detail-card {
        background:rgba(255,255,255,.97); border:1px solid rgba(226,232,240,.95);
        border-radius:18px; color:#1e293b; box-shadow:0 12px 32px rgba(15,23,42,.10);
    }
    .mitra-detail-card-head { display:flex; align-items:center; gap:12px; margin-bottom:18px; }
    .mitra-detail-icon {
        display:flex; align-items:center; justify-content:center; flex:0 0 44px;
        width:44px; height:44px; border-radius:13px; background:#eff6ff; color:#123F7A;
    }
    .mitra-detail-icon.orange { background:#fff2e5; color:#e87912; }
    .mitra-detail-icon.purple { background:#f1efff; color:#6554c0; }
    .mitra-detail-card-title { margin:0; color:#102d54; font-size:15px; font-weight:800; }
    .mitra-detail-card-subtitle { margin:4px 0 0; color:#64748b; font-size:12px; }
    .mitra-detail-info-row {
        display:grid; grid-template-columns:minmax(125px,.8fr) minmax(0,1.4fr);
        align-items:start; gap:14px; padding:12px 0; border-bottom:1px solid #edf1f6;
        font-size:13px;
    }
    .mitra-detail-info-row:last-child { border-bottom:0; padding-bottom:0; }
    .mitra-detail-label { display:flex; align-items:center; gap:8px; color:#64748b; }
    .mitra-detail-value { color:#17365f; font-weight:650; overflow-wrap:anywhere; }
    .mitra-detail-status {
        display:inline-flex; align-items:center; gap:7px; border-radius:999px;
        padding:6px 11px; background:#dcfce7; color:#15803d; font-size:12px; font-weight:700;
    }
    .mitra-detail-status:before { content:''; width:6px; height:6px; border-radius:50%; background:currentColor; }
    .mitra-detail-all {
        display:inline-flex; align-items:center; gap:6px; padding:8px 12px;
        border-radius:10px; background:#eff6ff; color:#123F7A; font-size:12px;
        font-weight:800; text-decoration:none; white-space:nowrap;
    }
    .mitra-detail-all:hover { background:#dbeafe; }
    .mitra-detail-table-wrap { overflow-x:auto; border:1px solid #e8edf4; border-radius:12px; }
    .mitra-detail-table { width:100%; border-collapse:collapse; font-size:12px; min-width:570px; }
    .mitra-detail-table th { padding:13px 14px; background:#f1f5f9; color:#475569; font-weight:800; text-align:left; white-space:nowrap; }
    .mitra-detail-table td { padding:14px; color:#17365f; border-top:1px solid #e8edf4; vertical-align:middle; }
    .mitra-detail-table tbody tr:hover { background:#f8fafc; }
    .mitra-detail-empty { padding:32px 16px; text-align:center; color:#64748b; font-size:13px; }
    .mitra-detail-open {
        display:inline-flex; align-items:center; justify-content:center; padding:7px 11px;
        border:1px solid #dbe3ed; border-radius:999px; color:#123F7A; font-weight:800;
        text-decoration:none; white-space:nowrap;
    }
    .mitra-detail-open:hover { background:#eff6ff; border-color:#bfdbfe; }
    .mitra-detail-stat {
        display:flex; align-items:center; gap:14px; min-height:105px; padding:18px;
        border-radius:14px; background:#eff6ff;
    }
    .mitra-detail-stat.green { background:#ecfdf3; }
    .mitra-detail-stat.orange { background:#fff5e9; }
    .mitra-detail-stat-icon {
        display:flex; align-items:center; justify-content:center; width:48px; height:48px;
        flex:0 0 48px; border-radius:50%; background:#dbeafe; color:#2563eb;
    }
    .mitra-detail-stat.green .mitra-detail-stat-icon { background:#d1fae5; color:#059669; }
    .mitra-detail-stat.orange .mitra-detail-stat-icon { background:#ffedd5; color:#ea580c; }
    .mitra-detail-stat-label { color:#475569; font-size:12px; font-weight:700; }
    .mitra-detail-stat-number { margin-top:3px; color:#123F7A; font-size:27px; line-height:1; font-weight:850; }
    .mitra-detail-stat.green .mitra-detail-stat-number { color:#047857; }
    .mitra-detail-stat.orange .mitra-detail-stat-number { color:#c2410c; }
    html.dark-theme .mitra-detail-card { background:#101C2D !important; border-color:#263B55 !important; color:#E5E7EB !important; box-shadow:0 16px 40px rgba(0,0,0,.28) !important; }
    html.dark-theme .mitra-detail-card-title, html.dark-theme .mitra-detail-value { color:#F1F5F9 !important; }
    html.dark-theme .mitra-detail-card-subtitle, html.dark-theme .mitra-detail-label, html.dark-theme .mitra-detail-stat-label { color:#A8B8CC !important; }
    html.dark-theme .mitra-detail-info-row { border-color:#263B55 !important; }
    html.dark-theme .mitra-detail-icon { background:#172f4b !important; color:#93c5fd !important; }
    html.dark-theme .mitra-detail-icon.orange { background:#3a2a1b !important; color:#fdba74 !important; }
    html.dark-theme .mitra-detail-icon.purple { background:#282343 !important; color:#c4b5fd !important; }
    html.dark-theme .mitra-detail-table-wrap { border-color:#263B55 !important; }
    html.dark-theme .mitra-detail-table th { background:#17283d !important; color:#cbd5e1 !important; }
    html.dark-theme .mitra-detail-table td { color:#e2e8f0 !important; border-color:#263B55 !important; }
    html.dark-theme .mitra-detail-table tbody tr:hover { background:#17283d !important; }
    html.dark-theme .mitra-detail-all { background:#172f4b !important; color:#bfdbfe !important; }
    html.dark-theme .mitra-detail-open { border-color:#334a64 !important; color:#bfdbfe !important; }
    html.dark-theme .mitra-detail-stat { background:#172f4b !important; }
    html.dark-theme .mitra-detail-stat.green { background:#123329 !important; }
    html.dark-theme .mitra-detail-stat.orange { background:#3a2a1b !important; }
    html.dark-theme .mitra-detail-stat-number { color:#bfdbfe !important; }
    html.dark-theme .mitra-detail-stat.green .mitra-detail-stat-number { color:#6ee7b7 !important; }
    html.dark-theme .mitra-detail-stat.orange .mitra-detail-stat-number { color:#fdba74 !important; }
    @media(max-width:900px) {
        .mitra-detail-hero { align-items:flex-start; flex-direction:column; }
        .mitra-detail-actions { justify-content:flex-start; }
    }
    @media(max-width:640px) {
        .mitra-detail-info-row { grid-template-columns:1fr; gap:5px; }
        .mitra-detail-stat { padding:14px; }
        .mitra-detail-stat-icon { width:40px; height:40px; flex-basis:40px; }
    }
</style>

<div class="mitra-detail-page space-y-5">
    {{-- HEADER --}}
    <div class="mitra-detail-hero">
        <div>
            <p class="mitra-detail-eyebrow">MASTER DATA</p>
            <h1 class="mitra-detail-heading">Detail <span>Mitra Pengolahan</span></h1>
            <p class="mitra-detail-subtitle">{{ $mitra->kode_mitra }}</p>
        </div>

        <div class="mitra-detail-actions">
            <a href="{{ route('mitra.index') }}" class="mitra-detail-btn mitra-detail-btn-back">
                <span aria-hidden="true">←</span> Kembali ke Data Mitra
            </a>
            @role('admin_gudang', 'admin_sistem')
                <a href="{{ route('mitra.edit', $mitra) }}" class="mitra-detail-btn mitra-detail-btn-edit">
                    <span aria-hidden="true">✎</span> Edit Mitra
                </a>
            @endrole
        </div>
    </div>

    <div class="grid grid-cols-1 gap-5 xl:grid-cols-5">
        {{-- INFORMASI MITRA --}}
        <section class="mitra-detail-card p-5 sm:p-6 xl:col-span-2">
            <div class="mitra-detail-card-head">
                <div class="mitra-detail-icon" aria-hidden="true">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M3 21h18M5 21V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16M9 7h2m2 0h2M9 11h2m2 0h2M9 15h2m2 0h2M10 21v-3h4v3"/></svg>
                </div>
                <div>
                    <h2 class="mitra-detail-card-title">Informasi Mitra</h2>
                    <p class="mitra-detail-card-subtitle">Data utama mitra pengolahan.</p>
                </div>
            </div>

            <dl>
                <div class="mitra-detail-info-row">
                    <dt class="mitra-detail-label">Kode Mitra</dt>
                    <dd class="mitra-detail-value">{{ $mitra->kode_mitra }}</dd>
                </div>
                <div class="mitra-detail-info-row">
                    <dt class="mitra-detail-label">Nama Mitra</dt>
                    <dd class="mitra-detail-value">{{ $mitra->nama_mitra }}</dd>
                </div>
                <div class="mitra-detail-info-row">
                    <dt class="mitra-detail-label">Penanggung Jawab</dt>
                    <dd class="mitra-detail-value">{{ $mitra->penanggung_jawab ?? '-' }}</dd>
                </div>
                <div class="mitra-detail-info-row">
                    <dt class="mitra-detail-label">Alamat</dt>
                    <dd class="mitra-detail-value">{{ $mitra->alamat ?? '-' }}</dd>
                </div>
                <div class="mitra-detail-info-row">
                    <dt class="mitra-detail-label">Kecamatan</dt>
                    <dd class="mitra-detail-value">{{ $mitra->kecamatan ?? '-' }}</dd>
                </div>
                <div class="mitra-detail-info-row">
                    <dt class="mitra-detail-label">Desa</dt>
                    <dd class="mitra-detail-value">{{ $mitra->desa ?? '-' }}</dd>
                </div>
                <div class="mitra-detail-info-row">
                    <dt class="mitra-detail-label">Nomor Telepon</dt>
                    <dd class="mitra-detail-value">{{ $mitra->nomor_telepon ?? '-' }}</dd>
                </div>
                <div class="mitra-detail-info-row">
                    <dt class="mitra-detail-label">Email</dt>
                    <dd class="mitra-detail-value">{{ $mitra->email ?? '-' }}</dd>
                </div>
                <div class="mitra-detail-info-row">
                    <dt class="mitra-detail-label">Status</dt>
                    <dd><span class="mitra-detail-status" style="{{ $mitra->status === 'aktif' ? '' : 'background:#e2e8f0;color:#475569;' }}">{{ ucfirst($mitra->status) }}</span></dd>
                </div>
            </dl>
        </section>

        <div class="space-y-5 xl:col-span-3">
            {{-- BA RAMPUNG TERBARU --}}
            <section class="mitra-detail-card p-5 sm:p-6">
                <div class="mitra-detail-card-head" style="justify-content:space-between; flex-wrap:wrap;">
                    <div class="flex items-center gap-3">
                        <div class="mitra-detail-icon orange" aria-hidden="true">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M7 3h7l5 5v13H7z"/><path d="M14 3v6h5M10 13h6M10 17h6"/></svg>
                        </div>
                        <div>
                            <h2 class="mitra-detail-card-title">BA Rampung Terbaru</h2>
                            <p class="mitra-detail-card-subtitle">Daftar BA Rampung dari mitra ini.</p>
                        </div>
                    </div>
                    <a href="{{ route('ba-rampung.index', ['mitra_pengolahan_id' => $mitra->id]) }}" class="mitra-detail-all">
                        Lihat Semua <span aria-hidden="true">→</span>
                    </a>
                </div>

                @if ($baTerbaru->isEmpty())
                    <div class="mitra-detail-empty">
                        <div style="font-size:28px; margin-bottom:8px;" aria-hidden="true">▤</div>
                        Belum ada data BA Rampung dari mitra ini.
                    </div>
                @else
                    <div class="mitra-detail-table-wrap">
                        <table class="mitra-detail-table">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nomor BA</th>
                                    <th>Tanggal</th>
                                    <th>Gudang Tujuan</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($baTerbaru as $index => $ba)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td style="font-weight:750;">{{ $ba->nomor_ba }}</td>
                                        <td>{{ $ba->tanggal_ba ? \Illuminate\Support\Carbon::parse($ba->tanggal_ba)->format('d M Y') : '-' }}</td>
                                        <td>{{ $ba->gudang->nama_gudang ?? '-' }}</td>
                                        <td><x-status-badge :color="$ba->statusBadgeColor()" :label="$ba->statusLabel()" /></td>
                                        <td><a href="{{ route('ba-rampung.show', $ba) }}" class="mitra-detail-open">Lihat</a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </section>

            {{-- STATISTIK --}}
            <section class="mitra-detail-card p-5 sm:p-6">
                <div class="mitra-detail-card-head">
                    <div class="mitra-detail-icon purple" aria-hidden="true">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 19V5M4 19h17"/><path d="M8 16v-5h3v5M14 16V7h3v9"/></svg>
                    </div>
                    <div>
                        <h2 class="mitra-detail-card-title">Ringkasan Mitra</h2>
                        <p class="mitra-detail-card-subtitle">Ringkasan data BA Rampung mitra ini.</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
                    <div class="mitra-detail-stat">
                        <div class="mitra-detail-stat-icon" aria-hidden="true">▤</div>
                        <div>
                            <div class="mitra-detail-stat-label">Total BA Rampung</div>
                            <div class="mitra-detail-stat-number">{{ $mitra->ba_rampungs_count }}</div>
                        </div>
                    </div>
                    <div class="mitra-detail-stat green">
                        <div class="mitra-detail-stat-icon" aria-hidden="true">✓</div>
                        <div>
                            <div class="mitra-detail-stat-label">Status Mitra</div>
                            <div class="mitra-detail-stat-number" style="font-size:20px;">{{ ucfirst($mitra->status) }}</div>
                        </div>
                    </div>
                    <div class="mitra-detail-stat orange">
                        <div class="mitra-detail-stat-icon" aria-hidden="true">↗</div>
                        <div>
                            <div class="mitra-detail-stat-label">Ditampilkan</div>
                            <div class="mitra-detail-stat-number">{{ $baTerbaru->count() }}</div>
                            <div class="mitra-detail-card-subtitle">BA terbaru</div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection
