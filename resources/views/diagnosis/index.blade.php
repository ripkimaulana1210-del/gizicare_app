@extends('layouts.app')

@section('header')
    <h2 class="page-title">Diagnosis Masalah Gizi</h2>
@endsection

@section('content')
<div class="dashboard-container">

    {{-- Banner --}}
    <div class="greeting-banner">
        <div class="greeting-text">
            <div class="greeting-sub">Analisis Kesehatan</div>
            <div class="greeting-title">
                Cek status gizi anak<br>
                secara cepat dan akurat
            </div>
        </div>
        <div class="greeting-badge">
            <div class="greeting-badge-value">AI</div>
            <div class="greeting-badge-label">Diagnosis</div>
        </div>
    </div>

    {{-- Form --}}
    <div class="section-label">Input Data Anak</div>

    <form action="#" method="POST" class="dashboard-card diagnosis-form">
        @csrf

        <div class="form-grid">
            <div class="form-group">
                <label>Nama Anak</label>
                <input type="text" name="nama" placeholder="Contoh: Aisyah">
            </div>

            <div class="form-group">
                <label>Umur (bulan)</label>
                <input type="number" name="umur" placeholder="Contoh: 24">
            </div>

            <div class="form-group">
                <label>Berat Badan (kg)</label>
                <input type="number" step="0.1" name="bb" placeholder="Contoh: 12.5">
            </div>

            <div class="form-group">
                <label>Tinggi Badan (cm)</label>
                <input type="number" step="0.1" name="tb" placeholder="Contoh: 90">
            </div>
        </div>

        {{-- Gejala --}}
        <div class="mt-3">
            <label class="block text-sm font-bold mb-3">Gejala</label>

            <div class="symptom-grid">
                <label class="checkbox-card">
                    <input type="checkbox" name="gejala[]" value="kurus">
                    <span>Berat badan kurang</span>
                </label>
                <label class="checkbox-card">
                    <input type="checkbox" name="gejala[]" value="lemas">
                    <span>Lemas</span>
                </label>
                <label class="checkbox-card">
                    <input type="checkbox" name="gejala[]" value="nafsu_makan">
                    <span>Nafsu makan rendah</span>
                </label>
                <label class="checkbox-card">
                    <input type="checkbox" name="gejala[]" value="pendek">
                    <span>Tinggi badan pendek</span>
                </label>
            </div>
        </div>

        <button class="btn-submit diagnosis-submit">
            Analisis
        </button>
    </form>

    {{-- Hasil --}}
    <div class="section-label">Hasil Diagnosis</div>

    <div class="dashboard-card result-card">
        <h2>Status Gizi</h2>
        <p>-</p>

        <h2>Rekomendasi</h2>
        <p>-</p>
    </div>

</div>
@endsection
