@extends('layouts.app')

@section('header')
    <h2 class="page-title">Hasil Quiz</h2>
@endsection

@section('content')
<div class="container-form quiz-page">
    <div class="form-card quiz-result-card">
        <p class="hero-kicker">Skor Akhir</p>
        <h3>
            @if($score >= 80) Luar Biasa!
            @elseif($score >= 60) Bagus Sekali!
            @elseif($score >= 40) Tetap Semangat!
            @else Jangan Menyerah!
            @endif
        </h3>

        <p>Kamu menjawab <strong>{{ $benar }}</strong> dari <strong>{{ $total }}</strong> soal dengan benar.</p>

        <div class="score-ring" style="--score: {{ $score }}">
            <svg viewBox="0 0 36 36" aria-hidden="true">
                <path class="score-ring__track" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke-width="3" />
                <path class="score-ring__value {{ $score >= 80 ? 'is-good' : ($score >= 60 ? 'is-mid' : 'is-low') }}"
                    stroke-dasharray="{{ $score }}, 100"
                    d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                    fill="none" stroke-width="3" />
            </svg>
            <span>{{ $score }}%</span>
        </div>

        <div class="quiz-result-actions">
            <a href="{{ route('quiz.show') }}" class="btn-app btn-primary">Coba Lagi</a>
            <a href="{{ route('edukasi.index') }}" class="btn-app btn-ghost">Belajar Lagi</a>
        </div>
    </div>

    <div class="content-section-title">
        <div>
            <p>Evaluasi</p>
            <h3>Pembahasan</h3>
        </div>
    </div>

    <div class="answer-review-list">
        @foreach($detail as $i => $d)
        <div class="form-card answer-review {{ $d['benar'] ? 'is-correct' : 'is-wrong' }}">
            <div class="answer-review__head">
                <span class="question-number">{{ $i + 1 }}</span>
                <p>{{ $d['pertanyaan'] }}</p>
            </div>
            <div class="answer-review__body">
                <p>
                    Jawaban kamu:
                    <strong>{{ $d['jawaban_user'] ?? '-' }}</strong>
                    <span class="{{ $d['benar'] ? 'review-good' : 'review-bad' }}">
                        {{ $d['benar'] ? 'Benar' : 'Salah' }}
                    </span>
                </p>
                @if(!$d['benar'])
                <p>Jawaban benar: <strong>{{ $d['jawaban_benar'] }}</strong></p>
                @endif
                @if($d['penjelasan'])
                <div class="answer-explain">
                    <strong>Penjelasan:</strong> {{ $d['penjelasan'] }}
                </div>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
