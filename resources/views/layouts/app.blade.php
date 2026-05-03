<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'GiziCare')</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/gizicare-logo.svg') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/app.css?v={{ filemtime(public_path('css/app.css')) }}">
</head>
<body class="app-body">

    {{-- Navbar --}}
    <nav class="site-navbar">
        <div class="site-navbar__inner">
            <a href="{{ route('home') }}" class="brand-link" aria-label="GiziCare home">
                <span class="brand-mark" aria-hidden="true">
                    <img src="{{ asset('images/gizicare-logo.svg') }}" alt="" class="brand-logo" width="40" height="40">
                </span>
                <span class="brand-title">GiziCare</span>
            </a>

            <button
                type="button"
                class="site-nav-toggle"
                aria-controls="siteNav"
                aria-expanded="false"
                data-nav-toggle
            >
                <span></span>
                <span></span>
                <span></span>
            </button>

            @php
                $navItems = [
                    ['label' => 'Home', 'url' => route('home'), 'pattern' => 'home', 'icon' => 'home'],
                    ['label' => 'Edukasi', 'url' => route('edukasi.index'), 'pattern' => 'edukasi.*', 'icon' => 'book'],
                    ['label' => 'Pencatatan', 'url' => route('pencatatan.index'), 'pattern' => 'pencatatan.*', 'icon' => 'chart'],
                    ['label' => 'Diagnosis', 'url' => route('diagnosis'), 'pattern' => 'diagnosis', 'icon' => 'chat'],
                ];
            @endphp

            <div class="site-nav" id="siteNav" aria-label="Navigasi utama" data-site-nav>
                @foreach ($navItems as $item)
                    @php($isActive = request()->routeIs($item['pattern']))
                    <a
                        href="{{ $item['url'] }}"
                        class="site-nav__link {{ $isActive ? 'is-active' : '' }}"
                        @if($isActive) aria-current="page" @endif
                    >
                        <span class="site-nav__icon" aria-hidden="true" data-icon="{{ $item['icon'] }}"></span>
                        {{ $item['label'] }}
                    </a>
                @endforeach
            </div>

            <div class="site-actions">
                @auth
                    <span class="site-user">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button class="btn-app btn-danger">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn-app btn-ghost">Masuk</a>
                    <a href="{{ route('register') }}" class="btn-app btn-primary">Daftar</a>
                @endauth
            </div>
        </div>
    </nav>

    @hasSection('header')
        <div class="app-header">
            <div class="app-header__inner">
                @yield('header')
            </div>
        </div>
    @endif

    {{-- Content --}}
    <main class="app-main">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="site-footer">
        <span>&copy; {{ date('Y') }} GiziCare</span>
        <span class="site-footer__dot" aria-hidden="true"></span>
        <span>Pemantauan gizi keluarga yang rapi dan mudah dipahami.</span>
    </footer>

    <script>
        (() => {
            const toggle = document.querySelector('[data-nav-toggle]');
            const nav = document.querySelector('[data-site-nav]');

            if (!toggle || !nav) {
                return;
            }

            toggle.addEventListener('click', () => {
                const expanded = toggle.getAttribute('aria-expanded') === 'true';
                toggle.setAttribute('aria-expanded', String(!expanded));
                nav.classList.toggle('is-open', !expanded);
            });

            nav.querySelectorAll('a').forEach((link) => {
                link.addEventListener('click', () => {
                    toggle.setAttribute('aria-expanded', 'false');
                    nav.classList.remove('is-open');
                });
            });
        })();
    </script>

</body>
</html>
