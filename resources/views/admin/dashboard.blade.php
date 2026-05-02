@extends('layouts.app')

@section('title', 'Dashboard Admin - GiziCare')

@section('header')
    <h1 class="page-title">Dashboard Admin</h1>
@endsection

@section('content')
<div class="dashboard-grid">
    <div class="dashboard-card admin-card">
        <span class="feature-card__icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none">
                <path d="M8 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8ZM2.5 21c.6-3.6 2.5-6 5.5-6s4.9 2.4 5.5 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                <path d="M17 11a3 3 0 1 0 0-6M15.5 15.2c2.4.5 3.8 2.5 4.2 5.8" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
            </svg>
        </span>
        <h3>Pengguna</h3>
        <p>Kelola data pengguna dan aktivitas akun.</p>
    </div>
    <div class="dashboard-card admin-card">
        <span class="feature-card__icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none">
                <path d="M4 5.5C5.1 4.6 6.5 4 8 4c1.5 0 2.9.6 4 1.5C13.1 4.6 14.5 4 16 4c1.5 0 2.9.6 4 1.5v13c-1.1-.9-2.5-1.5-4-1.5-1.5 0-2.9.6-4 1.5-1.1-.9-2.5-1.5-4-1.5-1.5 0-2.9.6-4 1.5v-13Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                <path d="M12 5.5v13" stroke="currentColor" stroke-width="1.8"/>
            </svg>
        </span>
        <h3>Edukasi</h3>
        <p>Kelola materi, jurnal, dan kategori konten.</p>
    </div>
    <div class="dashboard-card admin-card">
        <span class="feature-card__icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none">
                <path d="M4 19V5M4 19h16" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                <path d="M8 16v-5M12 16V8M16 16v-7" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
            </svg>
        </span>
        <h3>Laporan</h3>
        <p>Lihat statistik platform dan ringkasan pemakaian.</p>
    </div>
</div>
@endsection
