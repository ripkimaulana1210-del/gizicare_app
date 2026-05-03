@extends('layouts.app')

@section('header')
    <h2 class="page-title">🎉 Hasil Quiz</h2>
@endsection

@section('content')
<div class="container-form">
    {{-- Score Card --}}
    <div class="form-card text-center">
        <div class="text-6xl mb-4">
            @if($score >= 80) 🏆
            @elseif($score >= 60) 🥈
            @elseif($score >= 40) 📖
            @else 💪
            @endif
        </div>

        <h3 class="text-2xl font-bold text-gray-800 mb-2">
            @if($score >= 80) Luar Biasa!
            @elseif($score >= 60) Bagus Sekali!
            @elseif($score >= 40) Tetap Semangat!
            @else Jangan Menyerah!
            @endif
        </h3>

        <p class="text-gray-500 mb-6">Kamu menjawab <strong>{{ $benar }}</strong> dari <strong>{{ $total }}</strong> soal dengan benar</p>

        <div class="relative w-40 h-40 mx-auto mb-6">
            <svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
                <path class="text-gray-100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-width="3" />
                <path class="{{ $score >= 80 ? 'text-green-500' : ($score >= 60 ? 'text-yellow-500' : 'text-red-500') }}"
                    stroke-dasharray="{{ $score }}, 100"
                    d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                    fill="none" stroke="currentColor" stroke-width="3" />
            </svg>
            <div class="absolute inset-0 flex items-center justify-center">
                <span class="text-3xl font-bold text-gray-800">{{ $score }}%</span>
            </div>
        </div>

        <div class="flex justify-center gap-4">
            <a href="{{ route('quiz.show') }}" class="px-6 py-2.5 rounded-xl bg-green-500 text-white font-semibold hover:bg-green-600 transition-all">
                🔄 Coba Lagi
            </a>
            <a href="/edukasi" class="px-6 py-2.5 rounded-xl bg-gray-100 text-gray-700 font-semibold hover:bg-gray-200 transition-all">
                📚 Belajar Lagi
            </a>
        </div>
    </div>

    {{-- Detail Jawaban --}}
    <div class="mt-6">
        <h3 class="section-title mb-4">Pembahasan</h3>
        <div class="space-y-4">
            @foreach($detail as $i => $d)
            <div class="form-card {{ $d['benar'] ? 'border-l-4 border-l-green-500' : 'border-l-4 border-l-red-500' }}">
                <div class="flex items-start gap-3">
                    <span class="w-7 h-7 rounded-full {{ $d['benar'] ? 'bg-green-500' : 'bg-red-500' }} text-white flex items-center justify-center text-xs font-bold flex-shrink-0">
                        {{ $i + 1 }}
                    </span>
                    <div class="flex-1">
                        <p class="font-semibold text-gray-800">{{ $d['pertanyaan'] }}</p>
                        <div class="mt-2 text-sm">
                            <p class="{{ $d['benar'] ? 'text-green-600' : 'text-red-600' }}">
                                Jawaban kamu: <strong>{{ $d['jawaban_user'] ?? '-' }}</strong>
                                @if($d['benar']) ✅ Benar!
                                @else ❌ Salah
                                @endif
                            </p>
                            @if(!$d['benar'])
                            <p class="text-green-600 mt-1">
                                Jawaban benar: <strong>{{ $d['jawaban_benar'] }}</strong>
                            </p>
                            @endif
                            @if($d['penjelasan'])
                            <div class="mt-2 p-3 bg-blue-50 rounded-lg text-gray-600 text-sm">
                                💡 <strong>Penjelasan:</strong> {{ $d['penjelasan'] }}
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

