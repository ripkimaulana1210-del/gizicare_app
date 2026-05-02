@extends('layouts.guest')

@section('title', 'Lupa Password - GiziCare')

@section('content')
<h2 class="auth-title">Lupa Password?</h2>
<p class="auth-copy">Masukkan email untuk mendapatkan link reset password.</p>

@if (session('status'))
    <div class="auth-status">{{ session('status') }}</div>
@endif

<form method="POST" action="{{ route('password.email') }}" class="auth-form">
    @csrf
    <div class="auth-field">
        <label>Email</label>
        <input type="email" name="email" value="{{ old('email') }}" required autofocus class="auth-input">
        @error('email')<p class="auth-error">{{ $message }}</p>@enderror
    </div>

    <button type="submit" class="btn-app btn-primary btn-large w-full">
        Kirim Link Reset
    </button>
</form>

<p class="auth-switch">
    <a href="{{ route('login') }}" class="auth-link">Kembali ke login</a>
</p>
@endsection
