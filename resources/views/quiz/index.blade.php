@extends('layouts.app')

@section('header')
    <h2 class="page-title">Quiz Gizi</h2>
@endsection

@section('content')
<div class="container-form quiz-page">
    <div class="edukasi-hero quiz-hero">
        <div>
            <p class="hero-kicker">Latihan Cepat</p>
            <h3>Uji pengetahuan gizi keluarga.</h3>
            <p>Jawab pertanyaan pilihan ganda dan lihat skor kamu secara langsung.</p>
        </div>
        <div class="hero-summary">
            <strong>{{ $totalSoal }}</strong>
            <span>soal tersedia</span>
        </div>
    </div>

    <div class="form-card quiz-start">
        <div class="quiz-start__icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none">
                <path d="M12 3 4.5 7v6c0 4.1 3.1 6.8 7.5 8 4.4-1.2 7.5-3.9 7.5-8V7L12 3Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                <path d="M9.3 11.7 11.2 13.6 15.2 9.6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>
        <h4>Siap mulai quiz?</h4>
        <p>Kamu akan mendapat 5 soal acak dari total {{ $totalSoal }} soal.</p>

        <a href="{{ route('quiz.show') }}" class="btn-app btn-primary btn-large">
            <span>Mulai Quiz</span>
            <span class="btn-arrow" aria-hidden="true">-></span>
        </a>
    </div>

    @if($kategori->count() > 0)
    <div class="quiz-topics">
        <div class="content-section-title">
            <div>
                <p>Topik</p>
                <h3>Topik Quiz</h3>
            </div>
        </div>
        <div class="chip-row">
            @foreach($kategori as $kat)
                <span class="chip">{{ $kat }}</span>
            @endforeach
        </div>
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
                        <p>{{ $h->created_at->format('d M Y H:i') }}</p>
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
