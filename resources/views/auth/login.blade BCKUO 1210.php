<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login | BA Rampung Perum BULOG</title>

    <!-- GOOGLE FONT -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600&family=Manrope:wght@400;500;600;700&display=swap"
        rel="stylesheet"
    >

    <style>

        /* =====================================================
           RESET
        ====================================================== */

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
            font-family: 'Manrope', sans-serif;
            background: #153b2b;
        }


        /* =====================================================
           MAIN
        ====================================================== */

        .login-page {
            position: relative;

            width: 100%;
            height: 100vh;

            overflow: hidden;

            background: #153b2b;
        }


        /* =====================================================
           VIDEO BACKGROUND
        ====================================================== */

        .background-video {
            position: absolute;

            inset: 0;

            width: 100%;
            height: 100%;

            object-fit: cover;

            z-index: 1;
        }


        /* =====================================================
           BACKGROUND OVERLAY
        ====================================================== */

        .overlay {
            position: absolute;

            inset: 0;

            z-index: 2;

            background:
                linear-gradient(
                    90deg,
                    rgba(11, 36, 21, 0.20) 0%,
                    rgba(11, 36, 21, 0.05) 45%,
                    rgba(11, 36, 21, 0.46) 100%
                );

            pointer-events: none;
        }


        /* =====================================================
           DARK SOFT CENTER
        ====================================================== */

        .center-overlay {
            position: absolute;

            top: 0;
            right: 0;

            width: 48%;

            height: 100%;

            z-index: 3;

            background:
                linear-gradient(
                    90deg,
                    rgba(12, 50, 34, 0.08),
                    rgba(8, 45, 31, 0.58)
                );

            pointer-events: none;
        }


        /* =====================================================
           BLUE BULOG ACCENT
        ====================================================== */

        .blue-accent {
            position: absolute;

            top: 0;
            bottom: 0;

            right: 0;

            width: 4px;

            z-index: 15;

            background: #0877c9;

            opacity: 0.85;

            box-shadow:
                0 0 18px rgba(8,119,201,0.30);
        }


        /* =====================================================
           FRAME
        ====================================================== */

        .frame {
            position: absolute;

            inset: 12px;

            z-index: 10;

            border: 1px solid rgba(255,255,255,0.22);

            border-radius: 7px;

            pointer-events: none;
        }


        /* =====================================================
           FRAME CORNERS
        ====================================================== */

        .frame-corner {
            position: absolute;

            width: 55px;
            height: 55px;

            z-index: 11;

            pointer-events: none;
        }

        .corner-tl {
            top: 28px;
            left: 28px;

            border-top: 1px solid rgba(255,255,255,0.65);
            border-left: 1px solid rgba(255,255,255,0.65);
        }

        .corner-tr {
            top: 28px;
            right: 28px;

            border-top: 1px solid rgba(255,255,255,0.65);
            border-right: 1px solid rgba(255,255,255,0.65);
        }

        .corner-bl {
            bottom: 28px;
            left: 28px;

            border-bottom: 1px solid rgba(255,255,255,0.65);
            border-left: 1px solid rgba(255,255,255,0.65);
        }

        .corner-br {
            bottom: 28px;
            right: 28px;

            border-bottom: 1px solid rgba(255,255,255,0.65);
            border-right: 1px solid rgba(255,255,255,0.65);
        }


        /* =====================================================
           HEADER
        ====================================================== */

        .header {
            position: absolute;

            top: 0;
            left: 0;

            width: 100%;
            height: 105px;

            z-index: 20;

            color: white;
        }


        /* =====================================================
           LOGO BULOG
        ====================================================== */

        .brand-logo-link {
            position: absolute;

            top: 17px;
            left: 3.4%;

            width: 190px;
            height: 72px;

            display: flex;

            align-items: center;
            justify-content: flex-start;

            text-decoration: none;

            z-index: 25;
        }


        .brand-logo {
            display: block;

            width: 150px;
            height: 62px;

            object-fit: contain;
            object-position: left center;

            filter:
                brightness(0)
                invert(1);

            transform: scale(1.22);

            transform-origin: left center;
        }


        /* =====================================================
           BRAND RIGHT
        ====================================================== */

        .brand-right {
            position: absolute;

            top: 29px;
            right: 5.4%;

            display: flex;

            flex-direction: column;

            align-items: flex-end;

            gap: 6px;

            color: white;

            text-align: right;

            z-index: 25;
        }


        .brand-title {
            font-size: 15px;

            font-weight: 700;

            letter-spacing: 3.5px;

            line-height: 1;

            text-transform: uppercase;

            text-shadow:
                0 2px 12px rgba(0,0,0,0.38);
        }


        .brand-subtitle {
            font-size: 8px;

            font-weight: 600;

            letter-spacing: 2.5px;

            line-height: 1;

            text-transform: uppercase;

            opacity: 0.82;

            text-shadow:
                0 2px 12px rgba(0,0,0,0.38);
        }


        /* =====================================================
           HEADER LINE
        ====================================================== */

        .header-line {
            position: absolute;

            left: 0;
            right: 0;

            bottom: 0;

            height: 1px;

            background:
                linear-gradient(
                    90deg,
                    rgba(255,255,255,0.15),
                    rgba(8,119,201,0.45),
                    rgba(255,255,255,0.15)
                );
        }


        /* =====================================================
           LOGIN AREA
        ====================================================== */

        .login-area {
            position: absolute;

            top: 50%;
            right: 8%;

            transform: translateY(-48%);

            width: min(490px, 38vw);

            z-index: 15;

            color: white;
        }


        /* =====================================================
           SMALL LABEL
        ====================================================== */

        .login-label {
            margin-bottom: 12px;

            font-size: 9px;

            font-weight: 700;

            letter-spacing: 4px;

            text-transform: uppercase;

            color: rgba(255,255,255,0.72);
        }


        /* =====================================================
           BLUE SMALL LINE
        ====================================================== */

        .login-accent {
            display: flex;

            align-items: center;

            gap: 8px;

            margin-bottom: 13px;
        }


        .login-accent-main {
            width: 38px;
            height: 2px;

            background: #0877c9;
        }


        .login-accent-small {
            width: 7px;
            height: 2px;

            background: rgba(255,255,255,0.65);
        }


        /* =====================================================
           LOGIN TITLE
        ====================================================== */

        .login-title {
            font-family: 'Cormorant Garamond', serif;

            font-size: clamp(65px, 5.5vw, 88px);

            font-weight: 400;

            line-height: 0.86;

            letter-spacing: -1px;

            color: #fff;

            margin-bottom: 20px;

            text-shadow:
                0 4px 25px rgba(0,0,0,0.30);
        }


        /* =====================================================
           DESCRIPTION
        ====================================================== */

        .login-description {
            max-width: 430px;

            margin-bottom: 31px;

            font-size: 11px;

            font-weight: 400;

            line-height: 1.75;

            letter-spacing: 0.15px;

            color: rgba(255,255,255,0.78);
        }


        /* =====================================================
           FORM
        ====================================================== */

        .login-form {
            width: 100%;
        }


        /* =====================================================
           ERROR
        ====================================================== */

        .error-message {
            margin-bottom: 17px;

            padding: 11px 14px;

            border-left: 2px solid #0877c9;

            background: rgba(255,255,255,0.10);

            color: #fff;

            font-size: 10px;

            line-height: 1.5;

            border-radius: 2px;
        }


        /* =====================================================
           FIELD
        ====================================================== */

        .field {
            margin-bottom: 20px;
        }


        .field-label {
            display: block;

            margin-bottom: 8px;

            font-size: 9px;

            font-weight: 700;

            letter-spacing: 1.8px;

            text-transform: uppercase;

            color: rgba(255,255,255,0.88);
        }


        /* =====================================================
           INPUT WRAPPER
        ====================================================== */

        .input-wrap {
            position: relative;

            width: 100%;
        }


        /* =====================================================
           INPUT
        ====================================================== */

        .input {
            width: 100%;

            height: 53px;

            padding: 0 20px;

            border: 1px solid rgba(255,255,255,0.55);

            border-radius: 16px;

            outline: none;

            background: rgba(248,246,238,0.96);

            color: #173b2c;

            font-family: 'Manrope', sans-serif;

            font-size: 12px;

            transition:
                border-color 0.25s ease,
                box-shadow 0.25s ease,
                background 0.25s ease;
        }


        .input::placeholder {
            color: rgba(23,59,44,0.42);
        }


        .input:focus {
            border-color: #0877c9;

            background: #fffdf7;

            box-shadow:
                0 0 0 3px rgba(8,119,201,0.16);
        }


        /* =====================================================
           PASSWORD INPUT
        ====================================================== */

        .password-input {
            padding-right: 58px;
        }


        /* =====================================================
           PASSWORD TOGGLE
        ====================================================== */

        .password-toggle {
            position: absolute;

            top: 50%;
            right: 17px;

            transform: translateY(-50%);

            width: 27px;
            height: 27px;

            border: 0;

            background: transparent;

            color: #527267;

            cursor: pointer;

            display: flex;

            align-items: center;
            justify-content: center;

            transition:
                color 0.2s ease,
                transform 0.2s ease;
        }


        .password-toggle:hover {
            color: #0877c9;

            transform:
                translateY(-50%)
                scale(1.05);
        }


        .password-toggle svg {
            width: 17px;
            height: 17px;
        }


        /* =====================================================
           REMEMBER
        ====================================================== */

        .remember-row {
            display: flex;

            align-items: center;

            gap: 9px;

            margin-top: -3px;

            margin-bottom: 24px;
        }


        .remember-checkbox {
            appearance: none;

            width: 15px;
            height: 15px;

            border: 1px solid rgba(255,255,255,0.72);

            border-radius: 4px;

            background: rgba(255,255,255,0.10);

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

            color: rgba(255,255,255,0.70);

            cursor: pointer;
        }


        /* =====================================================
           LOGIN BUTTON
        ====================================================== */

        .login-button {
            position: relative;

            width: 100%;

            height: 57px;

            padding: 0 9px 0 22px;

            display: flex;

            align-items: center;

            justify-content: space-between;

            border: 0;

            border-radius: 18px;

            background: #f7f3e8;

            color: #173b2c;

            cursor: pointer;

            font-family: 'Manrope', sans-serif;

            font-size: 9px;

            font-weight: 800;

            letter-spacing: 3px;

            text-transform: uppercase;

            box-shadow:
                0 13px 30px rgba(0,0,0,0.18);

            transition:
                transform 0.25s ease,
                box-shadow 0.25s ease,
                background 0.25s ease;
        }


        .login-button:hover {
            transform: translateY(-2px);

            background: #fffdf8;

            box-shadow:
                0 17px 36px rgba(0,0,0,0.24);
        }


        /* =====================================================
           BUTTON ARROW
        ====================================================== */

        .button-arrow {
            width: 40px;
            height: 40px;

            display: flex;

            align-items: center;
            justify-content: center;

            border-radius: 50%;

            background: #0877c9;

            color: white;

            font-size: 17px;

            font-weight: 400;

            letter-spacing: 0;

            box-shadow:
                0 4px 12px rgba(8,119,201,0.25);

            transition:
                transform 0.25s ease,
                background 0.25s ease;
        }


        .login-button:hover .button-arrow {
            transform: translateX(3px);

            background: #076aae;
        }


        /* =====================================================
           BOTTOM INFORMATION
        ====================================================== */

        .login-footer {
            margin-top: 29px;

            display: flex;

            align-items: flex-end;

            justify-content: space-between;

            gap: 30px;
        }


        .footer-left {
            display: flex;

            flex-direction: column;

            gap: 4px;
        }


        .footer-title {
            font-size: 8px;

            font-weight: 700;

            letter-spacing: 1.8px;

            text-transform: uppercase;

            color: rgba(255,255,255,0.82);
        }


        .footer-subtitle {
            font-size: 7px;

            color: rgba(255,255,255,0.48);
        }


        .footer-right {
            font-size: 7px;

            color: rgba(255,255,255,0.48);

            white-space: nowrap;
        }


        /* =====================================================
           LEFT SIDE DECORATION
        ====================================================== */

        .side-label {
            position: absolute;

            left: 2.7%;
            bottom: 78px;

            z-index: 15;

            writing-mode: vertical-rl;

            transform: rotate(180deg);

            font-size: 8px;

            font-weight: 700;

            letter-spacing: 3px;

            text-transform: uppercase;

            color: rgba(255,255,255,0.75);

            text-shadow:
                0 2px 10px rgba(0,0,0,0.30);
        }


        .side-line {
            position: absolute;

            left: 2.8%;
            bottom: 41px;

            width: 38px;
            height: 1px;

            background: rgba(255,255,255,0.65);

            z-index: 15;
        }


        .bottom-left {
            position: absolute;

            left: 5.2%;
            bottom: 30px;

            z-index: 15;

            display: flex;

            align-items: center;

            gap: 9px;

            color: rgba(255,255,255,0.88);

            font-size: 8px;

            font-weight: 700;

            letter-spacing: 2px;

            text-transform: uppercase;

            text-shadow:
                0 2px 10px rgba(0,0,0,0.35);
        }


        .bottom-dot {
            width: 4px;
            height: 4px;

            border-radius: 50%;

            background: #0877c9;

            box-shadow:
                0 0 8px rgba(8,119,201,0.70);
        }


        /* =====================================================
           BLUE SMALL DECORATION
        ====================================================== */

        .blue-detail {
            position: absolute;

            left: 5.2%;
            top: 50%;

            width: 25px;
            height: 2px;

            background: #0877c9;

            z-index: 15;

            opacity: 0.85;
        }


        /* =====================================================
           GRAIN
        ====================================================== */

        .grain {
            position: absolute;

            inset: 0;

            z-index: 30;

            pointer-events: none;

            opacity: 0.018;

            background-image:
                url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='180' height='180'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.8' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='.8'/%3E%3C/svg%3E");

            mix-blend-mode: soft-light;
        }


        /* =====================================================
           TABLET
        ====================================================== */

        @media (max-width: 1000px) {

            .login-area {
                right: 7%;

                width: min(450px, 43vw);
            }

            .brand-logo-link {
                left: 3%;
            }

            .brand-right {
                right: 4%;
            }

        }


        /* =====================================================
           MOBILE
        ====================================================== */

        @media (max-width: 700px) {

            body {
                overflow: auto;
            }


            .login-page {
                min-height: 100vh;

                height: auto;

                overflow-y: auto;
            }


            .center-overlay {
                width: 100%;

                background:
                    linear-gradient(
                        180deg,
                        rgba(8,43,29,0.25),
                        rgba(8,43,29,0.82)
                    );
            }


            .blue-accent {
                display: none;
            }


            .header {
                height: 90px;
            }


            .brand-logo-link {
                left: 22px;
                top: 15px;

                width: 105px;
                height: 52px;
            }


            .brand-logo {
                width: 105px;
                height: 52px;

                transform: scale(1.12);
            }


            .brand-right {
                top: 23px;
                right: 22px;

                gap: 5px;
            }


            .brand-title {
                font-size: 9px;

                letter-spacing: 2px;
            }


            .brand-subtitle {
                font-size: 6px;

                letter-spacing: 1.3px;
            }


            .login-area {
                position: relative;

                top: auto;
                right: auto;

                transform: none;

                width: calc(100% - 44px);

                margin: 145px auto 70px;
            }


            .login-title {
                font-size: 63px;
            }


            .login-description {
                font-size: 10px;
            }


            .side-label,
            .side-line,
            .bottom-left {
                display: none;
            }


            .frame {
                inset: 8px;
            }


            .frame-corner {
                width: 35px;
                height: 35px;
            }


            .corner-tl,
            .corner-tr {
                top: 22px;
            }


            .corner-bl,
            .corner-br {
                bottom: 22px;
            }


            .corner-tl,
            .corner-bl {
                left: 22px;
            }


            .corner-tr,
            .corner-br {
                right: 22px;
            }

        }

    </style>
</head>


<body>

<div class="login-page">


    <!-- =====================================================
         VIDEO BACKGROUND
    ====================================================== -->

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

        Browser kamu tidak mendukung video.

    </video>


    <!-- =====================================================
         OVERLAY
    ====================================================== -->

    <div class="overlay"></div>

    <div class="center-overlay"></div>


    <!-- =====================================================
         BLUE BULOG ACCENT
    ====================================================== -->

    <div class="blue-accent"></div>


    <!-- =====================================================
         FRAME
    ====================================================== -->

    <div class="frame"></div>


    <div class="frame-corner corner-tl"></div>
    <div class="frame-corner corner-tr"></div>
    <div class="frame-corner corner-bl"></div>
    <div class="frame-corner corner-br"></div>


    <!-- =====================================================
         HEADER
    ====================================================== -->

    <header class="header">

        <!-- LOGO BULOG -->

        <a
            href="{{ url('/') }}"
            class="brand-logo-link"
        >

            <img
                src="{{ asset('images/logobulog.png') }}"
                alt="Logo BULOG"
                class="brand-logo"
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


        <div class="header-line"></div>

    </header>


    <!-- =====================================================
         LEFT DECORATION
    ====================================================== -->

    <div class="side-label">
        Sistem Administrasi
    </div>

    <div class="side-line"></div>


    <div class="blue-detail"></div>


    <!-- =====================================================
         LOGIN CONTENT
    ====================================================== -->

    <main class="login-area">


        <!-- LABEL -->

        <div class="login-label">
            Sistem Administrasi Digital
        </div>


        <!-- BLUE ACCENT -->

        <div class="login-accent">

            <span class="login-accent-main"></span>

            <span class="login-accent-small"></span>

        </div>


        <!-- TITLE -->

        <h1 class="login-title">
            Login
        </h1>


        <!-- DESCRIPTION -->

        <p class="login-description">
            Silakan masuk untuk melanjutkan ke sistem
            administrasi berita acara rampung
            Perum BULOG Cabang Indramayu.
        </p>


        <!-- =================================================
             ERROR
        ================================================== -->

        @if ($errors->any())

            <div class="error-message">

                {{ $errors->first() }}

            </div>

        @endif


        <!-- =================================================
             LOGIN FORM
        ================================================== -->

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
                        autofocus
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


                    <!-- PASSWORD TOGGLE -->

                    <button
                        type="button"
                        class="password-toggle"
                        id="passwordToggle"
                        aria-label="Tampilkan password"
                    >

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


                        <svg
                            id="eyeClosed"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.7"
                            style="display:none;"
                        >

                            <path
                                d="M3 3l18 18"
                            />

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


            <!-- REMEMBER ME -->

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


            <!-- BUTTON -->

            <button
                type="submit"
                class="login-button"
            >

                <span>
                    Masuk
                </span>


                <span class="button-arrow">
                    →
                </span>

            </button>

        </form>


        <!-- =================================================
             FOOTER LOGIN
        ================================================== -->

        <div class="login-footer">

            <div class="footer-left">

                <div class="footer-title">
                    BA Rampung
                </div>

                <div class="footer-subtitle">
                    Perum BULOG Cabang Indramayu
                </div>

            </div>


            <div class="footer-right">
                © {{ date('Y') }} Perum BULOG
            </div>

        </div>


    </main>


    <!-- =====================================================
         BOTTOM LEFT
    ====================================================== -->

    <div class="bottom-left">

        <span class="bottom-dot"></span>

        <span>
            Pangan untuk Indonesia
        </span>

    </div>


    <!-- =====================================================
         GRAIN
    ====================================================== -->

    <div class="grain"></div>


</div>


<!-- =========================================================
     PASSWORD SCRIPT
========================================================= -->

<script>

    const passwordInput =
        document.getElementById('password');

    const passwordToggle =
        document.getElementById('passwordToggle');

    const eyeOpen =
        document.getElementById('eyeOpen');

    const eyeClosed =
        document.getElementById('eyeClosed');


    if (
        passwordInput &&
        passwordToggle &&
        eyeOpen &&
        eyeClosed
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


                eyeOpen.style.display =
                    isPassword
                        ? 'none'
                        : 'block';


                eyeClosed.style.display =
                    isPassword
                        ? 'block'
                        : 'none';


                passwordToggle.setAttribute(
                    'aria-label',
                    isPassword
                        ? 'Sembunyikan password'
                        : 'Tampilkan password'
                );

            }
        );

    }

</script>


</body>

</html>