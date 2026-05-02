@extends('layouts.guest')

@section('title', 'Verifikasi Email - GiziCare')

@section('content')
<h2 class="auth-title">Verifikasi Email</h2>
<p class="auth-copy">Klik link di email untuk mengaktifkan akun GiziCare.</p>

@if (session('status') == 'verification-link-sent')
    <div class="auth-status">Link verifikasi baru telah dikirim.</div>
@endif

<p class="auth-copy">Tidak menerima email? Kirim ulang link verifikasi dari tombol di bawah.</p>

<form method="POST" action="{{ route('verification.send') }}" class="auth-form">
    @csrf
    <button type="submit" class="btn-app btn-primary btn-large w-full">
        Kirim Ulang Email
    </button>
</form>

<form method="POST" action="{{ route('logout') }}" class="auth-form auth-logout-form">
    @csrf
    <button type="submit" class="btn-app btn-ghost btn-large w-full">
        Logout
    </button>
</form>
@endsection
