# Konfigurasi Environment GiziCare

## 1. Konfigurasi Database (.env)
Pastikan database MySQL sudah aktif, lalu sesuaikan:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gizicare_app
DB_USERNAME=root
DB_PASSWORD=
```

## 2. Konfigurasi Mail (untuk Verifikasi Email & Reset Password)

Gunakan Mailtrap untuk development:

```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@gizicare.com"
MAIL_FROM_NAME="GiziCare"
```

Atau gunakan Gmail SMTP:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=emailkamu@gmail.com
MAIL_PASSWORD=app_password_gmail
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="emailkamu@gmail.com"
MAIL_FROM_NAME="GiziCare"
```

## 3. Konfigurasi Google OAuth (untuk Login dengan Google)

1. Buka [Google Cloud Console](https://console.cloud.google.com/)
2. Buat project baru → APIs & Services → Credentials → Create OAuth 2.0 Client ID
3. Pilih tipe aplikasi **Web application**
4. Tambahkan Authorized redirect URI: `http://localhost:8000/auth/google/callback`
5. Pastikan `APP_URL` di `.env` sesuai domain/port aplikasi, contoh `http://localhost:8000`
6. Copy Client ID dan Client Secret ke `.env`:

```env
GOOGLE_CLIENT_ID=your_google_client_id
GOOGLE_CLIENT_SECRET=your_google_client_secret
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
```

Setelah mengubah konfigurasi Google, jalankan:

```bash
php artisan config:clear
```

## 4. Konfigurasi Gemini API (untuk Diagnosis AI)

1. Buka [Google AI Studio](https://aistudio.google.com/app/apikey)
2. Buat API key Gemini
3. Tambahkan ke `.env`:

```env
GEMINI_API_KEY=your_gemini_api_key
GEMINI_MODEL=gemini-2.5-flash
```

Setelah mengubah `.env`, jalankan:

```bash
php artisan config:clear
```

## 5. Jalankan Migrasi

```bash
php artisan migrate
```

## 6. Jalankan Server

```bash
php artisan serve
```

Akses aplikasi di: http://localhost:8000
