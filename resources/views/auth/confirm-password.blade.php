@extends('layouts.guest')

@section('title', 'Konfirmasi Password - GiziCare')

@section('content')
<h2 class="auth-title">Konfirmasi Password</h2>
<p class="auth-copy">Masukkan password untuk melanjutkan tindakan ini.</p>

<form method="POST" action="{{ route('password.confirm') }}" class="auth-form">
    @csrf
    <div class="auth-field">
        <label>Password</label>
        <input type="password" name="password" required autofocus class="auth-input">
        @error('password')<p class="auth-error">{{ $message }}</p>@enderror
    </div>

    <button type="submit" class="btn-app btn-primary btn-large w-full">
        Konfirmasi
    </button>
</form>
@endsection
