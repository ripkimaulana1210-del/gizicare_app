@extends('layouts.app')

@section('title', 'Beranda - GiziCare')

@section('content')
<section class="home-hero">
    <div class="home-hero__content">
        <p class="home-hero__eyebrow">Gizi keluarga, lebih terarah</p>
        <h1>
            Pantau tumbuh kembang balita dengan data yang lebih tenang.
        </h1>
        <p class="home-hero__copy">
            GiziCare menyatukan edukasi, pencatatan, dan diagnosis awal dalam satu ruang yang nyaman dipakai keluarga maupun pendamping posyandu.
        </p>
        <div class="home-hero__tags" aria-label="Fokus GiziCare">
            <span>Pertumbuhan</span>
            <span>MPASI</span>
            <span>Stunting</span>
            <span>Anemia</span>
        </div>
        <div class="home-hero__actions">
            @guest
                <a href="{{ route('register') }}" class="btn-app btn-primary btn-large">
                    <span>Daftar Gratis</span>
                    <span class="btn-arrow" aria-hidden="true">-></span>
                </a>
                <a href="{{ route('login') }}" class="btn-app btn-light btn-large">Masuk</a>
            @else
                <a href="{{ route('pencatatan.index') }}" class="btn-app btn-light btn-large">
                    <span>Mulai Pencatatan</span>
                    <span class="btn-arrow" aria-hidden="true">-></span>
                </a>
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
        <div class="hero-insight-card">
            <div>
                <span>Grafik Pertumbuhan</span>
                <strong>+0.8 kg</strong>
            </div>
            <div class="hero-chart" aria-hidden="true">
                <span style="height: 42%"></span>
                <span style="height: 54%"></span>
                <span style="height: 48%"></span>
                <span style="height: 66%"></span>
                <span style="height: 78%"></span>
            </div>
        </div>
        <div class="hero-care-card">
            <span>Fokus Hari Ini</span>
            <strong>Catatan terbaru membantu arah edukasi berikutnya.</strong>
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

<div class="section-heading">
    <p>Alur GiziCare</p>
    <h2>Satu aplikasi untuk belajar, mencatat, dan mengambil langkah awal.</h2>
</div>

<div class="feature-grid">
    <a href="{{ route('edukasi.index') }}" class="feature-card feature-card--green">
        <span class="feature-card__icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none">
                <path d="M4 5.5C5.1 4.6 6.5 4 8 4c1.5 0 2.9.6 4 1.5C13.1 4.6 14.5 4 16 4c1.5 0 2.9.6 4 1.5v13c-1.1-.9-2.5-1.5-4-1.5-1.5 0-2.9.6-4 1.5-1.1-.9-2.5-1.5-4-1.5-1.5 0-2.9.6-4 1.5v-13Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                <path d="M12 5.5v13" stroke="currentColor" stroke-width="1.8"/>
            </svg>
        </span>
        <h3>Edukasi Gizi</h3>
        <p>Materi dan jurnal ilmiah seputar kesehatan serta gizi keluarga.</p>
    </a>
    <a href="{{ route('pencatatan.index') }}" class="feature-card feature-card--pink">
        <span class="feature-card__icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none">
                <path d="M9 4h6l1 2h3v14H5V6h3l1-2Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                <path d="M8.5 11h7M8.5 15h5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
            </svg>
        </span>
        <h3>Pencatatan Balita</h3>
        <p>Catat berat, tinggi, usia, dan riwayat pertumbuhan balita secara rapi.</p>
    </a>
    <a href="{{ route('diagnosis') }}" class="feature-card feature-card--red">
        <span class="feature-card__icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none">
                <path d="M20 12.2c0 4.5-4.7 7.1-8 8.8-3.3-1.7-8-4.3-8-8.8C4 9.7 5.7 8 8 8c1.5 0 2.8.8 4 2.1C13.2 8.8 14.5 8 16 8c2.3 0 4 1.7 4 4.2Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                <path d="M8 13h2l1-2.2 2 4.4 1-2.2h2" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </span>
        <h3>Diagnosis Gizi</h3>
        <p>Deteksi dini masalah gizi berdasarkan data dan gejala yang dialami.</p>
    </a>
</div>

<section class="home-dashboard-preview">
    <div class="preview-copy">
        <p>Dashboard keluarga</p>
        <h2>Semua informasi penting tampil dalam pola yang mudah discan.</h2>
        <span>Ringkasan status, riwayat catatan, edukasi, dan konsultasi awal dibuat saling terhubung.</span>
    </div>
    <div class="preview-board" aria-hidden="true">
        <div class="preview-board__top">
            <strong>Ringkasan Balita</strong>
            <span>Aktif</span>
        </div>
        <div class="preview-board__grid">
            <div>
                <small>Berat</small>
                <strong>12.5 kg</strong>
            </div>
            <div>
                <small>Tinggi</small>
                <strong>90 cm</strong>
            </div>
            <div>
                <small>Status</small>
                <strong>Normal</strong>
            </div>
        </div>
        <div class="preview-timeline">
            <span style="width: 42%"></span>
            <span style="width: 68%"></span>
            <span style="width: 84%"></span>
        </div>
    </div>
</section>

<section class="home-workflow">
    <div class="home-workflow__intro">
        <p>Ritme Pemantauan</p>
        <h2>Dari data harian ke keputusan yang lebih tenang.</h2>
    </div>
    <div class="workflow-steps" aria-label="Alur pemantauan gizi">
        <div class="workflow-step">
            <span>01</span>
            <strong>Catat</strong>
            <p>Masukkan usia, berat, tinggi, dan riwayat pertumbuhan.</p>
        </div>
        <div class="workflow-step">
            <span>02</span>
            <strong>Pahami</strong>
            <p>Baca materi yang sesuai dengan kondisi keluarga.</p>
        </div>
        <div class="workflow-step">
            <span>03</span>
            <strong>Tindak</strong>
            <p>Gunakan arahan awal untuk menentukan langkah berikutnya.</p>
        </div>
    </div>
</section>
@endsection
