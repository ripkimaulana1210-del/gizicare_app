@extends('layouts.guest')

@section('title', 'Lupa Password — GiziCare')

@section('content')
<h2 class="text-xl font-bold text-center text-gray-800 mb-1">Lupa Password?</h2>
<p class="text-center text-sm text-gray-500 mb-5">Masukkan email untuk mendapatkan link reset</p>

@if (session('status'))
    <div class="mb-4 text-sm text-green-600 bg-green-50 rounded-lg px-3 py-2">{{ session('status') }}</div>
@endif

<form method="POST" action="{{ route('password.email') }}">
    @csrf
    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
        <input type="email" name="email" value="{{ old('email') }}" required autofocus
               class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:border-green-500 focus:ring-1 focus:ring-green-500 outline-none text-sm">
        @error('email')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
    </div>

    <button type="submit" class="w-full py-2.5 rounded-lg bg-green-500 text-white font-semibold hover:bg-green-600 transition text-sm">
        Kirim Link Reset
    </button>
</form>

<p class="text-center text-sm text-gray-500 mt-5">
    <a href="{{ route('login') }}" class="text-green-600 hover:underline">← Kembali ke login</a>
</p>
@endsection

