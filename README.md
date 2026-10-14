# Nsangi Parents' Primary School Website

Nsangi Parents' Primary School is a mixed day and boarding school offering Nursery to P.6.

Uses MySQL database: nansana_st_joseph

Setup:
  cp .env.example .env
  composer install
  php artisan key:generate
  php artisan migrate --seed
  npm install && npm run build

Windows helpers (optional, local only — not committed):
  copy artisan.bat.example artisan.bat
  copy serve.bat.example serve.bat
  copy php.ini.example php.ini
  Then edit php.ini (and the .bat files if needed) for your PHP install.

Run locally:
  php artisan serve
  or serve.bat (after copying/customizing the example)

enjoy codings
good luckS
success