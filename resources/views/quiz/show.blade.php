@extends('layouts.app')

@section('header')
    <h2 class="page-title">Quiz Gizi - Sedang Berlangsung</h2>
@endsection

@section('content')
<div class="container-form quiz-page">
    <form method="POST" action="{{ route('quiz.submit') }}" id="quizForm" class="quiz-form">
        @csrf

        @foreach($soal as $index => $q)
        <section class="form-card quiz-question">
            <div class="quiz-question__head">
                <span class="question-number">{{ $index + 1 }}</span>
                <div>
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
            <button type="submit" class="btn-app btn-primary btn-large">
                Kirim Jawaban
            </button>
        </div>
    </form>
</div>
@endsection
