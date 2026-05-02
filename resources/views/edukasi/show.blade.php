@extends('layouts.app')

@section('header')
    <h2 class="page-title">{{ $edukasi->judul }}</h2>
@endsection

@section('content')
<div class="container-form">
    <article class="form-card article-detail">
        <nav class="breadcrumb" aria-label="Breadcrumb">
            <a href="{{ route('home') }}">Home</a>
            <span>/</span>
            <a href="{{ route('edukasi.index') }}">Edukasi</a>
            <span>/</span>
            <span>{{ $edukasi->tipe === 'materi' ? 'Materi' : 'Jurnal' }}</span>
        </nav>

        <header class="article-detail__header">
            @if($edukasi->gambar)
                <img src="{{ $edukasi->gambar }}" alt="{{ $edukasi->judul }}"
                    class="article-detail__image">
            @endif

            <div class="article-detail__meta">
                <span class="badge-type {{ $edukasi->tipe === 'materi' ? 'materi' : 'jurnal' }}">
                    {{ $edukasi->tipe === 'materi' ? 'Materi' : 'Jurnal' }}
                </span>
                @if($edukasi->kategori)
                    <span class="chip chip-small">{{ $edukasi->kategori }}</span>
                @endif
                @if($edukasi->durasi_baca)
                    <span>{{ $edukasi->durasi_baca }} menit baca</span>
                @endif
            </div>

            <h1>{{ $edukasi->judul }}</h1>
            @if($edukasi->sumber)
                <p class="article-detail__source">Sumber: {{ $edukasi->sumber }}</p>
            @endif
        </header>

        @if($edukasi->tipe === 'jurnal')
            @php($scholarUrl = $edukasi->google_scholar_url ?: 'https://scholar.google.com/scholar?q=' . urlencode($edukasi->judul))
            @php($pdfUrl = $edukasi->pdf_url ?: $scholarUrl)
            <aside class="journal-summary-box">
                <div>
                    <span>Ringkasan Singkat</span>
                    <p>{{ $edukasi->ringkasan ?: Str::limit(strip_tags($edukasi->konten), 180) }}</p>
                </div>
                <div class="journal-summary-box__actions">
                    <a href="{{ $scholarUrl }}" target="_blank" rel="noopener noreferrer" class="btn-app btn-primary">
                        Cari PDF di Google Scholar
                    </a>
                    <a href="{{ $pdfUrl }}" target="_blank" rel="noopener noreferrer" class="btn-app btn-ghost">
                        PDF Resmi Jurnal
                    </a>
                </div>
            </aside>
        @endif

        <div class="article-body">
            {!! $edukasi->konten !!}
        </div>

        <div class="article-detail__actions">
            <a href="{{ route('edukasi.index') }}" class="btn-app btn-ghost">
                Kembali ke Edukasi
            </a>
            @if($edukasi->tipe === 'jurnal')
                @php($scholarUrl = $edukasi->google_scholar_url ?: 'https://scholar.google.com/scholar?q=' . urlencode($edukasi->judul))
                @php($pdfUrl = $edukasi->pdf_url ?: $scholarUrl)
                <a href="{{ $scholarUrl }}" target="_blank" rel="noopener noreferrer" class="btn-app btn-primary">
                    Cari PDF di Google Scholar
                </a>
                <a href="{{ $pdfUrl }}" target="_blank" rel="noopener noreferrer" class="btn-app btn-ghost">
                    PDF Resmi Jurnal
                </a>
            @endif
        </div>
    </article>

    @if($related->count() > 0)
    <div class="related-section">
        <div class="content-section-title">
            <div>
                <p>Rekomendasi</p>
                <h3>{{ $edukasi->tipe === 'materi' ? 'Materi Lainnya' : 'Jurnal Terkait' }}</h3>
            </div>
        </div>
        <div class="grid-edukasi">
            @foreach($related as $item)
                <a href="{{ route('edukasi.show', $item->id) }}" class="card-edukasi article-card article-card--compact">
                    <span class="badge-type {{ $item->tipe === 'materi' ? 'materi' : 'jurnal' }}">
                        {{ $item->tipe === 'materi' ? 'Materi' : 'Jurnal' }}
                    </span>
                    <h4>{{ $item->judul }}</h4>
                    <p>{{ Str::limit(strip_tags($item->konten), 88) }}</p>
                </a>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
