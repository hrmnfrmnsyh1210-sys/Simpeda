# Panduan Deploy SiMPeDa ke Hostinger (Shared Hosting / hPanel)

Stack: **Laravel 12 + PHP 8.2 + Vite/Tailwind**, database **MySQL**.
Repo GitHub: `https://github.com/hrmnfrmnsyh1210-sys/Simpeda.git`

Ringkasan strategi:
- **Kode PHP** → ditarik dari GitHub (Git deployment hPanel atau `git clone` via SSH).
- **`vendor/`** → dibuat di server dengan `composer install` (tidak ikut Git).
- **`public/build/`** (aset Vite) → dibuild di lokal, lalu di-upload (tidak ikut Git, tidak ada Node di server).
- **`.env`** + **database** → dibuat manual di server.
- **Document root** domain → diarahkan ke folder `public`.

---

## 0. Persiapan di komputer lokal (sudah / sekali saja)

```bash
# Build aset frontend untuk production (hasil: public/build/)
npm run build

# Pastikan kode terbaru sudah dipush ke GitHub
git add -A
git commit -m "Siapkan deploy ke Hostinger"
git push origin main
```

> Setiap kali ada perubahan tampilan (CSS/JS), ulangi `npm run build` lalu upload ulang folder `public/build` ke server.

---

## 1. Buat Database MySQL di hPanel

1. hPanel → **Databases** → **Management**.
2. Buat database baru. Catat:
   - **Database name** → mis. `u123456_simpeda`
   - **Username** → mis. `u123456_simpeda`
   - **Password** → (buat yang kuat, catat)
3. Catat juga **host** (biasanya `localhost`).

---

## 2. Aktifkan SSH & dapatkan akses

1. hPanel → **Advanced** → **SSH Access** → aktifkan.
2. Catat **IP/host**, **port**, **username**.
3. Connect dari komputer:
   ```bash
   ssh -p <port> <username>@<host>
   ```

---

## 3. Ambil kode dari GitHub ke server

Pilih SALAH SATU:

### Opsi A — Git deployment hPanel (otomatis saat push)
1. hPanel → **Advanced** → **GIT**.
2. Repository: `https://github.com/hrmnfrmnsyh1210-sys/Simpeda.git`
3. Branch: `main`
4. Directory: mis. `domains/NAMADOMAIN.com/simpeda`
5. (Opsional) salin **Webhook URL** ke GitHub → Settings → Webhooks agar auto-deploy tiap push.

### Opsi B — git clone via SSH (manual, lebih fleksibel)
```bash
cd ~/domains/NAMADOMAIN.com
git clone https://github.com/hrmnfrmnsyh1210-sys/Simpeda.git simpeda
cd simpeda
```

> Repo private? Pakai Personal Access Token GitHub di URL, atau tambahkan SSH key server ke GitHub.

---

## 4. Install dependency PHP (vendor) di server

```bash
cd ~/domains/NAMADOMAIN.com/simpeda
composer install --no-dev --optimize-autoloader
```

Jika `composer` tidak ada, pakai:
```bash
php composer.phar install --no-dev --optimize-autoloader
# atau cek versi PHP CLI yang benar, mis. /usr/bin/php8.2
```

---

## 5. Upload folder aset `public/build`

Folder `public/build` (hasil `npm run build`) TIDAK ada di Git. Upload manual:
- hPanel → **File Manager** → masuk ke `simpeda/public/` → upload folder `build` dari lokal,

  **atau** via SCP dari komputer lokal:
  ```bash
  scp -P <port> -r public/build <username>@<host>:~/domains/NAMADOMAIN.com/simpeda/public/
  ```

---

## 6. Buat file `.env` di server

Di folder `simpeda`, buat `.env` (lihat template `ENV PRODUCTION` di bawah / file `.env.production.example`).
Lalu:

```bash
php artisan key:generate          # isi APP_KEY otomatis
php artisan migrate --force       # buat tabel di MySQL
php artisan storage:link          # symlink storage publik
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

Set permission folder yang perlu ditulis:
```bash
chmod -R 775 storage bootstrap/cache
```

---

## 7. Arahkan Document Root ke folder `public`

Domain harus menunjuk ke `simpeda/public`, BUKAN ke root project (demi keamanan).

### Cara 1 — Ubah document root di hPanel (jika tersedia)
hPanel → **Websites** → kelola domain → cari pengaturan **Document Root / Website root** → set ke:
`domains/NAMADOMAIN.com/simpeda/public`

### Cara 2 — Symlink public_html ke public (via SSH)
```bash
cd ~
rm -rf domains/NAMADOMAIN.com/public_html
ln -s domains/NAMADOMAIN.com/simpeda/public domains/NAMADOMAIN.com/public_html
```

### Cara 3 — Tanpa ubah root (fallback)
Salin isi `simpeda/public/*` ke `public_html/`, lalu edit `public_html/index.php`:
ubah dua path `require __DIR__.'/../...'` menjadi `__DIR__.'/../simpeda/...'`.

---

## 8. Verifikasi

- Buka `https://NAMADOMAIN.com` → aplikasi tampil.
- Pastikan di `.env`: `APP_ENV=production`, `APP_DEBUG=false`.
- Cek log bila error: `storage/logs/laravel.log`.

---

## Update berikutnya (setelah ada perubahan kode)

```bash
# lokal
npm run build              # jika ada perubahan frontend
git add -A && git commit -m "update" && git push origin main

# server (via SSH)
cd ~/domains/NAMADOMAIN.com/simpeda
git pull origin main
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan config:cache && php artisan route:cache && php artisan view:cache
# upload ulang public/build bila aset berubah
```
