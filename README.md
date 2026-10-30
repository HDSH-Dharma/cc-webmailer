# cc-webmailer – Nada Senja Live 2026 Ticket Registration

Form pendaftaran tiket konser (Laravel 13) untuk tugas Cloud Computing. Setelah form disubmit:

1. Data disimpan ke database (password di-hash).
2. **Detail form dikirim ke email yang diketik di field Email** lewat **Purelymail SMTP**. Kalau dosen mengetik email dia sendiri, detailnya masuk ke inbox dosen.
3. Email berisi tombol **Confirm My Registration** yang berlaku **7 hari**. Kalau diklik, pendaftaran ditandai *confirmed*.

| Ketentuan tugas | Implementasi |
|---|---|
| Form: Full Name, Email, Password, Confirm Password, Birthdate | `resources/views/registration/create.blade.php` (+ kategori tiket & jumlah) |
| Terhubung ke backend | `RegistrationController`, validasi `StoreRegistrationRequest`, tabel `registrations` |
| Terhubung ke webmail server | Purelymail SMTP `smtp.purelymail.com:465`, diatur di `.env` |
| Email konfirmasi ke email yang didaftarkan | `resources/views/emails/registration-confirmation.blade.php`: sapaan, kotak *Registration Details*, tombol hijau, catatan 7 hari, footer kontak |
| Link halaman registrasi untuk dikumpulkan | Domain site baru di CloudPanel, misalnya `https://tiket.mav.my.id` (lihat bagian 4) |

Catatan:
- Satu email boleh dipakai daftar berkali-kali, jadi dosen bisa tes berulang dengan email yang sama.
- Kalau SMTP gagal, data **tidak** disimpan (transaksi di-rollback) dan muncul pesan error di form.
- Opsional: isi `CONCERT_BCC_EMAIL` di `.env` kalau setiap email konfirmasi juga mau dikirimi salinan tersembunyi (BCC) ke alamat tertentu.
- Nama konser, tagline, tanggal, venue, dan harga tiket bisa diubah di `.env` (`CONCERT_*`) atau `config/concert.php`.
- Tampilan mengikuti desain portofolio `hdsh.mav.my.id` (maroon `#800000`, aksen hijau `#004d40`, judul serif, mendukung dark mode).

---

## 1. Jalankan lokal dengan Laravel Herd (macOS)

1. Install Herd dari https://herd.laravel.com (sudah termasuk PHP + Composer).
2. Clone ke folder Herd:
   ```bash
   cd ~/Herd
   git clone https://github.com/HDSH-Dharma/cc-webmailer.git
   cd cc-webmailer
   ```
   Repo ini private. Kalau diminta login, isi **Username** dengan `HDSH-Dharma` dan **Password** dengan Personal Access Token (lihat bagian 3), bukan password GitHub.
3. Setup:
   ```bash
   composer install
   cp .env.example .env
   php artisan key:generate
   touch database/database.sqlite
   php artisan migrate
   ```
4. Isi `MAIL_PASSWORD` di `.env` dengan password mailbox `hdsh@mav.my.id` (lihat bagian 2).
5. Buka **http://cc-webmailer.test**. Herd otomatis menyajikan folder di `~/Herd` sebagai `<nama-folder>.test`.
6. (Opsional) Jalankan test: `php artisan test`

## 2. Setting Purelymail

Mailbox `hdsh@mav.my.id` sudah dibuat di Purelymail, dan domain `mav.my.id` sudah terverifikasi di sana. Jadi DNS **tidak perlu diubah**. Cukup isi `.env`:

```env
MAIL_MAILER=smtp
MAIL_SCHEME=smtps
MAIL_HOST=smtp.purelymail.com
MAIL_PORT=465
MAIL_USERNAME=hdsh@mav.my.id
MAIL_PASSWORD=password-mailbox-hdsh
MAIL_FROM_ADDRESS="hdsh@mav.my.id"
MAIL_FROM_NAME="Nada Senja Live 2026"
```

- Username harus alamat email lengkap. Password yang dipakai adalah password mailbox itu (atau *app password* kalau 2FA aktif).
- Kalau port 465 diblokir jaringan, pakai `MAIL_SCHEME=smtp` dan `MAIL_PORT=587` (STARTTLS).
- Tulis nama pengirim langsung, jangan pakai `${APP_NAME}`, supaya nggak muncul mentah di inbox.
- Jangan pernah commit `.env` (sudah ada di `.gitignore`).

## 3. Personal Access Token (PAT) GitHub untuk server

Karena repo **private**, server CloudPanel butuh token untuk `git clone` / `git pull`.

1. GitHub → **Settings → Developer settings → Personal access tokens → Fine-grained tokens → Generate new token**
2. Isi:
   - **Token name:** `cloudpanel-cc-webmailer`
   - **Expiration:** misalnya 90 hari (cukup sampai akhir semester)
   - **Repository access:** *Only select repositories* → `cc-webmailer`
   - **Permissions → Repository permissions → Contents:** *Read-only* (Metadata otomatis read-only)
3. Klik **Generate token** lalu salin token `github_pat_...`. Token cuma ditampilkan sekali.

Token ini **hanya bisa membaca repo ini**, jadi aman dipakai di server. Jangan taruh token di kode atau di README.

## 4. Deploy ke CloudPanel

> **Jangan deploy ke folder `hdsh.mav.my.id`**, karena di situ ada portofoliomu. Buat site baru khusus untuk app ini.

### a. Buat site baru

1. Di DNS Management `mav.my.id` (MyDomaiNesia), tambahkan A record subdomain baru, misalnya `tiket` → `103.103.138.174`. Ini IP publik yang sama dengan record `hdsh`, `www`, dll. IP yang tampil di header CloudPanel (`.163`) bukan IP yang dipakai DNS.
2. CloudPanel → **Sites → Add Site → Create a PHP Site**:
   - **Application:** Laravel 13
   - **Domain Name:** `tiket.mav.my.id`
   - **PHP Version:** 8.4 atau 8.5
   - **Site User:** misalnya `mav-tiket`, dengan password yang kuat (simpan password ini)
3. **SSL/TLS → Actions → New Let's Encrypt Certificate**.
4. Cek **Settings → Root Directory**: harus `tiket.mav.my.id/public`. Kalau dibuat dengan template Laravel, biasanya sudah otomatis begitu.

### b. Clone dari GitHub pakai PAT

Login SSH sebagai site user baru (lihat Troubleshooting kalau SSH gagal):

```bash
ssh mav-tiket@tiket.mav.my.id
cd ~/htdocs/tiket.mav.my.id
ls -A                                            # harus kosong; kalau ada isinya, pindahkan dulu
git config --global credential.helper store      # simpan PAT supaya git pull berikutnya nggak tanya lagi
git clone https://github.com/HDSH-Dharma/cc-webmailer.git .
#   Username: HDSH-Dharma
#   Password: <paste PAT github_pat_...>
cp .env.example .env
nano .env
```

Di `.env` server, ubah:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://tiket.mav.my.id
MAIL_PASSWORD=password-mailbox-hdsh
```

Lalu jalankan:

```bash
bash deploy.sh
```

`deploy.sh` menjalankan `git pull`, `composer install --no-dev`, membuat `APP_KEY` dan file SQLite kalau belum ada, `migrate`, dan `optimize`.

Buka `https://tiket.mav.my.id`, isi form dengan email kamu sendiri, lalu cek inbox. Link inilah yang dikumpulkan untuk tugas.

### Update setelah ada perubahan kode

Di laptop: `git add . && git commit -m "..." && git push`. Lalu di server:

```bash
cd ~/htdocs/tiket.mav.my.id && bash deploy.sh
```

## Troubleshooting

| Masalah | Solusi |
|---|---|
| `ssh: Connection reset by ... port 22` | Pastikan SSH ke nama domain atau IP publik `103.103.138.174`, bukan `.163`. Kalau masih ditolak, jaringan (misalnya Wi-Fi kampus) atau firewall server memblokir port 22. Coba lewat hotspot HP, atau minta admin server whitelist IP kamu (`curl ifconfig.me`) di CloudPanel → Admin Area → Security → Firewall. |
| Muncul pesan *"We could not send the confirmation email"* | Cek `MAIL_USERNAME`/`MAIL_PASSWORD` di `.env`. Detail error ada di `storage/logs/laravel.log`, atau set `APP_DEBUG=true` sementara. Setelah mengubah `.env` di server, jalankan `php artisan optimize`. |
| Link konfirmasi selalu "invalid or has expired" | `APP_URL` harus sama persis dengan alamat situs (https vs http), lalu jalankan `php artisan optimize`. Link yang sudah lewat 7 hari memang ditolak. |
| `composer` mengeluh versi PHP | Laravel 13 butuh PHP ≥ 8.3. Cek `php -v`. Di CloudPanel bisa pakai binary versi spesifik, misalnya `php8.4 /usr/local/bin/composer install`. |
| Halaman 500 / blank | Lihat `storage/logs/laravel.log`. Pastikan `bash deploy.sh` sudah jalan (migrasi + `APP_KEY`). |
