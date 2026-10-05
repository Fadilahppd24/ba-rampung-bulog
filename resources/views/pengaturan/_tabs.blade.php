@php
    $tabs = [
        'pengaturan.users.index' => [
            'label' => 'Manajemen User',
            'icon' => 'users',
        ],
        'pengaturan.backup' => [
            'label' => 'Backup & Restore',
            'icon' => 'database',
        ],
        'pengaturan.log-aktivitas' => [
            'label' => 'Log Aktivitas',
            'icon' => 'clock',
        ],
    ];
@endphp

<style>
    /* =========================================================
       PENGATURAN TABS
    ========================================================= */

    .pengaturan-tabs {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 6px;

        padding: 5px;

        border-radius: 18px;

        /* LIGHT MODE */
        border: 1px solid rgba(15,42,74,.10);

        background: rgba(255,255,255,.96);

        box-shadow:
            0 10px 28px rgba(15,42,74,.08);

        backdrop-filter: blur(18px);
        -webkit-backdrop-filter: blur(18px);
    }


    /* =========================================================
       TAB
    ========================================================= */

    .pengaturan-tab {
        position: relative;

        display: flex;
        align-items: center;
        justify-content: center;

        gap: 10px;

        min-height: 52px;

        padding: 0 18px;

        border-radius: 14px;

        color: #64748B;

        font-size: 13px;
        font-weight: 700;

        text-decoration: none;

        transition:
            color .25s ease,
            background .25s ease,
            transform .25s ease,
            box-shadow .25s ease;
    }


    /* =========================================================
       ICON
    ========================================================= */

    .pengaturan-tab-icon {
        display: flex;
        align-items: center;
        justify-content: center;

        width: 22px;
        height: 22px;

        color: #64748B;

        transition:
            transform .3s ease,
            color .25s ease,
            filter .25s ease;
    }

    .pengaturan-tab-icon svg {
        width: 19px;
        height: 19px;

        stroke: currentColor;

        transition:
            transform .3s ease,
            stroke-width .25s ease;
    }


    /* =========================================================
       LIGHT MODE HOVER
    ========================================================= */

    .pengaturan-tab:hover {
        color: #123F7A;

        background: rgba(18,63,122,.055);

        transform: translateY(-1px);
    }

    .pengaturan-tab:hover .pengaturan-tab-icon {
        color: #F28C28;

        transform:
            translateY(-2px)
            scale(1.08);

        filter:
            drop-shadow(
                0 4px 7px
                rgba(242,140,40,.22)
            );
    }

    .pengaturan-tab:hover .pengaturan-tab-icon svg {
        transform: rotate(-3deg);
    }


    /* =========================================================
       ACTIVE
    ========================================================= */

    .pengaturan-tab.active {
        color: #FFFFFF;

        background:
            linear-gradient(
                135deg,
                #164B8F,
                #123F7A
            );

        box-shadow:
            0 6px 16px rgba(18,63,122,.22),
            inset 0 1px 0 rgba(255,255,255,.10);
    }

    .pengaturan-tab.active .pengaturan-tab-icon {
        color: #FFB454;

        animation:
            tabIconFloat 2.4s ease-in-out infinite;

        filter:
            drop-shadow(
                0 4px 8px
                rgba(242,140,40,.30)
            );
    }

    .pengaturan-tab.active .pengaturan-tab-icon svg {
        stroke-width: 2.1;
    }


    /* =========================================================
       ORANGE ACTIVE LINE
    ========================================================= */

    .pengaturan-tab.active::after {
        content: "";

        position: absolute;

        left: 50%;
        bottom: 4px;

        width: 24px;
        height: 2px;

        border-radius: 999px;

        background: #F28C28;

        transform: translateX(-50%);

        box-shadow:
            0 0 10px rgba(242,140,40,.50);

        animation:
            tabLinePulse 2s ease-in-out infinite;
    }


    /* =========================================================
       ANIMATION
    ========================================================= */

    @keyframes tabIconFloat {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-2px);
        }
    }

    @keyframes tabLinePulse {

        0%,
        100% {
            opacity: .65;

            transform:
                translateX(-50%)
                scaleX(.85);
        }

        50% {
            opacity: 1;

            transform:
                translateX(-50%)
                scaleX(1.1);
        }
    }


    /* =========================================================
       DARK MODE
    ========================================================= */

    html.dark-theme .pengaturan-tabs {

        border-color:
            rgba(148,163,184,.14);

        background:
            rgba(5,22,39,.95);

        box-shadow:
            0 18px 40px rgba(0,0,0,.24);
    }

    html.dark-theme .pengaturan-tab {

        color:
            rgba(203,213,225,.70);
    }

    html.dark-theme .pengaturan-tab-icon {

        color:
            rgba(203,213,225,.65);
    }

    html.dark-theme .pengaturan-tab:hover {

        color: #FFFFFF;

        background:
            rgba(255,255,255,.055);
    }

    html.dark-theme .pengaturan-tab.active {

        color: #FFFFFF;

        background:
            linear-gradient(
                135deg,
                #164B8F,
                #123F7A
            );
    }

    html.dark-theme .pengaturan-tab.active .pengaturan-tab-icon {

        color: #FFB454;
    }


    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media (max-width: 700px) {

        .pengaturan-tabs {
            grid-template-columns: 1fr;

            gap: 4px;
        }

        .pengaturan-tab {
            justify-content: flex-start;

            padding-left: 18px;
        }

        .pengaturan-tab.active::after {

            left: auto;
            right: 14px;

            transform: none;
        }
    }
</style>


<div class="pengaturan-tabs">

    @foreach ($tabs as $route => $tab)

        <a
            href="{{ route($route) }}"
            class="pengaturan-tab {{ request()->routeIs($route) ? 'active' : '' }}"
        >

            <span class="pengaturan-tab-icon">

                @if($tab['icon'] === 'users')

                    {{-- USER --}}
                    <svg
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>

                @elseif($tab['icon'] === 'database')

                    {{-- BACKUP --}}
                    <svg
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <ellipse cx="12" cy="5" rx="8" ry="3"/>
                        <path d="M4 5v7c0 1.66 3.58 3 8 3s8-1.34 8-3V5"/>
                        <path d="M4 12v7c0 1.66 3.58 3 8 3s8-1.34 8-3v-7"/>
                    </svg>

                @elseif($tab['icon'] === 'clock')

                    {{-- LOG --}}
                    <svg
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <circle cx="12" cy="12" r="9"/>
                        <path d="M12 7v5l3 2"/>
                    </svg>

                @endif

            </span>

            <span>
                {{ $tab['label'] }}
            </span>

        </a>

    @endforeach

</div>