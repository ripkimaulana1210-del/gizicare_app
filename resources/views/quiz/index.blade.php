@extends('layouts.app')

@section('header')
    <h2 class="page-title">Quiz Gizi</h2>
@endsection

@section('content')
@php($jumlahQuiz = min(10, $totalSoal))

<div class="container-form quiz-page">
    @if (session('error'))
        <div class="alert-error">
            <p>{{ session('error') }}</p>
        </div>
    @endif

    <div class="edukasi-hero quiz-hero">
        <div>
            <p class="hero-kicker">Latihan Terarah</p>
            <h3>Pilih materi, lalu uji pemahaman gizi kamu.</h3>
            <p>Latihan dibuat lebih fokus: mulai dari semua materi atau pilih topik tertentu seperti MPASI, stunting, posyandu, anemia, dan lainnya.</p>
        </div>
        <div class="hero-summary">
            <strong>{{ $totalSoal }}</strong>
            <span>soal tersedia</span>
        </div>
    </div>

    <section class="quiz-dashboard-strip" aria-label="Ringkasan quiz">
        <div>
            <span>Format</span>
            <strong>{{ $jumlahQuiz > 0 ? "{$jumlahQuiz} soal acak" : 'Belum tersedia' }}</strong>
        </div>
        <div>
            <span>Materi</span>
            <strong>{{ $materiOptions->count() }} pilihan</strong>
        </div>
        <div>
            <span>Review</span>
            <strong>Pembahasan</strong>
        </div>
    </section>

    <div class="content-section-title">
        <div>
            <p>Pilih Materi</p>
            <h3>Mulai quiz sesuai topik</h3>
        </div>
        @if($totalSoal > 0)
            <span>{{ $materiOptions->count() }} materi tersedia</span>
        @endif
    </div>

    @if($totalSoal > 0)
        <section class="quiz-material-grid" aria-label="Pilihan materi quiz">
            <article class="quiz-material-card quiz-material-card--all">
                <div class="quiz-material-card__head">
                    <span class="quiz-material-card__icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none">
                            <path d="M5 5.5h14M5 12h14M5 18.5h14" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                        </svg>
                    </span>
                    <span>{{ $jumlahQuiz }} soal</span>
                </div>
                <h4>Semua Materi</h4>
                <p>Campuran soal acak dari seluruh topik gizi yang tersedia.</p>
                <a href="{{ route('quiz.show') }}" class="btn-app btn-primary">
                    Mulai Semua
                </a>
            </article>

            @foreach($materiOptions as $materi)
                @php($jumlahMateriQuiz = min(10, $materi->total))
                <article class="quiz-material-card">
                    <div class="quiz-material-card__head">
                        <span class="quiz-material-card__icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none">
                                <path d="M6 5.5h9.5A2.5 2.5 0 0 1 18 8v10.5H8.5A2.5 2.5 0 0 1 6 16V5.5Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                                <path d="M9 9h6M9 12.5h5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                            </svg>
                        </span>
                        <span>{{ $jumlahMateriQuiz }} soal</span>
                    </div>
                    <h4>{{ $materi->kategori }}</h4>
                    <p>{{ $materi->total }} soal tersedia untuk latihan materi {{ strtolower($materi->kategori) }}.</p>
                    <a href="{{ route('quiz.show', ['materi' => $materi->kategori]) }}" class="btn-app btn-ghost">
                        Pilih Materi
                    </a>
                </article>
            @endforeach
        </section>
    @else
        <div class="form-card quiz-start">
            <div class="quiz-start__icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none">
                    <path d="M12 3 4.5 7v6c0 4.1 3.1 6.8 7.5 8 4.4-1.2 7.5-3.9 7.5-8V7L12 3Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                    <path d="M9.3 11.7 11.2 13.6 15.2 9.6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <h4>Quiz belum tersedia</h4>
            <p>Quiz akan tampil setelah soal ditambahkan.</p>
            <span class="empty-state empty-state--inline">Belum ada soal.</span>
        </div>
    @endif

    @if($history->count() > 0)
    <div class="quiz-history">
        <div class="content-section-title">
            <div>
                <p>Riwayat</p>
                <h3>Riwayat Quiz</h3>
            </div>
        </div>
        <div class="history-list">
            @foreach($history as $h)
                <div class="history-item">
                    <div>
                        <p>{{ $h->created_at->format('d M Y H:i') }} - {{ $h->materi_label }}</p>
                        <strong>{{ $h->jawaban_benar }}/{{ $h->total_soal }} benar</strong>
                    </div>
                    <span class="score-pill {{ $h->score >= 80 ? 'is-good' : ($h->score >= 60 ? 'is-mid' : 'is-low') }}">
                        {{ $h->score }}%
                    </span>
                </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
