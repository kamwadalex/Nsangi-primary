# Nsangi Parents' Primary School Website

Nsangi Parents' Primary School is a mixed day and boarding school offering Nursery to P.6.

Local development uses MySQL. Create the `nsangii_primary` database in MySQL or phpMyAdmin before running migrations; Laravel migrations create tables but do not create the database itself.

Setup:
  cp .env.example .env
  composer install
  php artisan key:generate
  php artisan migrate --seed
  npm install && npm run build

For a local XAMPP MySQL instance, start MySQL in the XAMPP Control Panel, then create the database with:

  mysql -u root -e "CREATE DATABASE nsangii_primary CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

If the MySQL account has a password, add `-p` to the command. Update `DB_USERNAME` and `DB_PASSWORD` in `.env` to match the MySQL account.

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