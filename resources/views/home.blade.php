@extends('layouts.app')

@section('title', 'Beranda - GiziCare')

@section('content')
<section class="home-hero">
    <div class="home-hero__content">
        <p class="home-hero__eyebrow">Gizi keluarga, lebih terarah</p>
        <h1>
            Pantau gizi balita dengan rasa <span>fresh dan peduli</span>
        </h1>
        <p class="home-hero__copy">
            GiziCare menyatukan edukasi, pencatatan, dan diagnosis awal dalam tampilan yang lebih hangat untuk dipakai setiap hari.
        </p>
        <div class="home-hero__actions">
            @guest
                <a href="{{ route('register') }}" class="btn-app btn-primary btn-large">Daftar Gratis</a>
                <a href="{{ route('login') }}" class="btn-app btn-light btn-large">Masuk</a>
            @else
                <a href="{{ route('pencatatan.index') }}" class="btn-app btn-light btn-large">Mulai Pencatatan</a>
            @endguest
        </div>
    </div>

    <div class="home-hero__visual" aria-hidden="true">
        <div class="hero-metric">
            <div class="hero-metric__label">Status Gizi</div>
            <div class="hero-metric__value">Normal</div>
            <div class="hero-metric__bar" style="--bar: 78%"><span></span></div>
        </div>
        <div class="hero-metric">
            <div class="hero-metric__label">Catatan Bulanan</div>
            <div class="hero-metric__value">24 data</div>
            <div class="hero-metric__bar" style="--bar: 64%"><span></span></div>
        </div>
        <div class="hero-metric">
            <div class="hero-metric__label">Edukasi Aktif</div>
            <div class="hero-metric__value">12 topik</div>
            <div class="hero-metric__bar" style="--bar: 86%"><span></span></div>
        </div>
    </div>
</section>

<div class="home-strip">
    <div class="home-strip__item">
        <strong>3</strong>
        <span>alur utama</span>
    </div>
    <div class="home-strip__item">
        <strong>Rapi</strong>
        <span>data balita</span>
    </div>
    <div class="home-strip__item">
        <strong>Cepat</strong>
        <span>akses informasi</span>
    </div>
</div>

<div class="feature-grid">
    <a href="{{ route('edukasi.index') }}" class="feature-card feature-card--green">
        <span class="feature-card__icon">ED</span>
        <h3>Edukasi Gizi</h3>
        <p>Materi dan jurnal ilmiah seputar kesehatan serta gizi keluarga.</p>
    </a>
    <a href="{{ route('pencatatan.index') }}" class="feature-card feature-card--pink">
        <span class="feature-card__icon">PC</span>
        <h3>Pencatatan Balita</h3>
        <p>Catat berat, tinggi, usia, dan riwayat pertumbuhan balita secara rapi.</p>
    </a>
    <a href="{{ route('diagnosis') }}" class="feature-card feature-card--red">
        <span class="feature-card__icon">DG</span>
        <h3>Diagnosis Gizi</h3>
        <p>Deteksi dini masalah gizi berdasarkan data dan gejala yang dialami.</p>
    </a>
</div>
@endsection
