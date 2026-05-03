@extends('layouts.app')

@section('title', 'Dashboard Admin — GiziCare')

@section('header')
    <h1 class="text-xl font-bold text-gray-800">Dashboard Admin</h1>
@endsection

@section('content')
<div class="grid md:grid-cols-3 gap-4">
    <div class="bg-white rounded-xl p-5 border border-gray-100">
        <div class="text-2xl mb-2">👥</div>
        <h3 class="font-bold text-gray-800">Pengguna</h3>
        <p class="text-sm text-gray-500">Kelola data pengguna</p>
    </div>
    <div class="bg-white rounded-xl p-5 border border-gray-100">
        <div class="text-2xl mb-2">📚</div>
        <h3 class="font-bold text-gray-800">Edukasi</h3>
        <p class="text-sm text-gray-500">Kelola materi & jurnal</p>
    </div>
    <div class="bg-white rounded-xl p-5 border border-gray-100">
        <div class="text-2xl mb-2">📊</div>
        <h3 class="font-bold text-gray-800">Laporan</h3>
        <p class="text-sm text-gray-500">Lihat statistik platform</p>
    </div>
</div>
@endsection

