@extends('layouts.app')

@section('header')
    <h2 class="page-title">Edit Data Gizi</h2>
@endsection

@section('content')
<div class="container-form">

    <form method="POST" action="{{ route('pencatatan.update', $item->id) }}" class="form-card">
        @csrf
        @method('PUT')

        <div class="form-header">
            <h3>Edit Data</h3>
            <p>Perbarui data pertumbuhan balita lalu hitung ulang status z-score WHO/UNICEF.</p>
        </div>

        <div class="form-group">
            <label>Nama</label>
            <input type="text" name="nama" value="{{ $item->nama }}" class="input-field">
        </div>

        <div class="form-group">
            <label>Posyandu/Tempat</label>
            <input type="text" name="posyandu" value="{{ old('posyandu', $item->posyandu ?? 'Umum') }}" class="input-field">
        </div>

        <div class="form-group">
            <label>Jenis Kelamin</label>
            <select name="jk" class="input-field">
                <option value="L" {{ $item->jk == 'L' ? 'selected' : '' }}>Laki-laki</option>
                <option value="P" {{ $item->jk == 'P' ? 'selected' : '' }}>Perempuan</option>
            </select>
        </div>

        <div class="form-grid">
            <div class="form-group">
                <label>Usia (bulan)</label>
                <input type="number" name="umur" value="{{ $item->umur }}" class="input-field">
            </div>
            <div class="form-group">
                <label>Berat (kg)</label>
                <input type="number" step="0.1" name="bb" value="{{ $item->bb }}" class="input-field">
            </div>
            <div class="form-group">
                <label>Panjang/Tinggi (cm)</label>
                <input type="number" step="0.1" name="tb" value="{{ $item->tb }}" class="input-field">
            </div>
            <div class="form-group">
                <label>Lingkar Kepala (opsional)</label>
                <input type="number" step="0.1" name="lk" value="{{ $item->lk }}" class="input-field">
            </div>
        </div>

        <button class="btn-submit">Update</button>

    </form>

</div>
@endsection
