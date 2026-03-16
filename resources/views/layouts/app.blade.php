<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'InfoTools') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=syne:400,500,600,700,800&family=dm-sans:400,500&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            :root {
                --black:     #0B090A;
                --dark:      #161A1D;
                --red-deep:  #660708;
                --red-mid:   #A4161A;
                --red:       #BA181B;
                --red-vivid: #E5383B;
                --gray-warm: #B1A7A6;
                --gray-light:#D3D3D3;
                --off-white: #F5F3F4;
                --white:     #FFFFFF;
            }

            * { box-sizing: border-box; margin: 0; padding: 0; }

            body {
                font-family: 'DM Sans', sans-serif;
                background-color: var(--black);
                color: var(--off-white);
                min-height: 100vh;
                overflow-x: hidden;
            }

            /* Ambient background */
            body::before {
                content: '';
                position: fixed;
                top: -20%;
                left: -10%;
                width: 60vw;
                height: 60vw;
                background: radial-gradient(circle, rgba(186,24,27,0.18) 0%, transparent 70%);
                pointer-events: none;
                z-index: 0;
            }

            body::after {
                content: '';
                position: fixed;
                bottom: -20%;
                right: -10%;
                width: 50vw;
                height: 50vw;
                background: radial-gradient(circle, rgba(102,7,8,0.15) 0%, transparent 70%);
                pointer-events: none;
                z-index: 0;
            }

            .page-wrapper {
                position: relative;
                z-index: 1;
                min-height: 100vh;
                display: flex;
                flex-direction: column;
            }

            /* ── NAVBAR ── */
            nav.glass-nav {
                position: sticky;
                top: 0;
                z-index: 100;
                background: rgba(22, 26, 29, 0.6);
                backdrop-filter: blur(20px);
                -webkit-backdrop-filter: blur(20px);
                border-bottom: 1px solid rgba(229,56,59,0.15);
                padding: 0 2rem;
                height: 64px;
                display: flex;
                align-items: center;
                justify-content: space-between;
            }

            .nav-brand {
                font-family: 'Syne', sans-serif;
                font-weight: 800;
                font-size: 1.25rem;
                letter-spacing: -0.02em;
                color: var(--white);
                text-decoration: none;
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }

            .nav-brand span {
                color: var(--red-vivid);
            }

            .nav-brand::before {
                content: '';
                display: block;
                width: 8px;
                height: 8px;
                border-radius: 50%;
                background: var(--red-vivid);
                box-shadow: 0 0 8px var(--red-vivid);
                animation: pulse 2s infinite;
            }

            @keyframes pulse {
                0%, 100% { opacity: 1; transform: scale(1); }
                50% { opacity: 0.6; transform: scale(0.8); }
            }

            .nav-links {
                display: flex;
                align-items: center;
                gap: 0.25rem;
            }

            .nav-link {
                font-family: 'DM Sans', sans-serif;
                font-size: 0.875rem;
                font-weight: 500;
                color: var(--gray-warm);
                text-decoration: none;
                padding: 0.4rem 0.9rem;
                border-radius: 8px;
                transition: all 0.2s ease;
                position: relative;
            }

            .nav-link:hover {
                color: var(--white);
                background: rgba(229,56,59,0.1);
            }

            .nav-link.active {
                color: var(--white);
                background: rgba(229,56,59,0.15);
            }

            .nav-link.active::after {
                content: '';
                position: absolute;
                bottom: -1px;
                left: 50%;
                transform: translateX(-50%);
                width: 20px;
                height: 2px;
                background: var(--red-vivid);
                border-radius: 2px;
            }

            /* User dropdown */
            .nav-user {
                position: relative;
            }

            .nav-user-btn {
                display: flex;
                align-items: center;
                gap: 0.5rem;
                background: rgba(229,56,59,0.1);
                border: 1px solid rgba(229,56,59,0.2);
                border-radius: 10px;
                padding: 0.4rem 0.75rem;
                cursor: pointer;
                color: var(--off-white);
                font-family: 'DM Sans', sans-serif;
                font-size: 0.875rem;
                font-weight: 500;
                transition: all 0.2s;
            }

            .nav-user-btn:hover {
                background: rgba(229,56,59,0.2);
                border-color: rgba(229,56,59,0.4);
            }

            .nav-user-btn .avatar {
                width: 28px;
                height: 28px;
                border-radius: 7px;
                background: linear-gradient(135deg, var(--red-mid), var(--red-deep));
                display: flex;
                align-items: center;
                justify-content: center;
                font-family: 'Syne', sans-serif;
                font-weight: 700;
                font-size: 0.75rem;
                color: white;
            }

            .nav-dropdown {
                position: absolute;
                right: 0;
                top: calc(100% + 8px);
                background: rgba(22, 26, 29, 0.95);
                backdrop-filter: blur(20px);
                border: 1px solid rgba(229,56,59,0.15);
                border-radius: 12px;
                min-width: 200px;
                padding: 0.5rem;
                display: none;
                box-shadow: 0 20px 40px rgba(0,0,0,0.5);
            }

            .nav-dropdown.open { display: block; }

            .nav-dropdown a,
            .nav-dropdown button {
                display: flex;
                align-items: center;
                gap: 0.5rem;
                width: 100%;
                padding: 0.6rem 0.75rem;
                border-radius: 8px;
                font-family: 'DM Sans', sans-serif;
                font-size: 0.875rem;
                color: var(--gray-warm);
                text-decoration: none;
                background: none;
                border: none;
                cursor: pointer;
                transition: all 0.2s;
                text-align: left;
            }

            .nav-dropdown a:hover,
            .nav-dropdown button:hover {
                background: rgba(229,56,59,0.1);
                color: var(--white);
            }

            .nav-dropdown .divider {
                height: 1px;
                background: rgba(229,56,59,0.1);
                margin: 0.35rem 0;
            }

            .nav-dropdown .logout {
                color: var(--red-vivid);
            }

            .nav-dropdown .logout:hover {
                background: rgba(229,56,59,0.15);
                color: var(--red-vivid);
            }

            /* ── PAGE HEADER ── */
            .page-header {
                padding: 2rem 2rem 0;
                max-width: 1280px;
                margin: 0 auto;
                width: 100%;
            }

            .page-header h2 {
                font-family: 'Syne', sans-serif;
                font-weight: 700;
                font-size: 1.75rem;
                color: var(--white);
                letter-spacing: -0.03em;
            }

            .page-header h2 span {
                color: var(--red-vivid);
            }

            /* ── MAIN CONTENT ── */
            main {
                flex: 1;
                padding: 2rem;
                max-width: 1280px;
                margin: 0 auto;
                width: 100%;
            }

            /* ── GLASS CARD ── */
            .glass-card {
                background: rgba(22, 26, 29, 0.6);
                backdrop-filter: blur(16px);
                -webkit-backdrop-filter: blur(16px);
                border: 1px solid rgba(229,56,59,0.12);
                border-radius: 16px;
                padding: 1.5rem;
                transition: border-color 0.3s;
            }

            .glass-card:hover {
                border-color: rgba(229,56,59,0.25);
            }

            /* ── TABLE ── */
            table {
                width: 100%;
                border-collapse: collapse;
            }

            thead th {
                font-family: 'Syne', sans-serif;
                font-size: 0.75rem;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 0.08em;
                color: var(--gray-warm);
                padding: 0.75rem 1rem;
                text-align: left;
                border-bottom: 1px solid rgba(229,56,59,0.15);
            }

            tbody tr {
                transition: background 0.15s;
            }

            tbody tr:hover {
                background: rgba(229,56,59,0.05);
            }

            tbody td {
                padding: 0.875rem 1rem;
                font-size: 0.9rem;
                color: var(--off-white);
                border-bottom: 1px solid rgba(255,255,255,0.04);
            }

            /* ── BUTTONS ── */
            .btn-primary {
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
                background: linear-gradient(135deg, var(--red), var(--red-mid));
                color: white;
                font-family: 'DM Sans', sans-serif;
                font-size: 0.875rem;
                font-weight: 500;
                padding: 0.6rem 1.25rem;
                border-radius: 10px;
                border: none;
                cursor: pointer;
                text-decoration: none;
                transition: all 0.2s;
                box-shadow: 0 4px 15px rgba(186,24,27,0.3);
            }

            .btn-primary:hover {
                transform: translateY(-1px);
                box-shadow: 0 6px 20px rgba(186,24,27,0.45);
            }

            .btn-secondary {
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
                background: rgba(229,56,59,0.1);
                color: var(--off-white);
                font-family: 'DM Sans', sans-serif;
                font-size: 0.875rem;
                font-weight: 500;
                padding: 0.6rem 1.25rem;
                border-radius: 10px;
                border: 1px solid rgba(229,56,59,0.2);
                cursor: pointer;
                text-decoration: none;
                transition: all 0.2s;
            }

            .btn-secondary:hover {
                background: rgba(229,56,59,0.18);
                border-color: rgba(229,56,59,0.4);
            }

            .btn-danger {
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
                background: rgba(229,56,59,0.15);
                color: var(--red-vivid);
                font-family: 'DM Sans', sans-serif;
                font-size: 0.875rem;
                font-weight: 500;
                padding: 0.6rem 1.25rem;
                border-radius: 10px;
                border: 1px solid rgba(229,56,59,0.25);
                cursor: pointer;
                text-decoration: none;
                transition: all 0.2s;
            }

            .btn-danger:hover {
                background: rgba(229,56,59,0.25);
            }

            /* ── FORM INPUTS ── */
            .form-group {
                display: flex;
                flex-direction: column;
                gap: 0.4rem;
            }

            .form-label {
                font-family: 'Syne', sans-serif;
                font-size: 0.75rem;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 0.07em;
                color: var(--gray-warm);
            }

            .form-input {
                background: rgba(11,9,10,0.6);
                border: 1px solid rgba(229,56,59,0.15);
                border-radius: 10px;
                padding: 0.7rem 1rem;
                color: var(--off-white);
                font-family: 'DM Sans', sans-serif;
                font-size: 0.9rem;
                transition: all 0.2s;
                width: 100%;
            }

            .form-input:focus {
                outline: none;
                border-color: rgba(229,56,59,0.5);
                background: rgba(11,9,10,0.8);
                box-shadow: 0 0 0 3px rgba(229,56,59,0.08);
            }

            .form-input::placeholder {
                color: rgba(177,167,166,0.4);
            }

            textarea.form-input { resize: vertical; min-height: 100px; }

            /* ── ALERTS ── */
            .alert-success {
                background: rgba(34,197,94,0.1);
                border: 1px solid rgba(34,197,94,0.2);
                color: #86efac;
                padding: 0.75rem 1rem;
                border-radius: 10px;
                font-size: 0.875rem;
                margin-bottom: 1rem;
            }

            .alert-error {
                background: rgba(229,56,59,0.1);
                border: 1px solid rgba(229,56,59,0.2);
                color: var(--red-vivid);
                padding: 0.75rem 1rem;
                border-radius: 10px;
                font-size: 0.875rem;
                margin-bottom: 1rem;
            }

            /* ── EMPTY STATE ── */
            .empty-state {
                text-align: center;
                padding: 3rem 1rem;
                color: var(--gray-warm);
                font-size: 0.9rem;
            }

            .empty-state::before {
                content: '∅';
                display: block;
                font-size: 2rem;
                margin-bottom: 0.75rem;
                opacity: 0.4;
            }
        </style>
    </head>
    <body>
        <div class="page-wrapper">

            {{-- NAVBAR --}}
            <nav class="glass-nav">
                <a href="{{ route('dashboard') }}" class="nav-brand">
                    Info<span>Tools</span>
                </a>

                @auth
                <div class="nav-links">
                    <a href="{{ route('dashboard') }}"
                       class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('web.appointments.index') }}"
                       class="nav-link {{ request()->routeIs('web.appointments*') ? 'active' : '' }}">
                        Rendez-vous
                    </a>
                    <a href="{{ route('web.products.index') }}"
                       class="nav-link {{ request()->routeIs('web.products*') ? 'active' : '' }}">
                        Produits
                    </a>
                    <a href="{{ route('web.clients.index') }}"
                       class="nav-link {{ request()->routeIs('web.clients*') ? 'active' : '' }}">
                        Clients
                    </a>
                </div>

                <div class="nav-user">
                    <button class="nav-user-btn" onclick="toggleDropdown()">
                        <div class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                        {{ auth()->user()->name }}
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
                    </button>
                    <div class="nav-dropdown" id="userDropdown">
                        <a href="{{ route('profile.edit') }}">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            Profil
                        </a>
                        <div class="divider"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="logout">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                                Déconnexion
                            </button>
                        </form>
                    </div>
                </div>
                @endauth
            </nav>

            {{-- PAGE HEADER --}}
            @isset($header)
                <div class="page-header">
                    {{ $header }}
                </div>
            @endisset

            {{-- MAIN --}}
            <main>
                {{ $slot }}
            </main>
        </div>

        <script>
            function toggleDropdown() {
                document.getElementById('userDropdown').classList.toggle('open');
            }
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.nav-user')) {
                    document.getElementById('userDropdown')?.classList.remove('open');
                }
            });
        </script>
    </body>
</html>