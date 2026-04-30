# TODO: Hapus Breeze + Vite & Tambah Fitur Auth

## Langkah 1: Setup Dependencies
- [x] Install laravel/socialite
- [x] Update config/services.php (tambah Google)

## Langkah 2: Database
- [x] Buat migration google_id + nullable password
- [x] Update User model (fillable, MustVerifyEmail)
- [x] Jalankan migrasi

## Langkah 3: Controller
- [x] Buat GoogleController (redirect & callback)
- [x] Update RegisteredUserController untuk enforce email verification

## Langkah 4: Routes
- [x] Tambah route Google di routes/auth.php
- [x] Tambah route Quiz di routes/web.php
- [x] Tambah route Edukasi show di routes/web.php

## Langkah 5: Hapus Vite & Breeze Components
- [x] Hapus vite.config.js, postcss.config.js, tailwind.config.js
- [x] Hapus folder resources/views/components/
- [x] Hapus folder app/View/Components/
- [x] Update package.json (hapus Vite deps)

## Langkah 6: Rewrite Layouts
- [x] Rewrite resources/views/layouts/app.blade.php (CDN + yield)
- [x] Rewrite resources/views/layouts/guest.blade.php (CDN + yield)

## Langkah 7: Rewrite Auth Views
- [x] Rewrite login.blade.php (+ tombol Google)
- [x] Rewrite register.blade.php (+ tombol Google)
- [x] Rewrite forgot-password.blade.php
- [x] Rewrite reset-password.blade.php
- [x] Rewrite verify-email.blade.php
- [x] Rewrite confirm-password.blade.php

## Langkah 8: Update CSS & JS
- [x] Update resources/css/app.css
- [x] Update resources/js/app.js
- [x] Update public/css/app.css

## Langkah 9: Edukasi Module
- [x] Buat migration add_fields_to_edukasis_table
- [x] Update Edukasi model & controller
- [x] Buat EdukasiSeeder dengan materi & jurnal
- [x] Buat view edukasi/index.blade.php
- [x] Buat view edukasi/show.blade.php

## Langkah 10: Quiz Module
- [x] Buat migration quizzes & quiz_results
- [x] Buat Quiz & QuizResult model
- [x] Buat QuizController
- [x] Buat QuizSeeder dengan 10 soal
- [x] Buat view quiz/index.blade.php
- [x] Buat view quiz/show.blade.php
- [x] Buat view quiz/result.blade.php

## Langkah 11: Mail & Verification
- [x] Update .env template (MAIL + GOOGLE)
- [x] Pastikan middleware verified digunakan

## Langkah 12: Testing
- [x] php artisan migrate (berhasil)
- [x] php artisan db:seed (8 edukasi, 10 quiz)
- [x] Verifikasi route Google tersedia
- [x] Verifikasi route password reset tersedia
- [x] Verifikasi route email verification tersedia
- [x] Verifikasi google_id column ada di tabel users

