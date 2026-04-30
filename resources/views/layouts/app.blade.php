<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'GiziCare')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="app-body">

    {{-- Navbar --}}
    <nav class="site-navbar">
        <div class="site-navbar__inner">
            <a href="{{ route('home') }}" class="brand-link" aria-label="GiziCare home">
                <span class="brand-mark">GC</span>
                <span class="brand-title">GiziCare</span>
            </a>

            @php
                $navItems = [
                    ['label' => 'Home', 'url' => route('home'), 'pattern' => 'home'],
                    ['label' => 'Edukasi', 'url' => route('edukasi.index'), 'pattern' => 'edukasi.*'],
                    ['label' => 'Pencatatan', 'url' => route('pencatatan.index'), 'pattern' => 'pencatatan.*'],
                    ['label' => 'Diagnosis', 'url' => route('diagnosis'), 'pattern' => 'diagnosis'],
                ];
            @endphp

            <div class="site-nav" aria-label="Navigasi utama">
                @foreach ($navItems as $item)
                    @php($isActive = request()->routeIs($item['pattern']))
                    <a
                        href="{{ $item['url'] }}"
                        class="site-nav__link {{ $isActive ? 'is-active' : '' }}"
                        @if($isActive) aria-current="page" @endif
                    >
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
        &copy; {{ date('Y') }} GiziCare
    </footer>

</body>
</html>
