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

<section class="dashboard-quick-stats" aria-label="Ringkasan dashboard">
    <div>
        <span>Ruang Kerja</span>
        <strong>3</strong>
        <p>alur utama</p>
    </div>
    <div>
        <span>Status</span>
        <strong>Aktif</strong>
        <p>akun siap pakai</p>
    </div>
    <div>
        <span>Mode</span>
        <strong>Terarah</strong>
        <p>belajar dan catat</p>
    </div>
</section>

<div class="feature-grid">
    <a href="{{ route('edukasi.index') }}" class="feature-card feature-card--green">
        <span class="feature-card__icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none">
                <path d="M4 5.5C5.1 4.6 6.5 4 8 4c1.5 0 2.9.6 4 1.5C13.1 4.6 14.5 4 16 4c1.5 0 2.9.6 4 1.5v13c-1.1-.9-2.5-1.5-4-1.5-1.5 0-2.9.6-4 1.5-1.1-.9-2.5-1.5-4-1.5-1.5 0-2.9.6-4 1.5v-13Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                <path d="M12 5.5v13" stroke="currentColor" stroke-width="1.8"/>
            </svg>
        </span>
        <h3>Edukasi</h3>
        <p>Belajar materi gizi sehat untuk keluarga.</p>
    </a>

    <a href="{{ route('pencatatan.index') }}" class="feature-card feature-card--pink">
        <span class="feature-card__icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none">
                <path d="M9 4h6l1 2h3v14H5V6h3l1-2Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                <path d="M8.5 11h7M8.5 15h5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
            </svg>
        </span>
        <h3>Pencatatan</h3>
        <p>Catat data pertumbuhan dan status gizi balita.</p>
    </a>

    <a href="{{ route('diagnosis') }}" class="feature-card feature-card--red">
        <span class="feature-card__icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none">
                <path d="M20 12.2c0 4.5-4.7 7.1-8 8.8-3.3-1.7-8-4.3-8-8.8C4 9.7 5.7 8 8 8c1.5 0 2.8.8 4 2.1C13.2 8.8 14.5 8 16 8c2.3 0 4 1.7 4 4.2Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                <path d="M8 13h2l1-2.2 2 4.4 1-2.2h2" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </span>
        <h3>Diagnosis</h3>
        <p>Deteksi masalah gizi berdasarkan data anak.</p>
    </a>
</div>
@endsection
