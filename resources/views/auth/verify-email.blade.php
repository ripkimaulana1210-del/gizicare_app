@extends('layouts.guest')

@section('title', 'Verifikasi Email — GiziCare')

@section('content')
<h2 class="text-xl font-bold text-center text-gray-800 mb-1">Verifikasi Email</h2>
<p class="text-center text-sm text-gray-500 mb-5">Klik link di email untuk mengaktifkan akun</p>

@if (session('status') == 'verification-link-sent')
    <div class="mb-4 text-sm text-green-600 bg-green-50 rounded-lg px-3 py-2">Link verifikasi baru telah dikirim.</div>
@endif

<p class="text-sm text-gray-600 mb-5">Tidak menerima email? Klik tombol di bawah untuk mengirim ulang.</p>

<form method="POST" action="{{ route('verification.send') }}">
    @csrf
    <button type="submit" class="w-full py-2.5 rounded-lg bg-green-500 text-white font-semibold hover:bg-green-600 transition text-sm mb-3">
        Kirim Ulang Email
    </button>
</form>

<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit" class="w-full py-2.5 rounded-lg border border-gray-300 text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
        Logout
    </button>
</form>
@endsection

