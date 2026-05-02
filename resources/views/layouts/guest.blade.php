<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'GiziCare')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/app.css?v={{ filemtime(public_path('css/app.css')) }}">
</head>
<body class="auth-body">

    <div class="auth-shell">
        <div class="auth-visual" aria-hidden="true">
            <div class="auth-visual__content">
                <span class="auth-visual__tag">GiziCare</span>
                <h1>Pemantauan gizi keluarga yang terasa ringan.</h1>
                <div class="auth-visual__metrics">
                    <span>Catatan</span>
                    <strong>Rapi</strong>
                    <span>Edukasi</span>
                    <strong>Praktis</strong>
                </div>
            </div>
        </div>

        <div class="auth-panel">
            <div class="auth-brand">
                <a href="{{ route('home') }}" class="brand-link">
                    <span class="brand-mark">GC</span>
                    <span class="brand-title">GiziCare</span>
                </a>
            </div>

            <div class="auth-card">
                @yield('content')
            </div>
        </div>
    </div>

</body>
</html>
