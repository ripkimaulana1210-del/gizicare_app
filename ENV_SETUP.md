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
3. Tambahkan Authorized redirect URI: `http://localhost:8000/auth/google/callback`
4. Copy Client ID dan Client Secret ke `.env`:

```env
GOOGLE_CLIENT_ID=your_google_client_id
GOOGLE_CLIENT_SECRET=your_google_client_secret
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
```

## 4. Jalankan Migrasi

```bash
php artisan migrate
```

## 5. Jalankan Server

```bash
php artisan serve
```

Akses aplikasi di: http://localhost:8000

