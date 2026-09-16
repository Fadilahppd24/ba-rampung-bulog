<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>BA Rampung | Perum BULOG</title>

    <!-- FONT -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600&family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet">


    <style>

        /* =========================================================
           RESET
        ========================================================= */

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            width: 100%;
            height: 100%;
        }

        body {
            overflow: hidden;
            background: #173f2d;
            font-family: 'Manrope', sans-serif;
        }


        /* =========================================================
           PAGE
        ========================================================= */

        .page {
            position: relative;

            width: 100%;
            height: 100vh;

            overflow: hidden;

            background: #173f2d;
        }


        /* =========================================================
           VIDEO
        ========================================================= */

        .background-video {
            position: absolute;

            inset: 0;

            width: 100%;
            height: 100%;

            object-fit: cover;

            z-index: 1;
        }


        /* =========================================================
           OVERLAY
        ========================================================= */

        .dark-overlay {
            position: absolute;

            inset: 0;

            z-index: 2;

            background:
                linear-gradient(
                    90deg,
                    rgba(8, 32, 20, 0.08) 0%,
                    rgba(8, 32, 20, 0.10) 50%,
                    rgba(8, 32, 20, 0.45) 100%
                );

            transition:
                background 1s ease;
        }


        /* =========================================================
           LOGIN OVERLAY
           muncul perlahan saat masuk mode login
        ========================================================= */

        .login-dark-overlay {
            position: absolute;

            inset: 0;

            z-index: 3;

            opacity: 0;

            pointer-events: none;

            background:
                linear-gradient(
                    90deg,
                    rgba(14, 54, 37, 0.04),
                    rgba(9, 53, 37, 0.64)
                );

            transition:
                opacity 1s cubic-bezier(.22,.61,.36,1);
        }


        .page.login-mode .login-dark-overlay {
            opacity: 1;
        }


        /* =========================================================
           FRAME
        ========================================================= */

        .frame {
            position: absolute;

            inset: 12px;

            z-index: 20;

            border: 1px solid rgba(255,255,255,0.23);

            border-radius: 7px;

            pointer-events: none;
        }


        /* =========================================================
           FRAME CORNERS
        ========================================================= */

        .corner {
            position: absolute;

            width: 56px;
            height: 56px;

            z-index: 21;

            pointer-events: none;
        }


        .corner.tl {
            top: 28px;
            left: 28px;

            border-top: 1px solid rgba(255,255,255,0.72);
            border-left: 1px solid rgba(255,255,255,0.72);
        }


        .corner.tr {
            top: 28px;
            right: 28px;

            border-top: 1px solid rgba(255,255,255,0.72);
            border-right: 1px solid rgba(255,255,255,0.72);
        }


        .corner.bl {
            bottom: 28px;
            left: 28px;

            border-bottom: 1px solid rgba(255,255,255,0.72);
            border-left: 1px solid rgba(255,255,255,0.72);
        }


        .corner.br {
            bottom: 28px;
            right: 28px;

            border-bottom: 1px solid rgba(255,255,255,0.72);
            border-right: 1px solid rgba(255,255,255,0.72);
        }


        /* =========================================================
           HEADER
        ========================================================= */

        .header {
            position: absolute;

            top: 0;
            left: 0;

            width: 100%;
            height: 104px;

            z-index: 30;

            border-bottom: 1px solid rgba(255,255,255,0.20);
        }


        /* =========================================================
           BULOG LOGO
        ========================================================= */

        .bulog-logo {
            position: absolute;

            left: 5.8%;
            top: 27px;

            width: 125px;
            height: 55px;

            object-fit: contain;

            object-position: left center;

            filter:
                brightness(0)
                invert(1);

            transform: scale(1.12);

            transform-origin: left center;

            transition:
                transform .5s ease;
        }


        .page.login-mode .bulog-logo {
            transform:
                scale(1.12)
                translateX(-4px);
        }


        /* =========================================================
           BRAND RIGHT
        ========================================================= */

        .brand-right {
            position: absolute;

            top: 30px;
            right: 5.8%;

            display: flex;

            flex-direction: column;

            align-items: flex-end;

            gap: 6px;

            color: white;

            text-align: right;
        }


        .brand-title {
            font-size: 15px;

            font-weight: 700;

            letter-spacing: 3.5px;

            line-height: 1;

            text-transform: uppercase;

            text-shadow:
                0 2px 12px rgba(0,0,0,.35);
        }


        .brand-subtitle {
            font-size: 8px;

            font-weight: 600;

            letter-spacing: 2.5px;

            line-height: 1;

            text-transform: uppercase;

            opacity: .82;
        }


        /* =========================================================
           BLUE BULOG ACCENT
        ========================================================= */

        .blue-line {
            position: absolute;

            left: 5.8%;
            top: 103px;

            width: 34px;
            height: 2px;

            background: #0877c9;

            z-index: 31;

            transition:
                width .7s ease;
        }


        .page.login-mode .blue-line {
            width: 58px;
        }


        /* =========================================================
           SIDE LABEL
        ========================================================= */

        .side-label {
            position: absolute;

            left: 2.7%;
            bottom: 76px;

            z-index: 15;

            writing-mode: vertical-rl;

            transform: rotate(180deg);

            color: rgba(255,255,255,.78);

            font-size: 8px;

            font-weight: 700;

            letter-spacing: 3px;

            text-transform: uppercase;

            text-shadow:
                0 2px 10px rgba(0,0,0,.35);
        }


        /* =========================================================
           BOTTOM LEFT
        ========================================================= */

        .bottom-left {
            position: absolute;

            left: 5.2%;
            bottom: 29px;

            z-index: 15;

            display: flex;

            align-items: center;

            gap: 9px;

            color: rgba(255,255,255,.88);

            font-size: 8px;

            font-weight: 700;

            letter-spacing: 2px;

            text-transform: uppercase;
        }


        .bottom-dot {
            width: 5px;
            height: 5px;

            border-radius: 50%;

            background: #0877c9;

            box-shadow:
                0 0 10px rgba(8,119,201,.65);
        }


        /* =========================================================
           BOTTOM RIGHT
        ========================================================= */

        .copyright {
            position: absolute;

            right: 5.8%;
            bottom: 29px;

            z-index: 15;

            color: rgba(255,255,255,.78);

            font-size: 8px;

            font-weight: 600;

            letter-spacing: 1.8px;

            text-transform: uppercase;
        }


        /* =========================================================
           WELCOME CONTENT
        ========================================================= */

        .welcome-content {
            position: absolute;

            left: 50%;
            top: 50%;

            transform:
                translate(-50%, -45%);

            width: min(850px, 80vw);

            z-index: 25;

            text-align: center;

            color: white;

            transition:
                opacity .65s cubic-bezier(.22,.61,.36,1),
                transform .85s cubic-bezier(.22,.61,.36,1),
                filter .65s ease;
        }


        /* =========================================================
           WELCOME STATE
        ========================================================= */

        .welcome-small {
            margin-bottom: 17px;

            font-size: 9px;

            font-weight: 700;

            letter-spacing: 5px;

            text-transform: uppercase;

            color: rgba(255,255,255,.82);

            opacity: 0;

            animation:
                welcomeFade .9s .15s forwards;
        }


        .welcome-title {
            font-family: 'Cormorant Garamond', serif;

            font-size: clamp(75px, 7vw, 112px);

            font-weight: 400;

            line-height: .82;

            letter-spacing: -1px;

            color: #fff;

            text-shadow:
                0 5px 30px rgba(0,0,0,.30);

            opacity: 0;

            animation:
                welcomeTitle .95s .2s forwards;
        }


        .welcome-title span {
            display: block;
        }


        .welcome-divider {
            width: 42px;
            height: 1px;

            margin: 25px auto 18px;

            background: rgba(255,255,255,.65);

            position: relative;
        }


        .welcome-divider::after {
            content: '';

            position: absolute;

            left: 50%;

            top: 0;

            width: 10px;
            height: 1px;

            transform:
                translateX(-50%);

            background: #0877c9;
        }


        .welcome-description {
            max-width: 600px;

            margin: 0 auto 30px;

            font-size: 11px;

            line-height: 1.7;

            color: rgba(255,255,255,.82);

            opacity: 0;

            animation:
                welcomeFade .8s .55s forwards;
        }


        /* =========================================================
           ENTER BUTTON
        ========================================================= */

        .enter-button {
            width: 150px;
            height: 54px;

            border: 0;

            border-radius: 18px;

            padding: 0 8px 0 22px;

            display: flex;

            align-items: center;

            justify-content: space-between;

            margin: 0 auto;

            background: #f7f3e8;

            color: #173f2d;

            font-family: 'Manrope', sans-serif;

            font-size: 9px;

            font-weight: 800;

            letter-spacing: 3px;

            text-transform: uppercase;

            cursor: pointer;

            box-shadow:
                0 15px 35px rgba(0,0,0,.20);

            opacity: 0;

            animation:
                welcomeButton .8s .75s forwards;

            transition:
                transform .3s ease,
                box-shadow .3s ease;
        }


        .enter-button:hover {
            transform: translateY(-3px);

            box-shadow:
                0 20px 40px rgba(0,0,0,.27);
        }


        .enter-arrow {
            width: 38px;
            height: 38px;

            border-radius: 50%;

            display: flex;

            align-items: center;
            justify-content: center;

            background: #0877c9;

            color: white;

            font-size: 16px;

            transition:
                transform .3s ease;
        }


        .enter-button:hover .enter-arrow {
            transform: translateX(3px);
        }


        /* =========================================================
           LOGIN CONTENT
        ========================================================= */

        .login-content {
            position: absolute;

            top: 50%;

            right: 8%;

            width: min(470px, 38vw);

            transform:
                translateY(-43%)
                translateX(80px);

            z-index: 26;

            color: white;

            opacity: 0;

            pointer-events: none;

            filter: blur(8px);

            transition:
                opacity .8s .35s cubic-bezier(.22,.61,.36,1),
                transform 1s .25s cubic-bezier(.22,.61,.36,1),
                filter .8s .35s ease;
        }


        /* =========================================================
           LOGIN MODE
        ========================================================= */

        .page.login-mode .welcome-content {
            opacity: 0;

            transform:
                translate(-50%, -50%)
                scale(.94)
                translateY(-20px);

            filter: blur(5px);

            pointer-events: none;
        }


        .page.login-mode .login-content {
            opacity: 1;

            pointer-events: auto;

            transform:
                translateY(-43%)
                translateX(0);

            filter: blur(0);
        }


        /* =========================================================
           LOGIN LABEL
        ========================================================= */

        .login-small {
            margin-bottom: 13px;

            font-size: 9px;

            font-weight: 700;

            letter-spacing: 4px;

            text-transform: uppercase;

            color: rgba(255,255,255,.72);
        }


        /* =========================================================
           LOGIN BLUE ACCENT
        ========================================================= */

        .login-accent {
            display: flex;

            align-items: center;

            gap: 7px;

            margin-bottom: 11px;
        }


        .login-accent-blue {
            width: 40px;
            height: 2px;

            background: #0877c9;
        }


        .login-accent-white {
            width: 8px;
            height: 2px;

            background: rgba(255,255,255,.55);
        }


        /* =========================================================
           LOGIN TITLE
        ========================================================= */

        .login-title {
            font-family: 'Cormorant Garamond', serif;

            font-size: clamp(68px, 5.7vw, 88px);

            font-weight: 400;

            line-height: .82;

            color: #fff;

            margin-bottom: 20px;

            text-shadow:
                0 5px 25px rgba(0,0,0,.28);
        }


        /* =========================================================
           LOGIN DESCRIPTION
        ========================================================= */

        .login-description {
            max-width: 440px;

            margin-bottom: 27px;

            font-size: 11px;

            line-height: 1.75;

            color: rgba(255,255,255,.78);
        }


        /* =========================================================
           FORM
        ========================================================= */

        .login-form {
            width: 100%;
        }


        /* =========================================================
           ERROR
        ========================================================= */

        .error-message {
            margin-bottom: 16px;

            padding: 10px 13px;

            border-left: 2px solid #0877c9;

            background: rgba(255,255,255,.10);

            border-radius: 3px;

            color: white;

            font-size: 10px;
        }


        /* =========================================================
           FIELD
        ========================================================= */

        .field {
            margin-bottom: 17px;
        }


        .field-label {
            display: block;

            margin-bottom: 7px;

            font-size: 8px;

            font-weight: 800;

            letter-spacing: 1.8px;

            text-transform: uppercase;

            color: rgba(255,255,255,.88);
        }


        /* =========================================================
           INPUT
        ========================================================= */

        .input-wrap {
            position: relative;
        }


        .input {
            width: 100%;

            height: 52px;

            border: 1px solid rgba(255,255,255,.65);

            border-radius: 16px;

            outline: none;

            padding: 0 20px;

            background: rgba(247,244,235,.96);

            color: #183c2c;

            font-family: 'Manrope', sans-serif;

            font-size: 12px;

            transition:
                border .25s ease,
                box-shadow .25s ease,
                background .25s ease;
        }


        .input::placeholder {
            color: rgba(24,60,44,.42);
        }


        .input:focus {
            background: #fffdf8;

            border-color: #0877c9;

            box-shadow:
                0 0 0 3px rgba(8,119,201,.18);
        }


        .password-input {
            padding-right: 55px;
        }


        /* =========================================================
           PASSWORD BUTTON
        ========================================================= */

        .password-toggle {
            position: absolute;

            top: 50%;
            right: 15px;

            width: 30px;
            height: 30px;

            transform:
                translateY(-50%);

            display: flex;

            align-items: center;
            justify-content: center;

            border: 0;

            background: transparent;

            color: #55776a;

            cursor: pointer;

            transition:
                color .2s ease;
        }


        .password-toggle:hover {
            color: #0877c9;
        }


        .password-toggle svg {
            width: 17px;
            height: 17px;
        }


        /* =========================================================
           REMEMBER
        ========================================================= */

        .remember-row {
            display: flex;

            align-items: center;

            gap: 8px;

            margin-top: 2px;

            margin-bottom: 22px;
        }


        .remember-checkbox {
            appearance: none;

            width: 15px;
            height: 15px;

            border: 1px solid rgba(255,255,255,.75);

            border-radius: 4px;

            background: rgba(255,255,255,.08);

            cursor: pointer;

            position: relative;
        }


        .remember-checkbox:checked {
            background: #0877c9;

            border-color: #0877c9;
        }


        .remember-checkbox:checked::after {
            content: '';

            position: absolute;

            left: 4px;
            top: 1px;

            width: 4px;
            height: 8px;

            border:
                solid white;

            border-width:
                0 2px 2px 0;

            transform: rotate(45deg);
        }


        .remember-label {
            font-size: 9px;

            color: rgba(255,255,255,.72);

            cursor: pointer;
        }


        /* =========================================================
           LOGIN BUTTON
        ========================================================= */

        .login-button {
            width: 100%;

            height: 55px;

            border: 0;

            border-radius: 17px;

            padding: 0 9px 0 22px;

            display: flex;

            align-items: center;

            justify-content: space-between;

            background: #f7f3e8;

            color: #173f2d;

            font-family: 'Manrope', sans-serif;

            font-size: 9px;

            font-weight: 800;

            letter-spacing: 3px;

            text-transform: uppercase;

            cursor: pointer;

            box-shadow:
                0 15px 35px rgba(0,0,0,.18);

            transition:
                transform .3s ease,
                box-shadow .3s ease;
        }


        .login-button:hover {
            transform: translateY(-2px);

            box-shadow:
                0 19px 40px rgba(0,0,0,.25);
        }


        .login-arrow {
            width: 38px;
            height: 38px;

            border-radius: 50%;

            display: flex;

            align-items: center;
            justify-content: center;

            background: #0877c9;

            color: white;

            font-size: 16px;

            transition:
                transform .3s ease;
        }


        .login-button:hover .login-arrow {
            transform: translateX(3px);
        }


        /* =========================================================
           LOGIN FOOTER
        ========================================================= */

        .login-footer {
            margin-top: 23px;

            display: flex;

            justify-content: space-between;

            align-items: flex-end;
        }


        .footer-title {
            font-size: 8px;

            font-weight: 800;

            letter-spacing: 1.8px;

            text-transform: uppercase;

            color: rgba(255,255,255,.82);

            margin-bottom: 4px;
        }


        .footer-subtitle {
            font-size: 7px;

            color: rgba(255,255,255,.50);
        }


        .footer-year {
            font-size: 7px;

            color: rgba(255,255,255,.50);
        }


        /* =========================================================
           BLUE DECORATION
        ========================================================= */

        .blue-decoration {
            position: absolute;

            left: 5.2%;

            top: 50%;

            width: 27px;
            height: 2px;

            background: #0877c9;

            z-index: 15;

            opacity: .8;

            transition:
                opacity .4s ease,
                transform .5s ease;
        }


        .page.login-mode .blue-decoration {
            opacity: 0;

            transform: translateX(-20px);
        }


        /* =========================================================
           GRAIN
        ========================================================= */

        .grain {
            position: absolute;

            inset: 0;

            z-index: 40;

            pointer-events: none;

            opacity: .018;

            background-image:
                url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='180' height='180'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.8' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='.8'/%3E%3C/svg%3E");

            mix-blend-mode: soft-light;
        }


        /* =========================================================
           ANIMATIONS WELCOME
        ========================================================= */

        @keyframes welcomeFade {

            from {
                opacity: 0;

                transform:
                    translateY(14px);
            }

            to {
                opacity: 1;

                transform:
                    translateY(0);
            }

        }


        @keyframes welcomeTitle {

            from {
                opacity: 0;

                transform:
                    translateY(30px)
                    scale(.96);
            }

            to {
                opacity: 1;

                transform:
                    translateY(0)
                    scale(1);
            }

        }


        @keyframes welcomeButton {

            from {
                opacity: 0;

                transform:
                    translateY(20px);
            }

            to {
                opacity: 1;

                transform:
                    translateY(0);
            }

        }


        /* =========================================================
           MOBILE
        ========================================================= */

        @media (max-width: 700px) {

            body {
                overflow: hidden;
            }


            .frame {
                inset: 8px;
            }


            .corner {
                width: 36px;
                height: 36px;
            }


            .corner.tl,
            .corner.tr {
                top: 21px;
            }


            .corner.bl,
            .corner.br {
                bottom: 21px;
            }


            .corner.tl,
            .corner.bl {
                left: 21px;
            }


            .corner.tr,
            .corner.br {
                right: 21px;
            }


            .header {
                height: 91px;
            }


            .bulog-logo {
                left: 22px;
                top: 21px;

                width: 90px;
                height: 45px;
            }


            .brand-right {
                right: 22px;

                top: 28px;
            }


            .brand-title {
                font-size: 9px;

                letter-spacing: 2px;
            }


            .brand-subtitle {
                font-size: 6px;

                letter-spacing: 1.4px;
            }


            .blue-line {
                left: 22px;

                top: 90px;
            }


            .welcome-content {
                width: calc(100% - 44px);

                top: 49%;
            }


            .welcome-small {
                font-size: 7px;

                letter-spacing: 3px;
            }


            .welcome-title {
                font-size: 62px;
            }


            .welcome-description {
                font-size: 9px;

                max-width: 320px;
            }


            .login-content {
                top: 50%;

                right: auto;
                left: 50%;

                width: calc(100% - 44px);

                transform:
                    translate(-50%, -40%)
                    translateX(50px);
            }


            .page.login-mode .login-content {
                transform:
                    translate(-50%, -40%)
                    translateX(0);
            }


            .login-title {
                font-size: 62px;
            }


            .login-description {
                font-size: 9px;
            }


            .side-label,
            .bottom-left,
            .copyright,
            .blue-decoration {
                display: none;
            }

        }

    </style>
</head>


<body>


<div
    class="page"
    id="page"
>


    <!-- =========================================================
         BACKGROUND VIDEO
    ========================================================== -->

    <video
        class="background-video"
        autoplay
        muted
        loop
        playsinline
        preload="auto"
    >

        <source
            src="{{ asset('videos/welcome.mp4') }}"
            type="video/mp4"
        >

    </video>


    <!-- =========================================================
         OVERLAYS
    ========================================================== -->

    <div class="dark-overlay"></div>

    <div class="login-dark-overlay"></div>


    <!-- =========================================================
         FRAME
    ========================================================== -->

    <div class="frame"></div>

    <div class="corner tl"></div>
    <div class="corner tr"></div>
    <div class="corner bl"></div>
    <div class="corner br"></div>


    <!-- =========================================================
         HEADER
    ========================================================== -->

    <header class="header">


        <!-- BULOG -->

        <a href="{{ url('/') }}">

            <img
                src="{{ asset('images/logobulog.png') }}"
                alt="BULOG"
                class="bulog-logo"
            >

        </a>


        <!-- PERUM BULOG -->

        <div class="brand-right">

            <div class="brand-title">
                PERUM BULOG
            </div>

            <div class="brand-subtitle">
                CABANG INDRAMAYU
            </div>

        </div>


    </header>


    <!-- BLUE LINE -->

    <div class="blue-line"></div>


    <!-- =========================================================
         SIDE LABEL
    ========================================================== -->

    <div class="side-label">
        Sistem Administrasi
    </div>


    <!-- =========================================================
         BLUE DECORATION
    ========================================================== -->

    <div class="blue-decoration"></div>


    <!-- =========================================================
         WELCOME CONTENT
    ========================================================== -->

    <section
        class="welcome-content"
        id="welcomeContent"
    >


        <div class="welcome-small">
            Perum BULOG · Cabang Indramayu
        </div>


        <h1 class="welcome-title">

            <span>BA RAMPUNG</span>

        </h1>


        <div class="welcome-divider"></div>


        <p class="welcome-description">

            Sistem administrasi digital untuk pengelolaan
            berita acara rampung yang tertib, mudah,
            dan terintegrasi.

        </p>


        <button
            type="button"
            class="enter-button"
            id="enterButton"
        >

            <span>
                Masuk
            </span>

            <span class="enter-arrow">
                →
            </span>

        </button>


    </section>


    <!-- =========================================================
         LOGIN CONTENT
    ========================================================== -->

    <section
        class="login-content"
        id="loginContent"
    >


        <!-- LOGIN LABEL -->

        <div class="login-small">
            Perum BULOG · Cabang Indramayu
        </div>


        <!-- BLUE ACCENT -->

        <div class="login-accent">

            <span class="login-accent-blue"></span>

            <span class="login-accent-white"></span>

        </div>


        <!-- LOGIN TITLE -->

        <h1 class="login-title">
            Login
        </h1>


        <!-- DESCRIPTION -->

        <p class="login-description">

            Silakan masuk untuk melanjutkan ke sistem
            administrasi berita acara rampung
            Perum BULOG Cabang Indramayu.

        </p>


        <!-- ERROR -->

        @if ($errors->any())

            <div class="error-message">

                {{ $errors->first() }}

            </div>

        @endif


        <!-- =====================================================
             LOGIN FORM
        ====================================================== -->

        <form
            method="POST"
            action="{{ route('login.attempt') }}"
            class="login-form"
        >

            @csrf


            <!-- EMAIL -->

            <div class="field">

                <label
                    for="email"
                    class="field-label"
                >
                    Email / Username
                </label>


                <div class="input-wrap">

                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        class="input"
                        placeholder="Masukkan email"
                        autocomplete="username"
                        required
                    >

                </div>

            </div>


            <!-- PASSWORD -->

            <div class="field">

                <label
                    for="password"
                    class="field-label"
                >
                    Password
                </label>


                <div class="input-wrap">

                    <input
                        id="password"
                        type="password"
                        name="password"
                        class="input password-input"
                        placeholder="Masukkan password"
                        autocomplete="current-password"
                        required
                    >


                    <button
                        type="button"
                        class="password-toggle"
                        id="passwordToggle"
                        aria-label="Tampilkan password"
                    >

                        <!-- EYE OPEN -->

                        <svg
                            id="eyeOpen"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.7"
                        >

                            <path
                                d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6S2 12 2 12Z"
                            />

                            <circle
                                cx="12"
                                cy="12"
                                r="2.8"
                            />

                        </svg>


                        <!-- EYE CLOSED -->

                        <svg
                            id="eyeClosed"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.7"
                            style="display:none;"
                        >

                            <path d="M3 3l18 18"/>

                            <path
                                d="M10.6 5.2A10.9 10.9 0 0 1 12 5c6.5 0 10 7 10 7a17.6 17.6 0 0 1-3.1 3.9"
                            />

                            <path
                                d="M6.2 6.3C3.5 8.1 2 12 2 12s3.5 7 10 7c1.4 0 2.7-.3 3.8-.8"
                            />

                        </svg>

                    </button>

                </div>

            </div>


            <!-- REMEMBER -->

            <div class="remember-row">

                <input
                    type="checkbox"
                    name="remember"
                    id="remember"
                    value="1"
                    class="remember-checkbox"
                    {{ old('remember') ? 'checked' : '' }}
                >

                <label
                    for="remember"
                    class="remember-label"
                >
                    Ingat saya
                </label>

            </div>


            <!-- SUBMIT -->

            <button
                type="submit"
                class="login-button"
            >

                <span>
                    Masuk
                </span>

                <span class="login-arrow">
                    →
                </span>

            </button>


        </form>


        <!-- LOGIN FOOTER -->

        <div class="login-footer">


            <div>

                <div class="footer-title">
                    BA Rampung
                </div>

                <div class="footer-subtitle">
                    Perum BULOG Cabang Indramayu
                </div>

            </div>


            <div class="footer-year">
                © {{ date('Y') }} Perum BULOG
            </div>


        </div>


    </section>


    <!-- =========================================================
         BOTTOM LEFT
    ========================================================== -->

    <div class="bottom-left">

        <span class="bottom-dot"></span>

        <span>
            Indramayu · Jawa Barat
        </span>

    </div>


    <!-- =========================================================
         COPYRIGHT
    ========================================================== -->

    <div class="copyright">

        © {{ date('Y') }} Perum BULOG

    </div>


    <!-- GRAIN -->

    <div class="grain"></div>


</div>


<!-- =============================================================
     JAVASCRIPT
============================================================= -->

<script>

    /* =========================================================
       ELEMENTS
    ========================================================== */

    const page =
        document.getElementById('page');

    const enterButton =
        document.getElementById('enterButton');

    const passwordInput =
        document.getElementById('password');

    const passwordToggle =
        document.getElementById('passwordToggle');

    const eyeOpen =
        document.getElementById('eyeOpen');

    const eyeClosed =
        document.getElementById('eyeClosed');


    /* =========================================================
       WELCOME -> LOGIN
    ========================================================== */

    if (enterButton) {

        enterButton.addEventListener(
            'click',
            function () {

                page.classList.add('login-mode');


                /*
                 * Setelah animasi selesai,
                 * fokus otomatis ke email.
                 */

                setTimeout(
                    function () {

                        const email =
                            document.getElementById('email');

                        if (email) {

                            email.focus();

                        }

                    },
                    1050
                );

            }
        );

    }


    /* =========================================================
       PASSWORD SHOW / HIDE
    ========================================================== */

    if (
        passwordInput &&
        passwordToggle
    ) {

        passwordToggle.addEventListener(
            'click',
            function () {

                const isPassword =
                    passwordInput.type === 'password';


                passwordInput.type =
                    isPassword
                        ? 'text'
                        : 'password';


                if (eyeOpen) {

                    eyeOpen.style.display =
                        isPassword
                            ? 'none'
                            : 'block';

                }


                if (eyeClosed) {

                    eyeClosed.style.display =
                        isPassword
                            ? 'block'
                            : 'none';

                }


                passwordToggle.setAttribute(
                    'aria-label',
                    isPassword
                        ? 'Sembunyikan password'
                        : 'Tampilkan password'
                );

            }
        );

    }


    /* =========================================================
       ESC -> KEMBALI KE WELCOME
    ========================================================== */

    document.addEventListener(
        'keydown',
        function (event) {

            if (
                event.key === 'Escape' &&
                page.classList.contains('login-mode')
            ) {

                page.classList.remove('login-mode');

            }

        }
    );

</script>


</body>

</html>