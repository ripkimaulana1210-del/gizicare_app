@extends('layouts.guest')

@section('title', 'Reset Password — GiziCare')

@section('content')
<h2 class="text-xl font-bold text-center text-gray-800 mb-1">Reset Password</h2>
<p class="text-center text-sm text-gray-500 mb-5">Buat password baru</p>

<form method="POST" action="{{ route('password.store') }}">
    @csrf
    <input type="hidden" name="token" value="{{ $request->route('token') }}">

    <div class="mb-3">
        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
        <input type="email" name="email" value="{{ old('email', $request->email) }}" required
               class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:border-green-500 focus:ring-1 focus:ring-green-500 outline-none text-sm">
        @error('email')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
    </div>

    <div class="mb-3">
        <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
        <input type="password" name="password" required autofocus
               class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:border-green-500 focus:ring-1 focus:ring-green-500 outline-none text-sm">
        @error('password')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
    </div>

    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
        <input type="password" name="password_confirmation" required
               class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:border-green-500 focus:ring-1 focus:ring-green-500 outline-none text-sm">
    </div>

    <button type="submit" class="w-full py-2.5 rounded-lg bg-green-500 text-white font-semibold hover:bg-green-600 transition text-sm">
        Reset Password
    </button>
</form>
@endsection

