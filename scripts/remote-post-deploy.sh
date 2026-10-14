#!/usr/bin/env bash
set -euo pipefail

cd "${SSH_PATH:?SSH_PATH is required}"

if [ ! -f .env ]; then
  echo "ERROR: .env missing on server."
  exit 1
fi

mkdir -p \
  storage/framework/cache/data \
  storage/framework/sessions \
  storage/framework/views \
  storage/logs \
  storage/app/public \
  bootstrap/cache \
  public/storage

chmod -R ug+rwx storage bootstrap/cache || true

# Uploads live on the public disk. public/storage must be a symlink or new files
# are written to storage/app/public and never appear on the site.
mkdir -p storage/app/public
if [ -d public/storage ] && [ ! -L public/storage ]; then
  rsync -a public/storage/ storage/app/public/
  rm -rf public/storage
fi

if [ ! -L public/storage ]; then
  php artisan storage:link
fi

chmod -R u=rwX,g=rX,o=rX storage/app/public || true
ls -ld public/storage

php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Deploy finished"
