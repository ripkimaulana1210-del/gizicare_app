<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'GiziCare') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-100">

    <!-- 🔥 NAVBAR CUSTOM -->
    <nav class="bg-green-600 text-white px-6 py-4 flex justify-between items-center shadow">
        <div class="font-bold text-lg">
            🥗 GiziCare
        </div>

        <div class="space-x-6">
            <a href="/dashboard" class="hover:underline">Dashboard</a>
            <a href="/pencatatan" class="hover:underline">Pencatatan</a>
            <a href="/edukasi" class="hover:underline">Edukasi</a>
            <a href="/diagnosis" class="hover:underline">Diagnosis</a>
        </div>

        <div class="flex items-center gap-3">
            <span>{{ auth()->user()->name ?? 'User' }}</span>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="bg-red-500 px-3 py-1 rounded">
                    Logout
                </button>
            </form>
        </div>
    </nav>

    <!-- 🔥 HEADER (OPSIONAL) -->
    @isset($header)
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-4 px-6">
                {{ $header }}
            </div>
        </header>
    @endisset

    <!-- 🔥 CONTENT (INI YANG PENTING BUAT $slot) -->
    <main class="p-6">
        {{ $slot }}
    </main>

</body>

</html>
