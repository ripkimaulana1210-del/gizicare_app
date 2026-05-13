<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'GiziCare')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/app.css?v={{ filemtime(public_path('css/app.css')) }}">
    <link rel="stylesheet" href="/css/refresh.css?v={{ filemtime(public_path('css/refresh.css')) }}">
</head>
<body class="app-body">

    {{-- Navbar --}}
    <nav class="site-navbar">
        <div class="site-navbar__inner">
            <a href="{{ route('home') }}" class="brand-link" aria-label="GiziCare home">
                <span class="brand-mark" aria-hidden="true">
                    <img src="{{ asset('images/logo.png') }}" alt="" class="brand-logo" width="40" height="40">
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
                    ['label' => 'Beranda', 'url' => route('home'), 'pattern' => 'home', 'icon' => 'home'],
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

    <div class="page-loading-overlay" data-page-loading aria-hidden="true">
        <span class="page-loading-spinner" role="status" aria-label="Memuat halaman"></span>
    </div>

    <script>
        (() => {
            const toggle = document.querySelector('[data-nav-toggle]');
            const nav = document.querySelector('[data-site-nav]');
            const pageLoading = document.querySelector('[data-page-loading]');

            if (!toggle || !nav) {
                return;
            }

            const links = Array.from(nav.querySelectorAll('.site-nav__link'));
            const desktopNavQuery = window.matchMedia('(min-width: 981px)');
            const reducedMotionQuery = window.matchMedia('(prefers-reduced-motion: reduce)');
            const navigationDelay = 620;
            let slidingTimer = null;
            let loadingTimer = null;

            const getActiveLink = () => nav.querySelector('.site-nav__link.is-active') || links[0] || null;

            const canUseActiveIndicator = () => desktopNavQuery.matches && nav.offsetWidth > 0;

            const setIndicator = (link, animate = true) => {
                if (!link || !canUseActiveIndicator()) {
                    nav.classList.remove('has-active-indicator');
                    return;
                }

                nav.classList.add('has-active-indicator');
                nav.classList.toggle('is-indicator-primed', !animate);
                nav.style.setProperty('--site-nav-active-x', `${link.offsetLeft}px`);
                nav.style.setProperty('--site-nav-active-width', `${link.offsetWidth}px`);

                if (!animate) {
                    requestAnimationFrame(() => nav.classList.remove('is-indicator-primed'));
                }
            };

            const syncIndicator = () => {
                setIndicator(getActiveLink());
            };

            const setActiveLink = (activeLink) => {
                links.forEach((item) => {
                    const isActive = item === activeLink;
                    item.classList.toggle('is-active', isActive);

                    if (isActive) {
                        item.setAttribute('aria-current', 'page');
                    } else {
                        item.removeAttribute('aria-current');
                    }
                });
            };

            const clearSlidingState = () => {
                nav.classList.remove('is-indicator-sliding');
            };

            const startSlidingState = () => {
                window.clearTimeout(slidingTimer);
                nav.classList.add('is-indicator-sliding');
                slidingTimer = window.setTimeout(clearSlidingState, 700);
            };

            const showPageLoading = (delay = 0) => {
                window.clearTimeout(loadingTimer);
                loadingTimer = window.setTimeout(() => {
                    document.body.classList.add('is-page-loading');
                    pageLoading?.setAttribute('aria-hidden', 'false');
                }, delay);
            };

            const hidePageLoading = () => {
                window.clearTimeout(loadingTimer);
                document.body.classList.remove('is-page-loading');
                pageLoading?.setAttribute('aria-hidden', 'true');
            };

            setIndicator(getActiveLink(), false);

            toggle.addEventListener('click', () => {
                const expanded = toggle.getAttribute('aria-expanded') === 'true';
                toggle.setAttribute('aria-expanded', String(!expanded));
                nav.classList.toggle('is-open', !expanded);
                requestAnimationFrame(syncIndicator);
            });

            links.forEach((link) => {
                link.addEventListener('click', (event) => {
                    if (!event.metaKey && !event.ctrlKey && !event.shiftKey && !event.altKey) {
                        const targetUrl = new URL(link.href, window.location.href);
                        const canDelayNavigation =
                            canUseActiveIndicator() &&
                            !reducedMotionQuery.matches &&
                            targetUrl.origin === window.location.origin &&
                            targetUrl.href !== window.location.href;

                        startSlidingState();
                        setActiveLink(link);
                        setIndicator(link);

                        if (canDelayNavigation) {
                            event.preventDefault();
                            showPageLoading(260);

                            window.setTimeout(() => {
                                window.location.assign(targetUrl.href);
                            }, navigationDelay);
                        } else if (targetUrl.href !== window.location.href) {
                            showPageLoading();
                        }
                    }

                    toggle.setAttribute('aria-expanded', 'false');
                    nav.classList.remove('is-open');
                });
            });

            window.addEventListener('resize', syncIndicator);
            window.addEventListener('pageshow', hidePageLoading);
            desktopNavQuery.addEventListener?.('change', syncIndicator);
        })();

        (() => {
            const pageLoading = document.querySelector('[data-page-loading]');
            const showPageLoading = () => {
                document.body.classList.add('is-page-loading');
                pageLoading?.setAttribute('aria-hidden', 'false');
            };
            const hidePageLoading = () => {
                document.body.classList.remove('is-page-loading');
                pageLoading?.setAttribute('aria-hidden', 'true');
            };

            document.addEventListener('click', (event) => {
                const link = event.target.closest('a[href]');

                if (
                    !link ||
                    link.classList.contains('site-nav__link') ||
                    event.defaultPrevented ||
                    event.metaKey ||
                    event.ctrlKey ||
                    event.shiftKey ||
                    event.altKey ||
                    link.target === '_blank' ||
                    link.hasAttribute('download')
                ) {
                    return;
                }

                const targetUrl = new URL(link.href, window.location.href);

                if (targetUrl.origin === window.location.origin && targetUrl.href !== window.location.href) {
                    showPageLoading();
                }
            });

            document.querySelectorAll('form').forEach((form) => {
                form.addEventListener('submit', (event) => {
                    if (event.defaultPrevented || form.hasAttribute('data-no-page-loading')) {
                        return;
                    }

                    showPageLoading();
                });
            });

            window.addEventListener('pageshow', hidePageLoading);
        })();
    </script>

</body>
</html>
