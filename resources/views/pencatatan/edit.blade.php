@extends('layouts.app')

@section('header')
    <h2 class="page-title">Edit Data Gizi</h2>
@endsection

@section('content')
<div class="container-form">

    @if ($errors->any())
        <div class="alert-error">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('pencatatan.update', $item->id) }}" class="form-card">
        @csrf
        @method('PUT')

        <div class="form-header">
            <h3>Edit Data</h3>
            <p>Perbarui data pertumbuhan balita lalu hitung ulang status z-score WHO/UNICEF.</p>
        </div>

        <div class="form-group">
            <label for="nama">Nama</label>
            <input type="text" id="nama" name="nama" value="{{ old('nama', $item->nama) }}" class="input-field"
                maxlength="255" autocomplete="name" required>
        </div>

        <div class="form-group">
            <label for="posyandu">Posyandu/Tempat</label>
            <input type="text" id="posyandu" name="posyandu" value="{{ old('posyandu', $item->posyandu ?? 'Umum') }}" class="input-field"
                maxlength="120" autocomplete="organization" required>
        </div>

        <div class="form-group">
            <label for="jk">Jenis Kelamin</label>
            <select id="jk" name="jk" class="input-field" required>
                <option value="L" {{ old('jk', $item->jk) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                <option value="P" {{ old('jk', $item->jk) == 'P' ? 'selected' : '' }}>Perempuan</option>
            </select>
        </div>

        <div class="form-grid">
            <div class="form-group">
                <label for="umur">Usia (bulan)</label>
                <input type="number" id="umur" name="umur" value="{{ old('umur', $item->umur) }}" class="input-field"
                    min="0" max="60" inputmode="numeric" required>
            </div>
            <div class="form-group">
                <label for="bb">Berat (kg)</label>
                <input type="number" id="bb" step="0.1" name="bb" value="{{ old('bb', $item->bb) }}" class="input-field"
                    min="1" max="35" inputmode="decimal" required>
            </div>
            <div class="form-group">
                <label for="tb">Panjang/Tinggi (cm)</label>
                <input type="number" id="tb" step="0.1" name="tb" value="{{ old('tb', $item->tb) }}" class="input-field"
                    min="45" max="120" inputmode="decimal" required>
            </div>
            <div class="form-group">
                <label for="lk">Lingkar Kepala (opsional)</label>
                <input type="number" id="lk" step="0.1" name="lk" value="{{ old('lk', $item->lk) }}" class="input-field"
                    min="0" inputmode="decimal">
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('pencatatan.index') }}" class="btn-app btn-ghost">Batal</a>
            <button type="submit" class="btn-submit">
                <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span>Update</span>
            </button>
        </div>

    </form>

</div>
@endsection
