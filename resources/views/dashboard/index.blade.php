@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

{{-- =========================================================
    FONT & STYLE KHUSUS DASHBOARD
    Tidak mengubah fungsi/backend
========================================================= --}}
<style>
    @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Manrope:wght@400;500;600;700&display=swap');

    .dashboard-page {
        font-family: 'Manrope', sans-serif;
    }

    .dashboard-display {
        font-family: 'Cormorant Garamond', Georgia, serif;
        font-weight: 400;
        letter-spacing: -0.025em;
    }

    .dashboard-kicker {
        letter-spacing: .32em;
        text-transform: uppercase;
        font-size: 10px;
        font-weight: 700;
    }

    .glass-card {
        background: rgba(255,255,255,.92);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255,255,255,.8);
        box-shadow: 0 18px 50px rgba(15, 43, 82, .08);
    }

    .soft-card {
        background: rgba(255,255,255,.96);
        border: 1px solid rgba(15,43,82,.07);
        box-shadow: 0 10px 30px rgba(15,43,82,.06);
    }

    .navy-gradient {
        background:
            linear-gradient(
                135deg,
                rgba(8,36,82,.98),
                rgba(20,71,137,.94)
            );
    }

    .orange-text {
        color: #F59E0B;
        font-weight: 400;
    }

    .orange-bg {
        background: #F59E0B;
    }

    .bulog-blue {
        color: #123F7A;
    }

    .bulog-blue-bg {
        background: #123F7A;
    }


    /* Blue mist / glass treatment for the transparent navbar */
    .dashboard-navbar {
        background: linear-gradient(
            180deg,
            rgba(5, 35, 69, .38) 0%,
            rgba(5, 35, 69, .12) 100%
        );
        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
    }

    .hero-dashboard {
        position: relative;
        overflow: hidden;
        width: 100%;
        margin-left: 0;
        border-radius: 0 0 34px 34px;
        min-height: 600px;
        box-shadow: 0 18px 45px rgba(15, 48, 82, .10);

        background:
            linear-gradient(
                180deg,
                rgba(7, 43, 82, .72) 0%,
                rgba(7, 43, 82, .46) 22%,
                rgba(7, 43, 82, .18) 48%,
                rgba(7, 43, 82, .28) 100%
            ),
            linear-gradient(
                90deg,
                rgba(7, 43, 82, .58) 0%,
                rgba(7, 43, 82, .30) 45%,
                rgba(7, 43, 82, .18) 100%
            ),
            url('/images/dashboard-bulog.jpg')
            center / cover no-repeat;
    }

    .hero-dashboard::before {
        content: "";
        position: absolute;
        inset: 0;
        z-index: 1;
        pointer-events: none;

        background:
            radial-gradient(
                ellipse at 50% 0%,
                rgba(82, 151, 219, .24) 0%,
                rgba(20, 73, 126, .22) 38%,
                rgba(8, 43, 82, 0) 72%
            ),
            linear-gradient(
                180deg,
                rgba(8, 48, 91, .58) 0%,
                rgba(8, 48, 91, .28) 20%,
                rgba(8, 48, 91, .04) 48%,
                rgba(0,0,0,.12) 100%
            );
    }

    .hero-dashboard::after {
        content: "";
        position: absolute;
        inset: 0;
        z-index: 1;
        pointer-events: none;

        background:
            linear-gradient(
                90deg,
                rgba(4, 27, 55, .28) 0%,
                rgba(4, 27, 55, .07) 52%,
                rgba(4, 27, 55, .10) 100%
            ),
            linear-gradient(
                180deg,
                rgba(0,0,0,0) 72%,
                rgba(239, 238, 232, .04) 84%,
                rgba(239, 238, 232, .55) 96%,
                rgba(239, 238, 232, .92) 100%
            );
    }

    .hero-content {
        position: relative;
        z-index: 3;
    }

    .hero-dashboard > img,
    .hero-dashboard::after {
        z-index: 0;
    }

    /* HERO FULL-BLEED */
    .dashboard-page > .hero-dashboard {
        margin-top: -1.5rem;
    }

    .hero-dashboard > .hero-content {
        padding: 165px 6.5vw 70px;
    }

    .hero-dashboard > .hero-content > .hero-content {
        padding: 0;
    }

    .hero-copy {
        width: min(60%, 760px);
        position: relative;
        z-index: 3;
    }

    .hero-copy h1 {
        max-width: 735px;
        text-wrap: balance;
    }

    .hero-copy p {
        max-width: 590px;
    }

    .hero-copy,
    .hero-copy h1,
    .hero-copy p {
        overflow-wrap: break-word;
        word-break: normal;
    }

    .hero-copy h1 {
        max-width: 100%;
    }

    .hero-copy .orange-text {
        display: inline;
    }

    .hero-quote {
        position: absolute;
        z-index: 4;
        right: 6vw;
        top: 205px;
        width: min(300px, 23vw);
    }

    @media (max-width: 1100px) {
        .hero-copy {
            width: min(55%, 620px);
        }

        .hero-quote {
            right: 4vw;
            width: 280px;
        }
    }

    @media (min-width: 1024px) {
        .dashboard-page > .hero-dashboard {
            margin-top: -2.5rem;
        }

        .hero-dashboard > .hero-content {
            padding: 175px 6.5vw 75px;
        }
    }

    .quote-box {
        background: rgba(8,35,70,.50);
        border: 1px solid rgba(255,255,255,.35);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
    }

@media (max-width: 1023px) {
        .hero-dashboard {
            min-height: 760px;
        }

        .hero-dashboard > .hero-content {
            padding: 145px 7vw 55px;
        }

        .hero-copy {
            width: 100%;
        }

        .hero-copy h1 {
            max-width: 760px;
        }

        .hero-quote {
            position: relative;
            top: auto;
            right: auto;
            width: min(100%, 360px);
            margin: 42px 0 0 auto;
        }
    }

    .kpi-icon {
        width: 54px;
        height: 54px;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }

    .chart-card {
        min-height: 430px;
    }

    .activity-row:hover {
        background: rgba(18,63,122,.035);
    }


    /* =========================================================
       FINAL DASHBOARD POLISH
       Semua penyesuaian navbar + blue mist dilakukan dari
       index.blade.php saja. app.blade.php tidak perlu diubah.
    ========================================================= */

    /* Navbar mengikuti lebar frame hero, tidak mepet browser */
    body:has(.dashboard-page) header {
        position: absolute !important;
        top: 0 !important;
        left: 50px !important;
        right: 50px !important;
        width: auto !important;
        max-width: none !important;
        margin: 0 !important;
        padding: 20px 48px !important;
        box-sizing: border-box !important;
        background: transparent !important;
    }

    /* Kabut biru khusus area atas: navbar tetap terbaca */
    .hero-dashboard::before {
        content: "";
        position: absolute;
        inset: 0;
        z-index: 1;
        pointer-events: none;

        background:
            linear-gradient(
                180deg,
                rgba(13, 66, 119, .76) 0%,
                rgba(18, 78, 137, .58) 14%,
                rgba(20, 83, 145, .34) 30%,
                rgba(20, 83, 145, .08) 52%,
                rgba(0, 0, 0, .10) 100%
            ),
            radial-gradient(
                ellipse at 50% -10%,
                rgba(104, 171, 230, .32) 0%,
                rgba(42, 103, 165, .18) 38%,
                rgba(8, 43, 82, 0) 72%
            );
    }

    .hero-dashboard::after {
        content: "";
        position: absolute;
        inset: 0;
        z-index: 1;
        pointer-events: none;

        background:
            linear-gradient(
                90deg,
                rgba(5, 30, 61, .26) 0%,
                rgba(5, 30, 61, .08) 48%,
                rgba(5, 30, 61, .10) 100%
            );
    }

    .hero-dashboard > .hero-content {
        position: relative;
        z-index: 3;
    }

    /* Hero copy tetap berada di kiri dan tidak menabrak quote */
    .hero-copy {
        width: min(62%, 790px);
        max-width: 750px;
    }

    .hero-copy h1 {
        max-width: 790px;
    }

    /* Quote tetap di kanan dan tidak terlalu mojok */
    .hero-quote {
        right: 7vw !important;
        top: 220px !important;
        width: 300px !important;
    }

    /* Navbar dan isi hero punya jarak yang rapi */
    .dashboard-page > .hero-dashboard > .hero-content {
        padding-top: 175px;
    }

    @media (max-width: 1100px) {
        body:has(.dashboard-page) header {
            left: 32px !important;
            right: 32px !important;
            padding-left: 28px !important;
            padding-right: 28px !important;
        }

        .hero-copy {
            width: 55%;
            max-width: 620px;
        }

        .hero-quote {
            right: 5vw !important;
            width: 280px !important;
        }
    }

    @media (max-width: 1023px) {
        body:has(.dashboard-page) header {
            left: 20px !important;
            right: 20px !important;
            padding: 16px 20px !important;
        }

        .hero-copy {
            width: 100%;
            max-width: 760px;
        }

        .hero-quote {
            position: relative !important;
            top: auto !important;
            right: auto !important;
            width: min(100%, 360px) !important;
            margin: 40px 0 0 auto;
        }
    }


    /* =========================================================
       BLUE HAZE DI BELAKANG TEKS HERO
       Transparan, melebar, dan soft — bukan kotak.
    ========================================================= */

    .hero-dashboard .hero-copy::before {
        content: "";
        position: absolute;
        z-index: -1;
        left: -120px;
        top: 65px;
        width: 820px;
        height: 500px;
        pointer-events: none;

        background:
            radial-gradient(
                ellipse at 38% 45%,
                rgba(18, 74, 132, .72) 0%,
                rgba(18, 74, 132, .55) 30%,
                rgba(18, 74, 132, .28) 55%,
                rgba(18, 74, 132, 0) 78%
            );

        filter: blur(18px);
        opacity: .95;
    }

    /* Tambahan kabut tipis khusus area atas/navbar */
    .hero-dashboard > .hero-content::before {
        content: "";
        position: absolute;
        z-index: -1;
        top: -20px;
        left: -5%;
        width: 72%;
        height: 230px;
        pointer-events: none;

        background:
            linear-gradient(
                180deg,
                rgba(11, 58, 106, .48) 0%,
                rgba(11, 58, 106, .22) 55%,
                rgba(11, 58, 106, 0) 100%
            );

        filter: blur(12px);
    }

    /* Pastikan isi hero berada di atas kabut */
    .hero-dashboard .hero-copy > * {
        position: relative;
        z-index: 2;
    }

    /* Judul tetap tipis seperti referensi */
    .hero-dashboard .dashboard-display {
        font-family: 'Cormorant Garamond', Georgia, serif;
        font-weight: 400;
        letter-spacing: -0.025em;
        text-shadow: 0 2px 18px rgba(3, 28, 55, .16);
    }

    .hero-dashboard .hero-copy p {
        text-shadow: 0 1px 8px rgba(3, 28, 55, .22);
    }


    /* =========================================================
       TRANSISI HERO -> DASHBOARD CONTENT
    ========================================================= */

    .dashboard-page > .hero-dashboard + .flex.justify-end {
        position: relative;
        z-index: 10;
        margin-top: -34px;
        padding-right: 2px;
        margin-bottom: -8px;
    }

    .dashboard-page > .hero-dashboard + .flex.justify-end > form > div {
        box-shadow:
            0 12px 28px rgba(18, 63, 122, .10),
            0 2px 8px rgba(0, 0, 0, .04);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
    }

    .dashboard-page > .hero-dashboard ~ section {
        position: relative;
        z-index: 2;
    }

    /* KPI lebih dekat dengan hero dan terasa sebagai satu komposisi */
    .dashboard-page > .hero-dashboard + .flex.justify-end + section {
        margin-top: -2px;
    }

    .dashboard-page > .hero-dashboard + .flex.justify-end + section > .glass-card {
        box-shadow:
            0 12px 35px rgba(18, 63, 122, .07),
            inset 0 1px 0 rgba(255,255,255,.85);
    }

    .glass-card,
    .soft-card {
        border: 1px solid rgba(18, 63, 122, .055);
    }

    @media (max-width: 1023px) {
        .hero-dashboard {
            border-radius: 0 0 26px 26px;
        }

        .dashboard-page > .hero-dashboard + .flex.justify-end {
            margin-top: -24px;
        }
    }



    /* =========================================================
       DASHBOARD FINAL COMPOSITION
       Referensi: hero foto -> curved cream transition ->
       floating KPI -> chart -> data/activity.
    ========================================================= */

    .dashboard-page {
        position: relative;
        overflow: hidden;
        padding-bottom: 70px;
        background:
            radial-gradient(circle at 8% 45%, rgba(245,158,11,.055), transparent 22%),
            radial-gradient(circle at 92% 62%, rgba(18,63,122,.055), transparent 24%),
            #f3f1eb;
    }

    /* Ornamen sudut: memberi karakter tanpa membuat halaman ramai */
    .dashboard-page::before,
    .dashboard-page::after {
        content: "";
        position: absolute;
        pointer-events: none;
        z-index: 0;
        opacity: .55;
    }

    .dashboard-page::before {
        width: 360px;
        height: 360px;
        left: -210px;
        bottom: 90px;
        border-radius: 50%;
        background:
            radial-gradient(
                circle,
                transparent 58%,
                rgba(245,158,11,.11) 59%,
                transparent 61%
            ),
            radial-gradient(
                circle,
                transparent 67%,
                rgba(18,63,122,.07) 68%,
                transparent 70%
            );
        transform: rotate(-22deg);
    }

    .dashboard-page::after {
        width: 320px;
        height: 320px;
        right: -190px;
        bottom: 260px;
        border-radius: 50%;
        background:
            radial-gradient(
                circle,
                transparent 56%,
                rgba(18,63,122,.09) 57%,
                transparent 59%
            ),
            radial-gradient(
                circle,
                transparent 68%,
                rgba(245,158,11,.10) 69%,
                transparent 71%
            );
        transform: rotate(18deg);
    }

    /* Semua konten tetap berada di atas ornamen */
    .dashboard-page > * {
        position: relative;
        z-index: 2;
    }

    /* HERO */
    .dashboard-page > .hero-dashboard {
        position: relative;
        z-index: 5;
        min-height: 650px;
        margin-bottom: 0 !important;
        border-radius: 0 0 48px 48px;
        box-shadow: 0 24px 55px rgba(15,48,82,.14);
    }

    /* Curved cream transition di dasar hero */
    .dashboard-page > .hero-dashboard::after {
        content: "";
        position: absolute;
        left: -4%;
        right: -4%;
        bottom: -1px;
        top: auto;
        height: 115px;
        z-index: 4;
        pointer-events: none;
        border-radius: 50% 50% 0 0 / 100% 100% 0 0;
        background:
            linear-gradient(
                180deg,
                rgba(243,241,235,0) 0%,
                rgba(243,241,235,.50) 42%,
                #f3f1eb 100%
            );
        transform: translateY(48%);
    }

    /* Tambahan garis lengkung tipis seperti ilustrasi landing page */
    .dashboard-page > .hero-dashboard::before {
        z-index: 3;
    }

    /* Filter tahun menjadi pill yang ikut alur desain */
    .dashboard-page > .hero-dashboard + .flex.justify-end {
        z-index: 12;
        margin-top: -30px !important;
        margin-bottom: 20px !important;
        padding-right: 2px;
    }

    /* KPI */
    .dashboard-page > .hero-dashboard + .flex.justify-end + section {
        z-index: 10;
        margin-top: 0 !important;
    }

    .dashboard-page > .hero-dashboard + .flex.justify-end + section > .glass-card {
        position: relative;
        min-height: 132px;
        overflow: hidden;
        border-radius: 24px !important;
        background: rgba(255,255,255,.96);
        border: 1px solid rgba(255,255,255,.95);
        box-shadow:
            0 18px 38px rgba(18,63,122,.075),
            0 2px 10px rgba(18,63,122,.035);
        transition: transform .2s ease, box-shadow .2s ease;
    }

    .dashboard-page > .hero-dashboard + .flex.justify-end + section > .glass-card:hover {
        transform: translateY(-3px);
        box-shadow:
            0 22px 42px rgba(18,63,122,.10),
            0 4px 12px rgba(18,63,122,.04);
    }

    /* Lingkaran dekoratif kanan KPI */
    .dashboard-page > .hero-dashboard + .flex.justify-end + section > .glass-card::after {
        content: "";
        position: absolute;
        width: 110px;
        height: 110px;
        right: -35px;
        top: -42px;
        border-radius: 50%;
        background: rgba(18,63,122,.035);
        pointer-events: none;
    }

    /* Angka KPI pakai sans agar angka tidak berubah seperti serif */
    .dashboard-page > .hero-dashboard + .flex.justify-end + section
    .dashboard-display {
        font-family: 'Manrope', sans-serif;
        font-weight: 700;
        letter-spacing: -.04em;
    }

    /* Mini chart dekoratif pada KPI */
    .dashboard-page > .hero-dashboard + .flex.justify-end + section > .glass-card::before {
        content: "▂ ▃ ▅ ▆";
        position: absolute;
        right: 18px;
        bottom: 13px;
        color: rgba(18,63,122,.15);
        font-size: 20px;
        letter-spacing: 2px;
        z-index: 1;
    }

    /* CHART + DISTRIBUSI */
    .dashboard-page section:has(#chartPerBulan),
    .dashboard-page section:has(#chartGudang) {
        position: relative;
        z-index: 5;
    }

    .chart-card,
    .dashboard-page .soft-card {
        border-radius: 26px !important;
        border: 1px solid rgba(255,255,255,.95);
        background: rgba(255,255,255,.96);
        box-shadow:
            0 16px 40px rgba(18,63,122,.065),
            0 2px 8px rgba(18,63,122,.025);
    }

    .chart-card {
        min-height: 420px;
    }

    /* Header chart lebih modern */
    .chart-card h2,
    .chart-card .dashboard-display {
        letter-spacing: -.025em;
    }

    /* Tabel BA */
    .dashboard-page table {
        border-collapse: separate;
        border-spacing: 0;
    }

    .dashboard-page table thead tr {
        background: #f5f7fa;
    }

    .dashboard-page table thead th:first-child {
        border-radius: 12px 0 0 12px;
    }

    .dashboard-page table thead th:last-child {
        border-radius: 0 12px 12px 0;
    }

    .dashboard-page table tbody tr {
        transition: background .18s ease, transform .18s ease;
    }

    .dashboard-page table tbody tr:hover {
        background: rgba(18,63,122,.035);
    }

    .dashboard-page table tbody td {
        border-bottom: 1px solid rgba(18,63,122,.055);
    }

    /* Aktivitas: lebih mirip timeline */
    .dashboard-page .activity-row {
        position: relative;
        border-bottom: 1px solid rgba(18,63,122,.045);
        border-radius: 0 !important;
        padding: 14px 4px !important;
    }

    .dashboard-page .activity-row:last-child {
        border-bottom: 0;
    }

    /* Quick action jangan kotak biru polos */
    .dashboard-page .soft-card a.bg-\[\#123F7A\] {
        background:
            linear-gradient(135deg, #123f7a 0%, #1d5a9e 100%) !important;
        box-shadow: 0 12px 25px rgba(18,63,122,.16);
    }

    /* Jarak antar section dibuat lebih seperti dashboard premium */
    .dashboard-page.space-y-7 {
        row-gap: 26px;
    }

    @media (min-width: 1280px) {
        .dashboard-page > .hero-dashboard {
            min-height: 670px;
        }

        .dashboard-page > .hero-dashboard + .flex.justify-end {
            margin-top: -35px !important;
        }
    }

    @media (max-width: 1023px) {
        .dashboard-page > .hero-dashboard {
            min-height: 760px;
            border-radius: 0 0 32px 32px;
        }

        .dashboard-page > .hero-dashboard + .flex.justify-end {
            margin-top: -18px !important;
        }
    }


    /* =========================================================
       INDEX.BLADE — DASHBOARD WIDTH FIX
       Hanya memperbaiki layout dashboard; data/logic tetap.
    ========================================================= */
    .dashboard-page {
        width: 100%;
        max-width: none;
        min-width: 0;
        overflow-x: hidden;
        box-sizing: border-box;
    }

    .dashboard-page > .hero-dashboard {
        width: 100%;
        max-width: none;
        min-width: 0;
        box-sizing: border-box;
        overflow: hidden;
    }

    .dashboard-page .hero-dashboard-image {
        max-width: none;
    }

    .dashboard-page .hero-content {
        min-width: 0;
        box-sizing: border-box;
    }

    .dashboard-page .hero-copy,
    .dashboard-page .hero-quote {
        min-width: 0;
    }

    @media (min-width: 1280px) {
        .dashboard-page > .hero-dashboard {
            width: 100%;
        }
    }

    @media (max-width: 1023px) {
        .dashboard-page > .hero-dashboard {
            width: 100%;
            max-width: none;
        }
    }

</style>


<div class="dashboard-page w-full max-w-none space-y-7 overflow-x-hidden">

    {{-- =====================================================
        HERO
    ====================================================== --}}
<section class="hero-dashboard w-full max-w-none overflow-hidden">

    <img
        src="{{ asset('images/dashboard-bulog.jpg') }}"
        alt="Gudang BULOG"
        class="hero-dashboard-image absolute inset-0 h-full w-full object-cover"
    >

    <div class="hero-dashboard-overlay"></div>

    <div class="hero-content p-7 sm:p-10 lg:p-12">

            <div class="hero-copy">

                <div class="dashboard-kicker text-white/75 mb-4">
                    Sistem BA Rampung
                </div>

                <h1
                    class="dashboard-display text-white text-5xl sm:text-6xl lg:text-[4.75rem] xl:text-[5.1rem] leading-[.88] font-normal"
                >
                    Mengelola Data,
                    <br>

                    <span class="orange-text">
                        Menguatkan Ketahanan Pangan.
                    </span>
                </h1>

                <p class="mt-6 text-white/80 text-sm sm:text-base max-w-2xl leading-7">
                    Pantau dan kelola proses pengolahan gabah menjadi beras
                    hasil giling dengan lebih mudah, cepat, dan terintegrasi.
                </p>

                <div class="mt-8 flex flex-wrap gap-3">

                    <a
                        href="{{ route('ba-rampung.create') }}"
                        class="
                            inline-flex items-center gap-3
                            rounded-full
                            bg-white
                            px-6 py-3
                            text-sm font-semibold
                            text-[#123F7A]
                            shadow-lg
                            hover:bg-orange-50
                            transition
                        "
                    >
                        <span>＋</span>
                        Buat BA Rampung
                        <span class="text-lg">→</span>
                    </a>

                    <a
                        href="{{ route('ba-rampung.index') }}"
                        class="
                            inline-flex items-center
                            rounded-full
                            border border-white/40
                            bg-white/10
                            px-6 py-3
                            text-sm font-medium
                            text-white
                            backdrop-blur
                            hover:bg-white/20
                            transition
                        "
                    >
                        Lihat Data BA
                    </a>

                </div>

            </div>


            {{-- QUOTE --}}
            <div
                class="
                    quote-box
                    hero-quote
                    hidden
                    lg:block
                    rounded-3xl
                    p-6
                    text-white
                "
            >

                <div class="text-3xl opacity-70 dashboard-display">
                    “
                </div>

                <p
                    class="
                        dashboard-display
                        text-2xl
                        leading-tight
                        mt-1
                    "
                >
                    Pangan hari ini,
                    <br>
                    untuk masa depan
                    <br>
                    yang lebih baik.
                </p>

                <div class="mt-5 h-px bg-white/30"></div>

                <p class="mt-4 text-sm font-semibold">
                    Perum BULOG
                </p>

                <p class="text-xs text-white/60 mt-1">
                    Mengantarkan Kebaikan
                </p>

            </div>

        </div>

    </section>


    {{-- =====================================================
        FILTER TAHUN
    ====================================================== --}}
    <div class="flex justify-end">

        <form method="GET">

            <div
                class="
                    flex items-center gap-3
                    rounded-full
                    bg-white
                    border border-slate-200
                    px-4 py-2
                    shadow-sm
                "
            >

                <span class="text-xs text-slate-500">
                    Tahun
                </span>

                <select
                    name="tahun"
                    onchange="this.form.submit()"
                    class="
                        border-0
                        outline-none
                        bg-transparent
                        text-sm
                        font-semibold
                        text-[#123F7A]
                        focus:ring-0
                    "
                >

                    @for($i=date('Y'); $i>=date('Y')-5; $i--)

                        <option
                            value="{{ $i }}"
                            @selected($tahun == $i)
                        >
                            {{ $i }}
                        </option>

                    @endfor

                </select>

            </div>

        </form>

    </div>


    {{-- =====================================================
        KPI
    ====================================================== --}}
    <section
        class="
            grid
            grid-cols-1
            sm:grid-cols-2
            xl:grid-cols-4
            gap-5
        "
    >

        {{-- TOTAL BA --}}
        <div class="glass-card rounded-3xl p-6">

            <div class="flex items-start justify-between">

                <div>

                    <p class="text-xs text-slate-500 uppercase tracking-wider">
                        Total BA Rampung
                    </p>

                    <p class="dashboard-display text-5xl font-semibold text-[#123F7A] mt-2">
                        {{ number_format($kpi['total_ba']) }}
                    </p>

                    <p class="text-xs text-slate-400 mt-2">
                        Dokumen terdaftar
                    </p>

                </div>

                <div class="kpi-icon bg-blue-50 text-[#123F7A]">
                    📄
                </div>

            </div>

        </div>


        {{-- GUDANG --}}
        <div class="glass-card rounded-3xl p-6">

            <div class="flex items-start justify-between">

                <div>

                    <p class="text-xs text-slate-500 uppercase tracking-wider">
                        Gudang Aktif
                    </p>

                    <p class="dashboard-display text-5xl font-semibold text-[#123F7A] mt-2">
                        {{ number_format($kpi['gudang_aktif']) }}
                    </p>

                    <p class="text-xs text-slate-400 mt-2">
                        Gudang terdaftar
                    </p>

                </div>

                <div class="kpi-icon bg-orange-50 text-orange-500">
                    🏠
                </div>

            </div>

        </div>


        {{-- MITRA --}}
        <div class="glass-card rounded-3xl p-6">

            <div class="flex items-start justify-between">

                <div>

                    <p class="text-xs text-slate-500 uppercase tracking-wider">
                        Mitra Pengolahan
                    </p>

                    <p class="dashboard-display text-5xl font-semibold text-[#123F7A] mt-2">
                        {{ number_format($kpi['mitra_pengolahan']) }}
                    </p>

                    <p class="text-xs text-slate-400 mt-2">
                        Mitra terdaftar
                    </p>

                </div>

                <div class="kpi-icon bg-blue-50 text-[#123F7A]">
                    🤝
                </div>

            </div>

        </div>


        {{-- PENYALURAN --}}
        <div class="glass-card rounded-3xl p-6">

            <div class="flex items-start justify-between">

                <div>

                    <p class="text-xs text-slate-500 uppercase tracking-wider">
                        Penyaluran Berjalan
                    </p>

                    <p class="dashboard-display text-5xl font-semibold text-[#123F7A] mt-2">
                        {{ number_format($kpi['penyaluran_berjalan']) }}
                    </p>

                    <p class="text-xs text-slate-400 mt-2">
                        Menunggu verifikasi
                    </p>

                </div>

                <div class="kpi-icon bg-orange-50 text-orange-500">
                    ✓
                </div>

            </div>

        </div>

    </section>


    {{-- =====================================================
        CHART AREA
    ====================================================== --}}
    <section
        class="
            grid
            grid-cols-1
            xl:grid-cols-3
            gap-6
            w-full
            min-w-0
        "
    >

        {{-- BAR CHART --}}
        <div
            class="
                soft-card
                rounded-3xl
                p-6
                xl:col-span-2
                chart-card
            "
        >

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">

                <div>

                    <p class="dashboard-kicker text-[#123F7A]">
                        Statistik
                    </p>

                    <h2
                        class="
                            dashboard-display
                            text-3xl
                            text-[#123F7A]
                            font-semibold
                        "
                    >
                        Rekap BA Rampung
                    </h2>

                    <p class="text-xs text-slate-400 mt-1">
                        Per bulan tahun {{ $tahun }}
                    </p>

                </div>

            </div>

            <div class="h-[330px]">

                <canvas id="chartPerBulan"></canvas>

            </div>

        </div>


        {{-- DONUT --}}
        <div
            class="
                soft-card
                rounded-3xl
                p-6
                chart-card
            "
        >

            <div>

                <p class="dashboard-kicker text-[#123F7A]">
                    Distribusi
                </p>

                <h2
                    class="
                        dashboard-display
                        text-3xl
                        text-[#123F7A]
                        font-semibold
                    "
                >
                    Pergudangan
                </h2>

                <p class="text-xs text-slate-400 mt-1">
                    Distribusi BA berdasarkan gudang
                </p>

            </div>


            <div class="relative h-[260px] mt-4">

                <canvas id="chartGudang"></canvas>

                <div
                    class="
                        absolute
                        inset-0
                        flex
                        items-center
                        justify-center
                        pointer-events-none
                    "
                >

                    <div class="text-center">

                        <p
                            class="
                                dashboard-display
                                text-5xl
                                font-semibold
                                text-[#123F7A]
                            "
                        >
                            {{ $kpi['total_ba'] }}
                        </p>

                        <p class="text-xs text-slate-500">
                            BA Rampung
                        </p>

                    </div>

                </div>

            </div>


            <div class="mt-5 space-y-3">

                @foreach($distribusiGudang as $d)

                    <div
                        class="
                            flex
                            justify-between
                            items-center
                            text-sm
                            py-1
                        "
                    >

                        <div class="flex items-center gap-2">

                            <span
                                class="
                                    w-2
                                    h-2
                                    rounded-full
                                    bg-[#123F7A]
                                "
                            ></span>

                            <span class="text-slate-600">
                                {{ $d->nama_gudang }}
                            </span>

                        </div>

                        <span class="font-semibold text-[#123F7A]">
                            {{ $d->jumlah }}
                        </span>

                    </div>

                @endforeach

            </div>

        </div>

    </section>


    {{-- =====================================================
        DATA BAWAH
    ====================================================== --}}
    <section
        class="
            grid
            grid-cols-1
            xl:grid-cols-3
            gap-6
            w-full
            min-w-0
        "
    >

        {{-- BA TERBARU --}}
        <div
            class="
                soft-card
                rounded-3xl
                p-6
                xl:col-span-2
            "
        >

            <div class="flex items-center justify-between mb-5">

                <div>

                    <p class="dashboard-kicker text-[#123F7A]">
                        Aktivitas
                    </p>

                    <h2
                        class="
                            dashboard-display
                            text-3xl
                            font-semibold
                            text-[#123F7A]
                        "
                    >
                        BA Rampung Terbaru
                    </h2>

                </div>

                <a
                    href="{{ route('ba-rampung.index') }}"
                    class="
                        text-sm
                        font-semibold
                        text-[#123F7A]
                        hover:text-orange-500
                        transition
                    "
                >
                    Lihat Semua →
                </a>

            </div>


            <div class="overflow-x-auto">

                <table class="w-full text-sm">

                    <thead>

                        <tr
                            class="
                                border-b
                                border-slate-100
                                text-[11px]
                                uppercase
                                tracking-wider
                                text-slate-400
                            "
                        >

                            <th class="py-3 text-left">
                                No
                            </th>

                            <th class="py-3 text-left">
                                Nomor BA
                            </th>

                            <th class="py-3 text-left">
                                Gudang
                            </th>

                            <th class="py-3 text-left">
                                Status
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @foreach($baTerbaru as $key => $ba)

                            <tr
                                class="
                                    activity-row
                                    border-b
                                    border-slate-50
                                    transition
                                "
                            >

                                <td class="py-4 text-slate-400">
                                    {{ $key + 1 }}
                                </td>

                                <td class="py-4 font-semibold text-[#123F7A]">
                                    {{ $ba->nomor_ba }}
                                </td>

                                <td class="py-4 text-slate-600">
                                    {{ $ba->gudang->nama_gudang ?? '-' }}
                                </td>

                                <td class="py-4">

                                    <x-status-badge
                                        :color="$ba->statusBadgeColor()"
                                        :label="$ba->statusLabel()"
                                    />

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>


        {{-- QUICK ACTION --}}
        <div
            class="
                soft-card
                rounded-3xl
                p-6
            "
        >

            <div>

                <p class="dashboard-kicker text-[#123F7A]">
                    Shortcut
                </p>

                <h2
                    class="
                        dashboard-display
                        text-3xl
                        font-semibold
                        text-[#123F7A]
                    "
                >
                    Quick Action
                </h2>

            </div>


            <div class="grid grid-cols-1 gap-3 mt-6">

                <a
                    href="{{ route('ba-rampung.create') }}"
                    class="
                        group
                        rounded-2xl
                        bg-[#123F7A]
                        text-white
                        p-4
                        flex
                        items-center
                        justify-between
                        hover:bg-[#0D315F]
                        transition
                    "
                >

                    <div class="flex items-center gap-3">

                        <span
                            class="
                                w-10
                                h-10
                                rounded-xl
                                bg-white/10
                                flex
                                items-center
                                justify-center
                            "
                        >
                            📄
                        </span>

                        <span>
                            <span class="block text-sm font-semibold">
                                Buat BA Rampung
                            </span>

                            <span class="block text-xs text-white/60 mt-1">
                                Buat dokumen baru
                            </span>
                        </span>

                    </div>

                    <span class="text-xl group-hover:translate-x-1 transition">
                        →
                    </span>

                </a>


                <a
                    href="{{ route('gudang.index') }}"
                    class="
                        rounded-2xl
                        border
                        border-slate-200
                        p-4
                        flex
                        items-center
                        gap-3
                        text-[#123F7A]
                        hover:border-[#123F7A]
                        hover:bg-blue-50
                        transition
                    "
                >

                    <span
                        class="
                            w-10
                            h-10
                            rounded-xl
                            bg-orange-50
                            flex
                            items-center
                            justify-center
                        "
                    >
                        🏠
                    </span>

                    <span>

                        <span class="block text-sm font-semibold">
                            Kelola Gudang
                        </span>

                        <span class="block text-xs text-slate-400 mt-1">
                            Master data gudang
                        </span>

                    </span>

                </a>


                <a
                    href="{{ route('mitra.index') }}"
                    class="
                        rounded-2xl
                        border
                        border-slate-200
                        p-4
                        flex
                        items-center
                        gap-3
                        text-[#123F7A]
                        hover:border-[#123F7A]
                        hover:bg-blue-50
                        transition
                    "
                >

                    <span
                        class="
                            w-10
                            h-10
                            rounded-xl
                            bg-blue-50
                            flex
                            items-center
                            justify-center
                        "
                    >
                        🤝
                    </span>

                    <span>

                        <span class="block text-sm font-semibold">
                            Kelola Mitra
                        </span>

                        <span class="block text-xs text-slate-400 mt-1">
                            Master data mitra
                        </span>

                    </span>

                </a>

            </div>


            {{-- TIPS --}}
            <div
                class="
                    mt-5
                    rounded-2xl
                    bg-orange-50
                    border
                    border-orange-100
                    p-4
                "
            >

                <div class="flex gap-3">

                    <div class="text-xl">
                        💡
                    </div>

                    <div>

                        <p class="text-sm font-semibold text-[#123F7A]">
                            Tips
                        </p>

                        <p class="text-xs text-slate-500 leading-5 mt-1">
                            Pastikan data gudang dan mitra selalu
                            diperbarui agar proses verifikasi lebih cepat.
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </section>


    {{-- =====================================================
        AKTIVITAS SISTEM
    ====================================================== --}}
    <section
        class="
            soft-card
            rounded-3xl
            p-6
        "
    >

        <div class="flex items-center justify-between mb-5">

            <div>

                <p class="dashboard-kicker text-[#123F7A]">
                    Sistem
                </p>

                <h2
                    class="
                        dashboard-display
                        text-3xl
                        font-semibold
                        text-[#123F7A]
                    "
                >
                    Aktivitas Terbaru
                </h2>

            </div>

        </div>


        <div class="space-y-1">

            @foreach($aktivitasTerbaru as $log)

                <div
                    class="
                        activity-row
                        flex
                        gap-4
                        items-start
                        rounded-2xl
                        p-4
                        transition
                    "
                >

                    <span
                        class="
                            mt-2
                            w-2
                            h-2
                            rounded-full
                            bg-orange-400
                            flex-shrink-0
                        "
                    ></span>

                    <div class="flex-1">

                        <p class="text-sm text-slate-700">

                            <b class="text-[#123F7A]">
                                {{ $log->user->name ?? 'System' }}
                            </b>

                            {{ $log->aktivitas }}

                        </p>

                        <p class="text-xs text-slate-400 mt-1">
                            {{ $log->created_at->diffForHumans() }}
                        </p>

                    </div>

                </div>

            @endforeach

        </div>

    </section>

</div>


{{-- =========================================================
    CHART.JS
    LOGIKA LAMA TETAP DIPERTAHANKAN
========================================================= --}}

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

document.addEventListener('DOMContentLoaded', function () {

    // ======================================================
    // BAR CHART BA PER BULAN
    // ======================================================

    const chartPerBulan =
        document.getElementById('chartPerBulan');

    if (chartPerBulan) {

        new Chart(chartPerBulan, {

            type: 'bar',

            data: {

                labels: @json(
                    collect($perBulan)->pluck('bulan')
                ),

                datasets: [{

                    label: 'Jumlah BA',

                    data: @json(
                        collect($perBulan)->pluck('jumlah')
                    ),

                    backgroundColor: '#123F7A',

                    borderRadius: 10,

                    barThickness: 25

                }]

            },

            options: {

                responsive: true,

                maintainAspectRatio: false,

                plugins: {

                    legend: {
                        display: false
                    }

                },

                scales: {

                    x: {

                        grid: {
                            display: false
                        },

                        ticks: {
                            font: {
                                family: 'Manrope'
                            }
                        }

                    },

                    y: {

                        beginAtZero: true,

                        ticks: {

                            precision: 0,

                            font: {
                                family: 'Manrope'
                            }

                        },

                        grid: {
                            color: 'rgba(18,63,122,.08)'
                        }

                    }

                }

            }

        });

    }


    // ======================================================
    // DONUT GUDANG
    // ======================================================

    const chartGudang =
        document.getElementById('chartGudang');

    if (chartGudang) {

        new Chart(chartGudang, {

            type: 'doughnut',

            data: {

                labels: @json(
                    $distribusiGudang->pluck('nama_gudang')
                ),

                datasets: [{

                    data: @json(
                        $distribusiGudang->pluck('jumlah')
                    ),

                    backgroundColor: [

                        '#123F7A',
                        '#2B67A5',
                        '#F59E0B',
                        '#4A90D9',
                        '#F97316'

                    ],

                    borderWidth: 0

                }]

            },

            options: {

                responsive: true,

                maintainAspectRatio: false,

                cutout: '70%',

                plugins: {

                    legend: {

                        display: false

                    }

                }

            }

        });

    }

});

</script>

@endsection