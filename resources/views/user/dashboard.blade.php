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

            <a href="/pencatatan" class="dashboard-card white">
                <div class="card-icon">🧮</div>
                <div class="card-title">Input Gizi</div>
                <div class="card-desc">Cek status gizi kamu</div>
            </a>

            <a href="/diagnosis" class="dashboard-card white">
                <div class="card-icon">🧪</div>
                <div class="card-title">Diagnosis</div>
                <div class="card-desc">Deteksi masalah gizi</div>
            </a>

        </div>

    </div>
</x-app-layout>