@extends('layouts.app')

@section('header')
    <h2 class="page-title">Pencatatan Gizi Balita</h2>
@endsection

@section('content')
<div class="container-form">

    <div class="greeting-banner pencatatan-banner">
        <div class="greeting-text">
            <div class="greeting-sub">Pemantauan Balita</div>
            <div class="greeting-title">Catat data pertumbuhan dengan alur yang rapi.</div>
        </div>
        <div class="greeting-badge">
            <div class="greeting-badge-value">{{ $data->count() }}</div>
            <div class="greeting-badge-label">catatan</div>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert-error">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    @if (session('success'))
        <div class="auth-status">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('pencatatan.store') }}" class="form-card">
        @csrf

        <div class="form-header">
            <h3>Input Data Balita</h3>
            <p>Masukkan data lengkap untuk membantu pemantauan status gizi.</p>
        </div>

        {{-- Nama --}}
        <div class="form-group">
            <label>Nama Balita</label>
            <input type="text" name="nama" placeholder="Masukkan nama" class="input-field"
                value="{{ old('nama') }}">
        </div>

        {{-- Jenis Kelamin --}}
        <div class="form-group">
            <label>Jenis Kelamin</label>
            <select name="jk" class="input-field">
                <option value="">Pilih</option>
                <option value="L" {{ old('jk') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                <option value="P" {{ old('jk') == 'P' ? 'selected' : '' }}>Perempuan</option>
            </select>
        </div>

        {{-- GRID --}}
        <div class="form-grid">

            <div class="form-group">
                <label>Usia (bulan)</label>
                <input type="number" name="umur" placeholder="Contoh: 24" class="input-field"
                    value="{{ old('umur') }}">
            </div>

            <div class="form-group">
                <label>Berat (kg)</label>
                <input type="number" step="0.1" name="bb" placeholder="Contoh: 12.5" class="input-field"
                    value="{{ old('bb') }}">
            </div>

            <div class="form-group">
                <label>Tinggi (cm)</label>
                <input type="number" step="0.1" name="tb" placeholder="Contoh: 90" class="input-field"
                    value="{{ old('tb') }}">
            </div>

            <div class="form-group">
                <label>Lingkar Kepala (opsional)</label>
                <input type="number" step="0.1" name="lk" placeholder="Contoh: 48" class="input-field"
                    value="{{ old('lk') }}">
            </div>

        </div>

        <button class="btn-submit">
            Hitung & Simpan
        </button>
    </form>

    <div class="content-section-title">
        <div>
            <p>Riwayat</p>
            <h3>Data Balita</h3>
        </div>
        <span>{{ $data->count() }} catatan</span>
    </div>

    <div class="table-wrapper">
        <table class="custom-table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>JK</th>
                    <th>Usia</th>
                    <th>Berat</th>
                    <th>Tinggi</th>
                    <th>LK</th>
                    <th>IMT</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($data as $item)
                    <tr>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->jk }}</td>
                        <td>{{ $item->umur }}</td>
                        <td>{{ $item->bb }}</td>
                        <td>{{ $item->tb }}</td>
                        <td>{{ $item->lk ?? '-' }}</td>
                        <td>{{ $item->imt }}</td>

                        <td>
                            <span class="badge {{ \Illuminate\Support\Str::slug($item->status) }}">
                                {{ $item->status }}
                            </span>
                        </td>

                        <td class="flex gap-2">
                            <a href="{{ route('pencatatan.edit', $item->id) }}" class="btn-edit">
                                Edit
                            </a>

                            <form action="{{ route('pencatatan.destroy', $item->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn-delete">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9">
                            <div class="empty-state">Belum ada data.</div>
                        </td>
                    </tr>
                @endforelse
            </tbody>

        </table>
    </div>

</div>
@endsection
