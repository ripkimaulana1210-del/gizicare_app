@extends('layouts.app')

@section('header')
    <h2 class="page-title">🧠 Quiz Gizi — Sedang Berlangsung</h2>
@endsection

@section('content')
<div class="container-form">
    <form method="POST" action="{{ route('quiz.submit') }}" id="quizForm">
        @csrf

        @foreach($soal as $index => $q)
        <div class="form-card mb-4">
            <div class="flex items-start gap-3 mb-4">
                <span class="w-8 h-8 rounded-full bg-green-500 text-white flex items-center justify-center text-sm font-bold flex-shrink-0">
                    {{ $index + 1 }}
                </span>
                <div>
                    <span class="text-xs font-bold text-green-600 uppercase tracking-wider">{{ $q->kategori }}</span>
                    <p class="font-semibold text-gray-800 mt-1">{{ $q->pertanyaan }}</p>
                </div>
            </div>

            <div class="space-y-2 ml-11">
                @foreach($q->pilihan as $key => $value)
                <label class="flex items-center gap-3 p-3 rounded-xl border-2 border-gray-100 hover:border-green-300 hover:bg-green-50 cursor-pointer transition-all">
                    <input type="radio" name="jawaban[{{ $q->id }}]" value="{{ $key }}" required
                        class="w-5 h-5 text-green-500 focus:ring-green-500">
                    <span class="text-sm text-gray-700"><strong>{{ $key }}.</strong> {{ $value }}</span>
                </label>
                @endforeach
            </div>
        </div>
        @endforeach

        <div class="text-center mt-6">
            <button type="submit" class="px-10 py-3.5 rounded-xl bg-gradient-to-r from-green-500 to-emerald-500 text-white font-bold text-lg hover:from-green-600 hover:to-emerald-600 transition-all shadow-lg">
                ✅ Kirim Jawaban
            </button>
        </div>
    </form>
</div>
@endsection

