#!/usr/bin/env bash
# =====================================================================
# Skrip deploy SiMPeDa untuk Hostinger (jalankan via SSH dari folder project).
#
# Pemakaian:
#   bash deploy.sh            -> update biasa (pull, composer, migrate, cache)
#   bash deploy.sh --first    -> setup pertama kali (termasuk seed akun & storage:link)
#
# Catatan: aset frontend (public/build) sudah ikut di Git, jadi otomatis
#          ikut tertarik saat 'git pull'. Build ulang di lokal hanya jika
#          ada perubahan CSS/JS, lalu commit & push.
# =====================================================================
set -e

FIRST=0
[ "$1" = "--first" ] && FIRST=1

echo ">> Menarik kode terbaru dari GitHub..."
git pull origin main

echo ">> Install dependency PHP (composer)..."
composer install --no-dev --optimize-autoloader

if [ ! -f .env ]; then
  echo "!! File .env belum ada. Salin dari template lalu isi kredensial DB:"
  echo "   cp .env.production.example .env && nano .env"
  exit 1
fi

# Generate APP_KEY hanya jika masih kosong
if ! grep -q "^APP_KEY=base64:" .env; then
  echo ">> Generate APP_KEY..."
  php artisan key:generate --force
fi

echo ">> Menjalankan migrasi database..."
php artisan migrate --force

if [ "$FIRST" = "1" ]; then
  echo ">> Seeding data awal (akun admin, pengumuman, dll)..."
  php artisan db:seed --force
  echo ">> Membuat symlink storage (manual, hindari exec() yang diblokir Hostinger)..."
  mkdir -p storage/app/public
  ln -sfn ../storage/app/public public/storage
fi

echo ">> Membersihkan & membangun ulang cache..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo ">> Set permission folder writable..."
chmod -R 775 storage bootstrap/cache || true

echo ""
echo "== SELESAI =="
if [ "$FIRST" = "1" ]; then
  echo "Akun default (WAJIB ganti password setelah login):"
  echo "  superadmin@example.com / password"
  echo "  admin@gmail.com        / password"
  echo "Jangan lupa: arahkan document root domain ke folder 'public'."
fi
