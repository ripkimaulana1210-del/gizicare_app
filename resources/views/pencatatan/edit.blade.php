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
        </div>

        <div class="form-group">
            <label>Nama</label>
            <input type="text" name="nama" value="{{ $item->nama }}" class="input-field">
        </div>

        <div class="form-group">
            <label>Jenis Kelamin</label>
            <select name="jk" class="input-field">
                <option value="L" {{ $item->jk == 'L' ? 'selected' : '' }}>Laki-laki</option>
                <option value="P" {{ $item->jk == 'P' ? 'selected' : '' }}>Perempuan</option>
            </select>
        </div>

        <div class="form-grid">
            <input type="number" name="umur" value="{{ $item->umur }}" class="input-field">
            <input type="number" step="0.1" name="bb" value="{{ $item->bb }}" class="input-field">
            <input type="number" step="0.1" name="tb" value="{{ $item->tb }}" class="input-field">
            <input type="number" step="0.1" name="lk" value="{{ $item->lk }}" class="input-field">
        </div>

        <button class="btn-submit">Update</button>

    </form>

</div>
@endsection
