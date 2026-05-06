@extends('layouts.app')

@section('header')
    <h2 class="page-title">Quiz Gizi{{ $materi ? " - {$materi}" : '' }}</h2>
@endsection

@section('content')
<div class="container-form quiz-page">
    <div class="edukasi-hero quiz-session-hero">
        <div>
            <p class="hero-kicker">Materi Quiz</p>
            <h3>{{ $materi ?: 'Semua Materi' }}</h3>
            <p>{{ $materi ? "Kamu mengerjakan {$jumlahSoal} soal acak dari {$totalMateri} soal materi {$materi}." : "Kamu mengerjakan {$jumlahSoal} soal acak dari semua materi quiz." }}</p>
        </div>
        <div class="hero-summary">
            <strong>{{ $jumlahSoal }}</strong>
            <span>soal</span>
        </div>
    </div>

    <form method="POST" action="{{ route('quiz.submit') }}" id="quizForm" class="quiz-form">
        @csrf
        <input type="hidden" name="materi" value="{{ $materi }}">

        @foreach($soal as $index => $q)
        <input type="hidden" name="soal_ids[]" value="{{ $q->id }}">
        <section class="form-card quiz-question">
            <div class="quiz-question__head">
                <span class="question-number">{{ $index + 1 }}</span>
                <div>
                    <span class="quiz-question__topic">{{ $q->kategori }}</span>
                    <p>{{ $q->pertanyaan }}</p>
                </div>
            </div>

            <div class="answer-list">
                @foreach($q->pilihan as $key => $value)
                <label class="answer-option">
                    <input type="radio" name="jawaban[{{ $q->id }}]" value="{{ $key }}" required>
                    <span><strong>{{ $key }}.</strong> {{ $value }}</span>
                </label>
                @endforeach
            </div>
        </section>
        @endforeach

        <div class="quiz-submit">
            <a href="{{ route('quiz.index') }}" class="btn-app btn-ghost">Ganti Materi</a>
            <button type="submit" class="btn-app btn-primary btn-large">
                Kirim Jawaban
            </button>
        </div>
    </form>
</div>
@endsection
