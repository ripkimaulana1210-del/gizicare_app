@extends('layouts.app')

@section('title', 'Profil — GiziCare')

@section('header')
    <h1 class="text-xl font-bold text-gray-800">Profil</h1>
@endsection

@section('content')
<div class="max-w-xl mx-auto space-y-6">
    <div class="bg-white rounded-xl p-6 border border-gray-100">
        <h2 class="text-lg font-semibold mb-4">Informasi Profil</h2>
        <form method="POST" action="{{ route('profile.update') }}" class="space-y-4">
            @csrf @method('patch')
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required
                       class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:border-green-500 focus:ring-1 focus:ring-green-500 outline-none text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required
                       class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:border-green-500 focus:ring-1 focus:ring-green-500 outline-none text-sm">
            </div>
            <button type="submit" class="px-4 py-2 rounded-lg bg-green-500 text-white text-sm font-semibold hover:bg-green-600 transition">Simpan</button>
            @if (session('status') === 'profile-updated')
                <span class="text-sm text-green-600 ml-2">Tersimpan!</span>
            @endif
        </form>
    </div>

    <div class="bg-white rounded-xl p-6 border border-gray-100">
        <h2 class="text-lg font-semibold mb-4">Update Password</h2>
        <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
            @csrf @method('put')
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password Saat Ini</label>
                <input type="password" name="current_password" required
                       class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:border-green-500 focus:ring-1 focus:ring-green-500 outline-none text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                <input type="password" name="password" required
                       class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:border-green-500 focus:ring-1 focus:ring-green-500 outline-none text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" required
                       class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:border-green-500 focus:ring-1 focus:ring-green-500 outline-none text-sm">
            </div>
            <button type="submit" class="px-4 py-2 rounded-lg bg-green-500 text-white text-sm font-semibold hover:bg-green-600 transition">Update Password</button>
        </form>
    </div>

    <div class="bg-white rounded-xl p-6 border border-gray-100">
        <h2 class="text-lg font-semibold mb-4 text-red-600">Hapus Akun</h2>
        <form method="POST" action="{{ route('profile.destroy') }}">
            @csrf @method('delete')
            <p class="text-sm text-gray-500 mb-4">Akun akan dihapus permanen. Tindakan ini tidak bisa dibatalkan.</p>
            <div class="flex gap-3">
                <input type="password" name="password" placeholder="Password untuk konfirmasi" required
                       class="flex-1 px-3 py-2 rounded-lg border border-gray-300 focus:border-red-500 outline-none text-sm">
                <button type="submit" class="px-4 py-2 rounded-lg bg-red-500 text-white text-sm font-semibold hover:bg-red-600 transition">Hapus</button>
            </div>
        </form>
    </div>
</div>
@endsection

