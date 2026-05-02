@extends('layouts.guest')

@section('title', 'Reset Password - GiziCare')

@section('content')
<h2 class="auth-title">Reset Password</h2>
<p class="auth-copy">Buat password baru untuk melanjutkan akses akun.</p>

<form method="POST" action="{{ route('password.store') }}" class="auth-form">
    @csrf
    <input type="hidden" name="token" value="{{ $request->route('token') }}">

    <div class="auth-field">
        <label>Email</label>
        <input type="email" name="email" value="{{ old('email', $request->email) }}" required class="auth-input">
        @error('email')<p class="auth-error">{{ $message }}</p>@enderror
    </div>

    <div class="auth-field">
        <label>Password Baru</label>
        <input type="password" name="password" required autofocus class="auth-input">
        @error('password')<p class="auth-error">{{ $message }}</p>@enderror
    </div>

    <div class="auth-field">
        <label>Konfirmasi Password</label>
        <input type="password" name="password_confirmation" required class="auth-input">
    </div>

    <button type="submit" class="btn-app btn-primary btn-large w-full">
        Reset Password
    </button>
</form>
@endsection
