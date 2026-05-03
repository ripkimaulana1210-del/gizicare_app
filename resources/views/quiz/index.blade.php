@extends('layouts.app')

@section('header')
    <h2 class="page-title">🧠 Quiz Gizi</h2>
@endsection

@section('content')
<div class="container-form">
    {{-- Hero --}}
    <div class="edukasi-hero text-center">
        <h3 class="text-xl font-bold">Uji Pengetahuanmu Tentang Gizi!</h3>
        <p class="mt-2">Jawab {{ $totalSoal }} pertanyaan pilihan ganda dan lihat skor kamu</p>
    </div>

    {{-- Start Quiz --}}
    <div class="form-card text-center mt-6">
        <div class="text-5xl mb-4">🎯</div>
        <h4 class="text-lg font-bold text-gray-800 mb-2">Siap Mulai Quiz?</h4>
        <p class="text-sm text-gray-500 mb-6">Kamu akan mendapat 5 soal acak dari total {{ $totalSoal }} soal</p>

        <a href="{{ route('quiz.show') }}" class="inline-block px-8 py-3 rounded-xl bg-gradient-to-r from-green-500 to-emerald-500 text-white font-bold hover:from-green-600 hover:to-emerald-600 transition-all shadow-lg">
            Mulai Quiz Sekarang 🚀
        </a>
    </div>

    {{-- Kategori --}}
    @if($kategori->count() > 0)
    <div class="mt-8">
        <h3 class="section-title mb-4">Topik Quiz</h3>
        <div class="flex flex-wrap gap-2">
            @foreach($kategori as $kat)
                <span class="px-4 py-2 rounded-full bg-green-50 text-green-700 text-sm font-semibold border border-green-100">
                    {{ $kat }}
                </span>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Riwayat --}}
    @if($history->count() > 0)
    <div class="mt-8">
        <h3 class="section-title mb-4">📊 Riwayat Quiz</h3>
        <div class="space-y-3">
            @foreach($history as $h)
                <div class="flex items-center justify-between p-4 bg-white rounded-xl border border-gray-100 shadow-sm">
                    <div>
                        <p class="text-sm text-gray-500">{{ $h->created_at->format('d M Y H:i') }}</p>
                        <p class="font-semibold text-gray-800">{{ $h->jawaban_benar }}/{{ $h->total_soal }} benar</p>
                    </div>
                    <div class="text-right">
                        <span class="text-2xl font-bold {{ $h->score >= 80 ? 'text-green-500' : ($h->score >= 60 ? 'text-yellow-500' : 'text-red-500') }}">
                            {{ $h->score }}%
                        </span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection

