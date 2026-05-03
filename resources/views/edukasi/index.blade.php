@extends('layouts.app')

@section('header')
    <h2 class="page-title">Edukasi Gizi</h2>
@endsection

@section('content')
<div class="container-form learning-page">
    <div class="edukasi-hero">
        <div>
            <p class="hero-kicker">Pusat Edukasi</p>
            <h3>Belajar gizi sehat dari materi yang ringkas dan mudah ditindaklanjuti.</h3>
            <p>Tingkatkan pengetahuan keluarga lewat materi praktis, jurnal pilihan, dan topik yang relevan dengan pemantauan balita.</p>
        </div>
        <div class="hero-summary" aria-label="Ringkasan edukasi">
            <strong>{{ $materi->count() + $jurnal->count() }}</strong>
            <span>konten tersedia</span>
        </div>
    </div>

    <section class="learning-stats" aria-label="Ringkasan edukasi">
        <div>
            <span>Materi</span>
            <strong>{{ $materi->count() }}</strong>
            <p>panduan praktis</p>
        </div>
        <div>
            <span>Bacaan</span>
            <strong>{{ $jurnal->count() }}</strong>
            <p>jurnal dan laporan</p>
        </div>
        <div>
            <span>Quiz</span>
            <strong>{{ $totalQuiz }}</strong>
            <p>soal tersedia</p>
        </div>
    </section>

    <div class="content-section-title">
        <div>
            <p>Materi Praktis</p>
            <h3>Materi Gizi</h3>
        </div>
        <span>{{ $materi->count() }} materi</span>
    </div>

    <div class="grid-edukasi">
        @forelse ($materi as $item)
            <a href="{{ route('edukasi.show', $item->id) }}" class="card-edukasi article-card">
                <div class="article-card__media">
                    @if($item->gambar)
                        <img src="{{ $item->gambar }}" alt="{{ $item->judul }}">
                    @else
                        <span>GZ</span>
                    @endif
                </div>
                <div class="article-card__meta">
                    <span class="badge-type materi">Materi</span>
                </div>
                <h4>{{ $item->judul }}</h4>
                <p>{{ Str::limit(strip_tags($item->konten), 112) }}</p>
                <div class="article-card__footer">
                    <span>{{ $item->durasi_baca ?? 5 }} menit</span>
                    <strong>Baca</strong>
                </div>
            </a>
        @empty
            <div class="empty-state">Belum ada materi.</div>
        @endforelse
    </div>

    <div class="edukasi-cta">
        <div>
            <p class="hero-kicker">Langkah berikutnya</p>
            <h3>Lanjutkan dengan pencatatan</h3>
            <p>Gunakan data pertumbuhan balita untuk memantau status gizi secara rutin.</p>
        </div>
        <a href="{{ route('pencatatan.index') }}" class="btn-app btn-light">
            <span>Mulai Catat</span>
            <span class="btn-arrow" aria-hidden="true">-></span>
        </a>
    </div>

    <section class="edukasi-quiz-panel">
        <div>
            <p class="hero-kicker">Quiz Gizi</p>
            <h3>Uji pemahaman setelah membaca materi.</h3>
            <p>Ada {{ $totalQuiz }} soal pilihan ganda dari beberapa topik gizi. Mulai quiz dari sini tanpa keluar dari alur edukasi.</p>
        </div>
        <a href="{{ route('quiz.index') }}" class="btn-app btn-primary btn-large">
            <span>Buka Quiz</span>
            <span class="btn-arrow" aria-hidden="true">-></span>
        </a>
    </section>

    <div class="content-section-title">
        <div>
            <p>Bacaan Pendukung</p>
            <h3>Jurnal dan Laporan</h3>
        </div>
        <span>{{ $jurnal->count() }} bacaan</span>
    </div>

    <div class="grid-edukasi">
        @forelse ($jurnal as $item)
            @php($scholarUrl = $item->google_scholar_url ?: 'https://scholar.google.com/scholar?q=' . urlencode($item->judul))
            @php($pdfUrl = $item->pdf_url ?: $scholarUrl)
            <article class="card-edukasi article-card article-card--journal">
                <a href="{{ route('edukasi.show', $item->id) }}" class="article-card__media">
                    @if($item->gambar)
                        <img src="{{ $item->gambar }}" alt="{{ $item->judul }}">
                    @else
                        <span>JR</span>
                    @endif
                </a>
                <div class="article-card__meta">
                    <span class="badge-type jurnal">Jurnal/Laporan</span>
                </div>
                <h4>
                    <a href="{{ route('edukasi.show', $item->id) }}">{{ $item->judul }}</a>
                </h4>
                <p>{{ $item->ringkasan ?: Str::limit(strip_tags($item->konten), 130) }}</p>
                @if($item->sumber)
                    <p class="article-card__source">Sumber: {{ $item->sumber }}</p>
                @endif
                <div class="article-card__footer">
                    <span>{{ $item->durasi_baca ?? 10 }} menit</span>
                    <div class="article-card__links">
                        <a href="{{ route('edukasi.show', $item->id) }}">Detail</a>
                        <a href="{{ $scholarUrl }}" target="_blank" rel="noopener noreferrer" class="scholar-link">Cari referensi</a>
                    </div>
                </div>
            </article>
        @empty
            <div class="empty-state">Belum ada jurnal.</div>
        @endforelse
    </div>
</div>
@endsection
