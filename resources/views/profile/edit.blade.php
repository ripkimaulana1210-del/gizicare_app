@extends('layouts.app')

@section('title', 'Profil - GiziCare')

@section('header')
    <h1 class="page-title">Profil</h1>
@endsection

@section('content')
<div class="profile-stack">
    <section class="form-card">
        <div class="form-header">
            <h3>Informasi Profil</h3>
            <p>Perbarui nama dan email akun GiziCare.</p>
        </div>
        <form method="POST" action="{{ route('profile.update') }}" class="auth-form">
            @csrf
            @method('patch')
            <div class="auth-field">
                <label>Nama</label>
                <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required class="auth-input">
            </div>
            <div class="auth-field">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required class="auth-input">
            </div>
            <div class="form-actions">
                <button type="submit" class="btn-app btn-primary">Simpan</button>
                @if (session('status') === 'profile-updated')
                    <span class="inline-status">Tersimpan.</span>
                @endif
            </div>
        </form>
    </section>

    <section class="form-card">
        <div class="form-header">
            <h3>Update Password</h3>
            <p>Gunakan password baru yang kuat dan mudah kamu ingat.</p>
        </div>
        <form method="POST" action="{{ route('password.update') }}" class="auth-form">
            @csrf
            @method('put')
            <div class="auth-field">
                <label>Password Saat Ini</label>
                <input type="password" name="current_password" required class="auth-input">
            </div>
            <div class="auth-field">
                <label>Password Baru</label>
                <input type="password" name="password" required class="auth-input">
            </div>
            <div class="auth-field">
                <label>Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" required class="auth-input">
            </div>
            <button type="submit" class="btn-app btn-primary">Update Password</button>
        </form>
    </section>

    <section class="form-card danger-zone">
        <div class="form-header">
            <h3>Hapus Akun</h3>
            <p>Akun akan dihapus permanen. Tindakan ini tidak bisa dibatalkan.</p>
        </div>
        <form method="POST" action="{{ route('profile.destroy') }}" class="delete-account-form">
            @csrf
            @method('delete')
            <input type="password" name="password" placeholder="Password untuk konfirmasi" required class="auth-input">
            <button type="submit" class="btn-app btn-danger">Hapus</button>
        </form>
    </section>
</div>
@endsection
