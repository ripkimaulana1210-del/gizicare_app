<x-app-layout>

    <x-slot name="header">
        <h2 class="page-title">Edukasi Gizi 📚</h2>
    </x-slot>

    <div class="container-form">

        {{-- HERO / INTRO --}}
        <div class="edukasi-hero">
            <h3>Belajar Gizi Sehat</h3>
            <p>Tingkatkan pengetahuan gizi untuk menjaga kesehatan anak</p>
        </div>

        {{-- 📘 MATERI --}}
        <h3 class="section-title">Materi Gizi</h3>

        <div class="grid-edukasi">
            @forelse ($materi as $item)
                <div class="card-edukasi">
                    <div class="badge-type materi">Materi</div>

                    <h4>{{ $item->judul }}</h4>

                    <p>
                        {{ Str::limit($item->konten, 100) }}
                    </p>
                </div>
            @empty
                <p>Belum ada materi</p>
            @endforelse
        </div>

        {{-- 📄 JURNAL --}}
        <h3 class="section-title mt-6">Jurnal Ilmiah</h3>

        <div class="grid-edukasi">
            @forelse ($jurnal as $item)
                <div class="card-edukasi">
                    <div class="badge-type jurnal">Jurnal</div>

                    <h4>{{ $item->judul }}</h4>

                    <a href="{{ $item->link }}" target="_blank" class="btn-link">
                        Baca Jurnal →
                    </a>
                </div>
            @empty
                <p>Belum ada jurnal</p>
            @endforelse
        </div>

        {{-- 🧠 QUIZ --}}
        <h3 class="section-title mt-6">Quiz</h3>

        <div class="card-edukasi text-center">
            <h4>Uji Pengetahuan Kamu</h4>
            <p>Jawab beberapa pertanyaan tentang gizi</p>

            <a href="/quiz" class="btn-submit mt-3">
                Mulai Quiz 🚀
            </a>
        </div>

    </div>

</x-app-layout>
