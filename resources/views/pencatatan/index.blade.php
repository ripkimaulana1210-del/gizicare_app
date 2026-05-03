@extends('layouts.app')

@section('header')
    <h2 class="page-title">Pencatatan Gizi Balita</h2>
@endsection

@section('content')
<div class="container-form">

    <div class="greeting-banner pencatatan-banner">
        <div class="greeting-text">
            <div class="greeting-sub">Pemantauan Balita</div>
            <div class="greeting-title">Catat data pertumbuhan dengan standar WHO/UNICEF.</div>
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

    <div class="pencatatan-workspace">
        <form method="POST" action="{{ route('pencatatan.store') }}" class="form-card pencatatan-form-card">
            @csrf

            <div class="form-header">
                <h3>Input Data Balita</h3>
                <p>Status dihitung dari z-score WHO: BB/PB untuk usia &lt; 24 bulan, BB/TB untuk usia 24-60 bulan.</p>
            </div>

            <div class="form-group">
                <label for="nama">Nama Balita</label>
                <input type="text" id="nama" name="nama" placeholder="Masukkan nama" class="input-field"
                    maxlength="255" autocomplete="name" required
                    value="{{ old('nama') }}">
            </div>

            <div class="form-group">
                <label for="posyandu">Posyandu/Tempat</label>
                <input type="text" id="posyandu" name="posyandu" list="posyandu-options" placeholder="Contoh: Posyandu Melati" class="input-field"
                    maxlength="120" autocomplete="organization" required
                    value="{{ old('posyandu') }}">
                <datalist id="posyandu-options">
                    @foreach ($posyanduOptions as $posyandu)
                        <option value="{{ $posyandu }}"></option>
                    @endforeach
                </datalist>
            </div>

            <div class="form-group">
                <label for="jk">Jenis Kelamin</label>
                <select id="jk" name="jk" class="input-field" required>
                    <option value="">Pilih</option>
                    <option value="L" {{ old('jk') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('jk') == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label for="umur">Usia (bulan)</label>
                    <input type="number" id="umur" name="umur" placeholder="Contoh: 24" class="input-field"
                        min="0" max="60" inputmode="numeric" required
                        value="{{ old('umur') }}">
                </div>

                <div class="form-group">
                    <label for="bb">Berat (kg)</label>
                    <input type="number" id="bb" step="0.1" name="bb" placeholder="Contoh: 12.5" class="input-field"
                        min="1" max="35" inputmode="decimal" required
                        value="{{ old('bb') }}">
                </div>

                <div class="form-group">
                    <label for="tb">Panjang/Tinggi (cm)</label>
                    <input type="number" id="tb" step="0.1" name="tb" placeholder="Contoh: 90" class="input-field"
                        min="45" max="120" inputmode="decimal" required
                        value="{{ old('tb') }}">
                </div>

                <div class="form-group">
                    <label for="lk">Lingkar Kepala (opsional)</label>
                    <input type="number" id="lk" step="0.1" name="lk" placeholder="Contoh: 48" class="input-field"
                        min="0" inputmode="decimal"
                        value="{{ old('lk') }}">
                </div>
            </div>

            <button type="submit" class="btn-submit">
                <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span>Hitung & Simpan</span>
            </button>
        </form>

        <aside class="pencatatan-insight-card">
            <p>Panel Pemantauan</p>
            <h3>Data terbaru akan membantu membaca arah pertumbuhan.</h3>
            <div class="growth-bars" aria-label="Distribusi status gizi saat ini">
                @if($data->count() > 0)
                    @php($maxInsight = max(1, $statusSummary->max('count') ?? 1))
                    @foreach ($statusSummary as $item)
                        <span
                            title="{{ $item['status'] }}: {{ $item['count'] }}"
                            style="height: {{ $item['count'] > 0 ? max(16, ($item['count'] / $maxInsight) * 100) : 6 }}%"
                        ></span>
                    @endforeach
                @else
                    <span class="growth-bars__empty">Belum ada catatan</span>
                @endif
            </div>
            <div class="insight-points">
                <span>Catatan: {{ $data->count() }}</span>
                <span>Z-score WHO</span>
                <span>Standar UNICEF</span>
            </div>
        </aside>
    </div>

    <div class="pencatatan-analytics-grid">
        <section class="pencatatan-chart-panel">
            <div class="content-section-title">
                <div>
                    <p>Grafik</p>
                    <h3>Catatan per Posyandu/Tempat</h3>
                </div>
                <span>{{ $posyanduSummary->count() }} tempat</span>
            </div>

            <div class="chart-canvas-wrap">
                <canvas id="posyanduChart" width="760" height="320" aria-label="Grafik catatan per posyandu"></canvas>
            </div>
            <div class="chart-legend">
                <span><i class="chart-legend__total"></i>Total</span>
                <span><i class="chart-legend__attention"></i>Perlu perhatian</span>
            </div>
        </section>

        <section class="pencatatan-chart-panel">
            <div class="content-section-title">
                <div>
                    <p>Distribusi</p>
                    <h3>Status Gizi {{ $selectedPosyandu ?: 'Semua Tempat' }}</h3>
                </div>
                <span>{{ $data->count() }} catatan</span>
            </div>

            <div class="status-breakdown">
                @php($maxStatus = max(1, $statusSummary->max('count') ?? 1))
                @foreach ($statusSummary as $item)
                    <div class="status-row">
                        <div class="status-row__meta">
                            <span>{{ $item['status'] }}</span>
                            <strong>{{ $item['count'] }}</strong>
                        </div>
                        <div class="status-row__track" aria-hidden="true">
                            <span style="width: {{ ($item['count'] / $maxStatus) * 100 }}%"></span>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="pencatatan-chart-panel">
            <div class="content-section-title">
                <div>
                    <p>Stunting</p>
                    <h3>Status TB/U {{ $selectedPosyandu ?: 'Semua Tempat' }}</h3>
                </div>
                <span>{{ $data->count() }} catatan</span>
            </div>

            <div class="status-breakdown status-breakdown--stunting">
                @php($maxStunting = max(1, $stuntingSummary->max('count') ?? 1))
                @foreach ($stuntingSummary as $item)
                    <div class="status-row">
                        <div class="status-row__meta">
                            <span>{{ $item['status'] }}</span>
                            <strong>{{ $item['count'] }}</strong>
                        </div>
                        <div class="status-row__track" aria-hidden="true">
                            <span style="width: {{ ($item['count'] / $maxStunting) * 100 }}%"></span>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    </div>

    <div class="pencatatan-history-panel">
        <div class="content-section-title">
            <div>
                <p>Riwayat</p>
                <h3>Data Balita {{ $selectedPosyandu ? "- {$selectedPosyandu}" : '' }}</h3>
            </div>
            <form method="GET" action="{{ route('pencatatan.index') }}" class="pencatatan-filter">
                <select name="posyandu" class="input-field" onchange="this.form.submit()">
                    <option value="">Semua tempat</option>
                    @foreach ($posyanduOptions as $posyandu)
                        <option value="{{ $posyandu }}" {{ $selectedPosyandu === $posyandu ? 'selected' : '' }}>
                            {{ $posyandu }}
                        </option>
                    @endforeach
                </select>
                @if ($selectedPosyandu)
                    <a href="{{ route('pencatatan.index') }}" class="btn-edit">Reset</a>
                @endif
            </form>
        </div>

        <div class="table-wrapper">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Posyandu/Tempat</th>
                        <th>JK</th>
                        <th>Usia</th>
                        <th>Berat</th>
                        <th>Tinggi</th>
                        <th>LK</th>
                        <th>Indikator</th>
                        <th>Z-score</th>
                        <th>Stunting</th>
                        <th>Z TB/U</th>
                        <th>IMT</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($data as $item)
                        <tr>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->posyandu ?? 'Umum' }}</td>
                            <td>{{ $item->jk }}</td>
                            <td>{{ $item->umur }}</td>
                            <td>{{ $item->bb }}</td>
                            <td>{{ $item->tb }}</td>
                            <td>{{ $item->lk ?? '-' }}</td>
                            <td>{{ $item->indikator ?? '-' }}</td>
                            <td>{{ is_null($item->z_score) ? '-' : number_format($item->z_score, 2) }}</td>
                            <td>
                                <span class="badge {{ \Illuminate\Support\Str::slug($item->status_stunting ?? 'belum-ada') }}">
                                    {{ $item->status_stunting ?? '-' }}
                                </span>
                            </td>
                            <td>{{ is_null($item->z_score_stunting) ? '-' : number_format($item->z_score_stunting, 2) }}</td>
                            <td>{{ number_format($item->imt, 2) }}</td>

                            <td>
                                <span class="badge {{ \Illuminate\Support\Str::slug($item->status) }}">
                                    {{ $item->status }}
                                </span>
                            </td>

                            <td>
                                <div class="table-actions">
                                    <a href="{{ route('pencatatan.edit', $item->id) }}" class="btn-edit">
                                        Edit
                                    </a>

                                    <form action="{{ route('pencatatan.destroy', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-delete" onclick="return confirm('Hapus catatan ini?')">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="14">
                                <div class="empty-state">Belum ada data.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>

</div>

<script>
    (() => {
        const chartData = @json($chartData['posyandu']);
        const canvas = document.getElementById('posyanduChart');

        if (!canvas) {
            return;
        }

        const ctx = canvas.getContext('2d');
        const ratio = window.devicePixelRatio || 1;
        const width = canvas.clientWidth || canvas.width;
        const height = canvas.clientHeight || canvas.height;

        canvas.width = width * ratio;
        canvas.height = height * ratio;
        ctx.scale(ratio, ratio);
        ctx.clearRect(0, 0, width, height);

        const padding = { top: 26, right: 24, bottom: 72, left: 42 };
        const plotWidth = width - padding.left - padding.right;
        const plotHeight = height - padding.top - padding.bottom;
        const max = Math.max(1, ...chartData.map((item) => item.count));

        ctx.font = '12px Inter, sans-serif';
        ctx.textBaseline = 'middle';
        ctx.strokeStyle = '#dbe7e0';
        ctx.lineWidth = 1;

        for (let i = 0; i <= 4; i += 1) {
            const y = padding.top + plotHeight - (plotHeight * i / 4);
            ctx.beginPath();
            ctx.moveTo(padding.left, y);
            ctx.lineTo(width - padding.right, y);
            ctx.stroke();
            ctx.fillStyle = '#6f8178';
            ctx.fillText(String(Math.round(max * i / 4)), 8, y);
        }

        if (chartData.length === 0) {
            ctx.fillStyle = '#6f8178';
            ctx.textAlign = 'center';
            ctx.fillText('Belum ada data untuk grafik.', width / 2, height / 2);
            return;
        }

        const gap = 14;
        const barWidth = Math.max(28, (plotWidth - gap * (chartData.length - 1)) / chartData.length);

        chartData.forEach((item, index) => {
            const x = padding.left + index * (barWidth + gap);
            const barHeight = plotHeight * (item.count / max);
            const y = padding.top + plotHeight - barHeight;
            const attentionHeight = item.count ? barHeight * (item.needs_attention / item.count) : 0;

            ctx.fillStyle = '#0b4a2d';
            ctx.fillRect(x, y, barWidth, barHeight);

            ctx.fillStyle = '#f59e0b';
            ctx.fillRect(x, y, barWidth, attentionHeight);

            ctx.fillStyle = '#0b2f22';
            ctx.textAlign = 'center';
            ctx.font = '700 12px Inter, sans-serif';
            ctx.fillText(String(item.count), x + barWidth / 2, y - 10);

            ctx.save();
            ctx.translate(x + barWidth / 2, height - 42);
            ctx.rotate(-Math.PI / 6);
            ctx.fillStyle = '#395048';
            ctx.font = '11px Inter, sans-serif';
            ctx.fillText(item.label.length > 16 ? `${item.label.slice(0, 16)}...` : item.label, 0, 0);
            ctx.restore();
        });
    })();
</script>
@endsection
