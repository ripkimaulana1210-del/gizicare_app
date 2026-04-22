<x-app-layout>
    <x-slot name="header">
        <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    </x-slot>

    <div class="app-shell">

        {{-- ═══ SIDEBAR ═══ --}}
        <aside class="sidebar">
            <div class="sidebar-logo">
                <div class="logo-mark">🌿</div>
                <div>
                    <div class="logo-text">NutriCare</div>
                    <div class="logo-sub">Admin Panel</div>
                </div>
            </div>

            <div class="sidebar-profile">
                <div class="profile-avatar">👤</div>
                <div>
                    <div class="profile-name">{{ Auth::user()->name ?? 'Admin' }}</div>
                    <div class="profile-role">Super Admin</div>
                </div>
                <div class="profile-dot"></div>
            </div>

            <nav class="sidebar-nav">
                <div class="nav-section-label">Menu Utama</div>
                <a class="nav-item active" href="{{ route('dashboard') }}">
                    <div class="nav-icon">🏠</div>
                    <span class="nav-label">Dashboard</span>
                </a>
                <a class="nav-item" href="/edukasi">
                    <div class="nav-icon">📚</div>
                    <span class="nav-label">Kelola Edukasi</span>
                    <span class="nav-badge">24</span>
                </a>
                <a class="nav-item" href="/pencatatan">
                    <div class="nav-icon">📊</div>
                    <span class="nav-label">Data Gizi</span>
                </a>
                <a class="nav-item" href="/diagnosis">
                    <div class="nav-icon">🧪</div>
                    <span class="nav-label">Monitoring</span>
                    <span class="nav-badge">17</span>
                </a>

                <div class="nav-section-label">Manajemen</div>
                <a class="nav-item" href="/users">
                    <div class="nav-icon">👥</div>
                    <span class="nav-label">Pengguna</span>
                </a>
                <a class="nav-item" href="/laporan">
                    <div class="nav-icon">📋</div>
                    <span class="nav-label">Laporan</span>
                </a>
                <a class="nav-item" href="/settings">
                    <div class="nav-icon">⚙️</div>
                    <span class="nav-label">Pengaturan</span>
                </a>
            </nav>

            <div class="sidebar-footer">
                <div class="sidebar-version">
                    <span>🔒</span>
                    <span class="version-text">NutriCare v2.4.1 · Aman</span>
                </div>
            </div>
        </aside>

        {{-- ═══ MAIN ═══ --}}
        <main class="main">

            {{-- Top Bar --}}
            <div class="topbar">
                <div class="topbar-left">
                    <h1>Dashboard Admin</h1>
                    <p>Ringkasan sistem nutrisi & kesehatan hari ini</p>
                </div>
                <div class="topbar-right">
                    <div class="topbar-date">📅 {{ now()->translatedFormat('l, d F Y') }}</div>
                    <div class="topbar-notif">
                        🔔
                        <span class="notif-dot"></span>
                    </div>
                </div>
            </div>

            <div class="content">

                {{-- Hero Banner --}}
                <div class="hero-banner">
                    <div class="hero-dots"></div>
                    <div class="hero-shape-1"></div>
                    <div class="hero-shape-2"></div>

                    <div class="hero-text">
                        <div class="hero-eyebrow">Sistem Berjalan Normal</div>
                        <h2 class="hero-title">
                            Selamat Datang,<br>
                            <span>{{ Auth::user()->name ?? 'Admin' }}</span> 👋
                        </h2>
                        <p class="hero-sub">
                            Pantau dan kelola seluruh data kesehatan gizi pengguna dari satu tempat terpadu.
                        </p>
                        <div class="hero-actions">
                            <a class="btn-hero-primary" href="/laporan">✦ Lihat Laporan</a>
                            <a class="btn-hero-secondary" href="/pencatatan/export">📥 Export Data</a>
                        </div>
                    </div>

                    <div class="hero-metrics">
                        <div class="hero-metric-card">
                            <div class="hero-metric-value green">128</div>
                            <div class="hero-metric-label">Total Pengguna</div>
                            <div class="hero-metric-trend">↑ +12 bulan ini</div>
                        </div>
                        <div class="hero-metric-card">
                            <div class="hero-metric-value mint">98%</div>
                            <div class="hero-metric-label">Uptime Sistem</div>
                            <div class="hero-metric-trend">● Online</div>
                        </div>
                    </div>
                </div>

                {{-- Stats Strip --}}
                <div class="stats-strip">
                    <div class="stat-card s1">
                        <div class="stat-icon-wrap">📚</div>
                        <div class="stat-info">
                            <div class="stat-num">24</div>
                            <div class="stat-lbl">Konten Edukasi</div>
                        </div>
                        <div class="stat-change up">+3 baru</div>
                    </div>
                    <div class="stat-card s2">
                        <div class="stat-icon-wrap">👥</div>
                        <div class="stat-info">
                            <div class="stat-num">128</div>
                            <div class="stat-lbl">Total Pengguna</div>
                        </div>
                        <div class="stat-change up">+12</div>
                    </div>
                    <div class="stat-card s3">
                        <div class="stat-icon-wrap">📊</div>
                        <div class="stat-info">
                            <div class="stat-num">342</div>
                            <div class="stat-lbl">Data Gizi</div>
                        </div>
                        <div class="stat-change up">+28</div>
                    </div>
                    <div class="stat-card s4">
                        <div class="stat-icon-wrap">🧪</div>
                        <div class="stat-info">
                            <div class="stat-num">17</div>
                            <div class="stat-lbl">Diagnosa Hari Ini</div>
                        </div>
                        <div class="stat-change amber">aktif</div>
                    </div>
                </div>

                {{-- Menu Cards --}}
                <div class="two-col">

                    <a class="menu-card mc-green" href="/edukasi">
                        <div class="mc-icon-area">
                            <div class="mc-icon">📚</div>
                            <div class="mc-status"><span class="mc-status-dot"></span>Edukasi</div>
                        </div>
                        <div class="mc-body">
                            <div class="mc-title">Kelola Edukasi</div>
                            <div class="mc-desc">Tambah, edit, dan susun konten edukasi gizi yang informatif untuk pengguna.</div>
                        </div>
                        <div class="mc-footer">
                            <div class="mc-meta">
                                <div class="mc-meta-value">24 Konten</div>
                                <div class="mc-meta-label">Dipublikasi</div>
                            </div>
                            <div class="mc-arrow">
                                <svg viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M5 12h14M12 5l7 7-7 7"/>
                                </svg>
                            </div>
                        </div>
                    </a>

                    <a class="menu-card mc-teal" href="/pencatatan">
                        <div class="mc-icon-area">
                            <div class="mc-icon">📊</div>
                            <div class="mc-status"><span class="mc-status-dot"></span>Gizi</div>
                        </div>
                        <div class="mc-body">
                            <div class="mc-title">Data Gizi</div>
                            <div class="mc-desc">Pantau dan analisis status gizi seluruh pengguna secara real-time dan komprehensif.</div>
                        </div>
                        <div class="mc-footer">
                            <div class="mc-meta">
                                <div class="mc-meta-value">342 Entri</div>
                                <div class="mc-meta-label">Tercatat</div>
                            </div>
                            <div class="mc-arrow">
                                <svg viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M5 12h14M12 5l7 7-7 7"/>
                                </svg>
                            </div>
                        </div>
                    </a>

                    <a class="menu-card mc-lime" href="/diagnosis">
                        <div class="mc-icon-area">
                            <div class="mc-icon">🧪</div>
                            <div class="mc-status"><span class="mc-status-dot"></span>Monitoring</div>
                        </div>
                        <div class="mc-body">
                            <div class="mc-title">Monitoring</div>
                            <div class="mc-desc">Analisis mendalam kondisi gizi dan buat laporan diagnosa untuk tindak lanjut klinis.</div>
                        </div>
                        <div class="mc-footer">
                            <div class="mc-meta">
                                <div class="mc-meta-value">17 Hari Ini</div>
                                <div class="mc-meta-label">Diagnosa</div>
                            </div>
                            <div class="mc-arrow">
                                <svg viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M5 12h14M12 5l7 7-7 7"/>
                                </svg>
                            </div>
                        </div>
                    </a>

                </div>

                {{-- Bottom: Activity + Quick Actions --}}
                <div class="bottom-grid">

                    <div class="activity-card">
                        <div class="section-header">
                            <div class="section-title">Aktivitas Terbaru</div>
                            <a class="section-see-all" href="#">Lihat semua →</a>
                        </div>
                        <div class="activity-list">
                            <div class="activity-item">
                                <div class="act-avatar green">📝</div>
                                <div class="act-info">
                                    <div class="act-name">Konten baru ditambahkan</div>
                                    <div class="act-detail">"Panduan Gizi Seimbang untuk Anak"</div>
                                </div>
                                <div class="act-dot green"></div>
                                <div class="act-time">2 mnt lalu</div>
                            </div>
                            <div class="activity-item">
                                <div class="act-avatar mint">👤</div>
                                <div class="act-info">
                                    <div class="act-name">Pengguna baru terdaftar</div>
                                    <div class="act-detail">siti.rahayu@gmail.com</div>
                                </div>
                                <div class="act-dot mint"></div>
                                <div class="act-time">18 mnt</div>
                            </div>
                            <div class="activity-item">
                                <div class="act-avatar lime">📊</div>
                                <div class="act-info">
                                    <div class="act-name">Data gizi diperbarui</div>
                                    <div class="act-detail">Budi Santoso — BB 68kg, TB 172cm</div>
                                </div>
                                <div class="act-dot lime"></div>
                                <div class="act-time">1 jam</div>
                            </div>
                            <div class="activity-item">
                                <div class="act-avatar amber">🧪</div>
                                <div class="act-info">
                                    <div class="act-name">Diagnosa selesai</div>
                                    <div class="act-detail">12 pasien — Status: Normal</div>
                                </div>
                                <div class="act-dot amber"></div>
                                <div class="act-time">2 jam</div>
                            </div>
                            <div class="activity-item">
                                <div class="act-avatar green">📋</div>
                                <div class="act-info">
                                    <div class="act-name">Laporan bulanan dibuat</div>
                                    <div class="act-detail">Maret 2026 — 128 pengguna aktif</div>
                                </div>
                                <div class="act-dot green"></div>
                                <div class="act-time">kemarin</div>
                            </div>
                        </div>
                    </div>

                    <div class="quick-card">
                        <div class="quick-section-title">⚡ Akses Cepat</div>
                        <div class="quick-actions">
                            <a class="quick-action-btn" href="/edukasi/create">
                                <div class="qa-icon g">➕</div>
                                <span class="qa-label">Tambah Konten Edukasi</span>
                                <span class="qa-arrow">›</span>
                            </a>
                            <a class="quick-action-btn" href="/pencatatan/export">
                                <div class="qa-icon m">📥</div>
                                <span class="qa-label">Export Data Gizi</span>
                                <span class="qa-arrow">›</span>
                            </a>
                            <a class="quick-action-btn" href="/users">
                                <div class="qa-icon l">👥</div>
                                <span class="qa-label">Kelola Pengguna</span>
                                <span class="qa-arrow">›</span>
                            </a>
                            <a class="quick-action-btn" href="/laporan">
                                <div class="qa-icon a">📋</div>
                                <span class="qa-label">Laporan Bulanan</span>
                                <span class="qa-arrow">›</span>
                            </a>
                            <a class="quick-action-btn" href="/settings">
                                <div class="qa-icon c">⚙️</div>
                                <span class="qa-label">Pengaturan Sistem</span>
                                <span class="qa-arrow">›</span>
                            </a>
                        </div>

                        <div class="health-score">
                            <div class="hs-label">Skor Kesehatan Sistem</div>
                            <div class="hs-value">82<span>/100</span></div>
                            <div class="hs-bar-wrap"><div class="hs-bar"></div></div>
                            <div class="hs-sub">Sangat Baik — Semua layanan aktif</div>
                        </div>
                    </div>

                </div>

            </div>{{-- /content --}}
        </main>
    </div>
</x-app-layout>