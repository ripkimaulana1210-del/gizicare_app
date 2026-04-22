<x-app-layout>
    <x-slot name="header">
        <h2 class="page-title">Diagnosis Masalah Gizi 🧪</h2>
    </x-slot>

    <div class="dashboard-container">

        {{-- 🔥 Banner --}}
        <div class="greeting-banner">
            <div class="greeting-text">
                <div class="greeting-sub">Analisis Kesehatan</div>
                <div class="greeting-title">
                    Cek status gizi anak<br>
                    secara <strong>cepat & akurat</strong>
                </div>
            </div>
            <div class="greeting-badge">
                <div class="greeting-badge-value">AI</div>
                <div class="greeting-badge-label">Diagnosis</div>
            </div>
        </div>

        {{-- 🔥 FORM --}}
        <div class="section-label">Input Data Anak</div>

        <form action="#" method="POST" class="dashboard-card p-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>
                    <label class="block text-sm font-medium">Nama Anak</label>
                    <input type="text" name="nama" class="w-full border rounded px-3 py-2">
                </div>

                <div>
                    <label class="block text-sm font-medium">Umur (bulan)</label>
                    <input type="number" name="umur" class="w-full border rounded px-3 py-2">
                </div>

                <div>
                    <label class="block text-sm font-medium">Berat Badan (kg)</label>
                    <input type="number" step="0.1" name="bb" class="w-full border rounded px-3 py-2">
                </div>

                <div>
                    <label class="block text-sm font-medium">Tinggi Badan (cm)</label>
                    <input type="number" step="0.1" name="tb" class="w-full border rounded px-3 py-2">
                </div>

            </div>

            {{-- Gejala --}}
            <div class="mt-4">
                <label class="block text-sm font-medium mb-2">Gejala</label>

                <div class="grid grid-cols-2 gap-2">
                    <label><input type="checkbox" name="gejala[]" value="kurus"> Berat badan kurang</label>
                    <label><input type="checkbox" name="gejala[]" value="lemas"> Lemas</label>
                    <label><input type="checkbox" name="gejala[]" value="nafsu_makan"> Nafsu makan rendah</label>
                    <label><input type="checkbox" name="gejala[]" value="pendek"> Tinggi badan pendek</label>
                </div>
            </div>

            <button class="mt-6 bg-green-500 text-white px-4 py-2 rounded">
                Analisis
            </button>
        </form>

        {{-- 🔥 HASIL --}}
        <div class="section-label">Hasil Diagnosis</div>

        <div class="dashboard-card p-6">
            <h2 class="font-bold mb-2">Status Gizi</h2>
            <p class="text-lg text-gray-700">-</p>

            <h2 class="font-bold mt-4 mb-2">Rekomendasi</h2>
            <p class="text-gray-600">-</p>
        </div>

    </div>
</x-app-layout>
