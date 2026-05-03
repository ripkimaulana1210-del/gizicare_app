@extends('layouts.app')

@section('header')
    <h2 class="page-title">Edukasi Gizi</h2>
@endsection

@section('content')
<div class="container-form">
    {{-- Hero --}}
    <div class="edukasi-hero">
        <h3>Belajar Gizi Sehat</h3>
        <p>Tingkatkan pengetahuan gizi untuk menjaga kesehatan keluarga.</p>
    </div>

    {{-- Kategori filter --}}
    @if($kategori->count() > 0)
    <div class="flex flex-wrap gap-2 mt-6 mb-4">
        <span class="px-4 py-2 rounded-full bg-green-600 text-white text-sm font-semibold">Semua</span>
        @foreach($kategori as $kat)
            <span class="px-4 py-2 rounded-full bg-white text-green-700 text-sm font-semibold border border-green-100 hover:bg-green-50 cursor-pointer transition-all">{{ $kat }}</span>
        @endforeach
    </div>
    @endif

    {{-- Materi --}}
    <div class="flex items-center justify-between mt-8 mb-4">
        <h3 class="section-title text-lg">Materi Gizi</h3>
        <span class="text-sm text-gray-400">{{ $materi->count() }} materi</span>
    </div>

    <div class="grid-edukasi">
        @forelse ($materi as $item)
            <a href="{{ route('edukasi.show', $item->id) }}" class="card-edukasi group">
                @if($item->gambar)
                    <img src="{{ $item->gambar }}" class="w-full h-40 object-cover mb-3" alt="{{ $item->judul }}">
                @endif
                <div class="flex items-center gap-2 mb-2">
                    <span class="badge-type materi">Materi</span>
                    @if($item->kategori)
                        <span class="text-xs text-gray-400">{{ $item->kategori }}</span>
                    @endif
                </div>
                <h4 class="font-bold text-gray-800 group-hover:text-green-700 transition-colors">{{ $item->judul }}</h4>
                <p class="text-sm text-gray-500 mt-2">{{ Str::limit(strip_tags($item->konten), 100) }}</p>
                <div class="flex items-center justify-between mt-3 text-xs text-gray-400">
                    <span>{{ $item->durasi_baca ?? 5 }} menit</span>
                    <span class="text-green-700 font-semibold">Baca selengkapnya</span>
                </div>
            </a>
        @empty
            <p class="text-gray-500 col-span-full text-center py-8">Belum ada materi</p>
        @endforelse
    </div>

    {{-- Pencatatan CTA --}}
    <div class="mt-8">
        <div class="edukasi-cta">
            <div>
                <h3>Lanjutkan dengan Pencatatan</h3>
                <p>Gunakan data pertumbuhan balita untuk memantau status gizi secara rutin.</p>
            </div>
            <a href="{{ route('pencatatan.index') }}" class="btn-app btn-light">Mulai Catat</a>
        </div>
    </div>

    {{-- Jurnal --}}
    <div class="flex items-center justify-between mt-10 mb-4">
        <h3 class="section-title text-lg">Jurnal Ilmiah</h3>
        <span class="text-sm text-gray-400">{{ $jurnal->count() }} jurnal</span>
    </div>

    <div class="grid-edukasi">
        @forelse ($jurnal as $item)
            <a href="{{ route('edukasi.show', $item->id) }}" class="card-edukasi group">
                <div class="flex items-center gap-2 mb-2">
                    <span class="badge-type jurnal">Jurnal</span>
                    @if($item->kategori)
                        <span class="text-xs text-gray-400">{{ $item->kategori }}</span>
                    @endif
                </div>
                <h4 class="font-bold text-gray-800 group-hover:text-blue-700 transition-colors">{{ $item->judul }}</h4>
                <p class="text-sm text-gray-500 mt-2">{{ Str::limit(strip_tags($item->konten), 100) }}</p>
                @if($item->sumber)
                    <p class="text-xs text-gray-400 mt-3">Sumber: {{ $item->sumber }}</p>
                @endif
                <div class="flex items-center justify-between mt-3 text-xs text-gray-400">
                    <span>{{ $item->durasi_baca ?? 10 }} menit</span>
                    <span class="text-blue-700 font-semibold">Baca selengkapnya</span>
                </div>
            </a>
        @empty
            <p class="text-gray-500 col-span-full text-center py-8">Belum ada jurnal</p>
        @endforelse
    </div>
</div>
@endsection
