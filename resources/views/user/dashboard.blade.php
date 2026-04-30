@extends('layouts.app')

@section('title', 'Dashboard - GiziCare')

@section('header')
    <h1 class="page-title">Dashboard</h1>
@endsection

@section('content')
<section class="dashboard-welcome">
    <div>
        <h2>Halo, {{ auth()->user()->name }}</h2>
        <p>Lanjutkan pemantauan gizi hari ini dari satu tempat yang lebih segar.</p>
    </div>
    <div class="dashboard-welcome__badge">GiziCare</div>
</section>

<div class="feature-grid">
    <a href="{{ route('edukasi.index') }}" class="feature-card feature-card--green">
        <span class="feature-card__icon">ED</span>
        <h3>Edukasi</h3>
        <p>Belajar materi gizi sehat untuk keluarga.</p>
    </a>

    <a href="{{ route('pencatatan.index') }}" class="feature-card feature-card--pink">
        <span class="feature-card__icon">PC</span>
        <h3>Pencatatan</h3>
        <p>Catat data pertumbuhan dan status gizi balita.</p>
    </a>

    <a href="{{ route('diagnosis') }}" class="feature-card feature-card--red">
        <span class="feature-card__icon">DG</span>
        <h3>Diagnosis</h3>
        <p>Deteksi masalah gizi berdasarkan data anak.</p>
    </a>
</div>
@endsection
