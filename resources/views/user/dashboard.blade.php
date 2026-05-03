<x-app-layout>
    <x-slot name="header">
        <h2 class="page-title">Dashboard User 👤</h2>
    </x-slot>

    <div class="dashboard-container">

        <div class="dashboard-grid">

            <a href="/edukasi" class="dashboard-card white">
                <div class="card-icon">📚</div>
                <div class="card-title">Edukasi</div>
                <div class="card-desc">Belajar gizi sehat</div>
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
