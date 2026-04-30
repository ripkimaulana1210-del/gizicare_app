@extends('layouts.app')

@section('header')
    <h2 class="page-title">{{ $edukasi->judul }}</h2>
@endsection

@section('content')
<div class="container-form">
    <div class="form-card">
        {{-- Breadcrumb --}}
        <div class="flex items-center gap-2 text-sm text-gray-500 mb-4">
            <a href="{{ route('home') }}" class="text-green-700 hover:underline">Home</a>
            <span>/</span>
            <a href="{{ route('edukasi.index') }}" class="text-green-700 hover:underline">Edukasi</a>
            <span>/</span>
            <span>{{ $edukasi->tipe === 'materi' ? 'Materi' : 'Jurnal' }}</span>
        </div>

        {{-- Header card --}}
        <div class="mb-6">
            @if($edukasi->gambar)
                <img src="{{ $edukasi->gambar }}" alt="{{ $edukasi->judul }}"
                    class="w-full h-64 object-cover rounded-lg mb-4 shadow-md">
            @endif

            <div class="flex flex-wrap items-center gap-3 mb-3">
                <span class="badge-type {{ $edukasi->tipe === 'materi' ? 'materi' : 'jurnal' }}">
                    {{ $edukasi->tipe === 'materi' ? 'Materi' : 'Jurnal' }}
                </span>
                @if($edukasi->kategori)
                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-600">
                        {{ $edukasi->kategori }}
                    </span>
                @endif
                @if($edukasi->durasi_baca)
                    <span class="text-xs text-gray-400">{{ $edukasi->durasi_baca }} menit baca</span>
                @endif
            </div>

            <h1 class="text-2xl font-bold text-gray-800 mb-2">{{ $edukasi->judul }}</h1>
            @if($edukasi->sumber)
                <p class="text-sm text-gray-500">Sumber: {{ $edukasi->sumber }}</p>
            @endif
        </div>

        {{-- Content --}}
        <div class="prose prose-green max-w-none text-gray-700 leading-relaxed">
            {!! $edukasi->konten !!}
        </div>

        {{-- Back button --}}
        <div class="mt-8 pt-6 border-t border-gray-100">
            <a href="{{ route('edukasi.index') }}" class="btn-app btn-ghost">
                Kembali ke Edukasi
            </a>
        </div>
    </div>

    {{-- Related content --}}
    @if($related->count() > 0)
    <div class="mt-6">
        <h3 class="section-title mb-4">{{ $edukasi->tipe === 'materi' ? 'Materi Lainnya' : 'Jurnal Terkait' }}</h3>
        <div class="grid-edukasi">
            @foreach($related as $item)
                <a href="{{ route('edukasi.show', $item->id) }}" class="card-edukasi">
                    <div class="badge-type {{ $item->tipe === 'materi' ? 'materi' : 'jurnal' }}">
                        {{ $item->tipe === 'materi' ? 'Materi' : 'Jurnal' }}
                    </div>
                    <h4 class="font-bold text-gray-800 mt-2">{{ $item->judul }}</h4>
                    <p class="text-sm text-gray-500 mt-1">{{ Str::limit(strip_tags($item->konten), 80) }}</p>
                </a>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
