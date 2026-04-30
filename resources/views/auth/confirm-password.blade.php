@extends('layouts.guest')

@section('title', 'Konfirmasi Password — GiziCare')

@section('content')
<h2 class="text-xl font-bold text-center text-gray-800 mb-5">Konfirmasi Password</h2>

<form method="POST" action="{{ route('password.confirm') }}">
    @csrf
    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
        <input type="password" name="password" required autofocus
               class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:border-green-500 focus:ring-1 focus:ring-green-500 outline-none text-sm">
        @error('password')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
    </div>

    <button type="submit" class="w-full py-2.5 rounded-lg bg-green-500 text-white font-semibold hover:bg-green-600 transition text-sm">
        Konfirmasi
    </button>
</form>
@endsection

