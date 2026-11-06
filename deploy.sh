#!/usr/bin/env bash
# Deploy / update script for the CloudPanel server.
# Run it as the site user (e.g. mav-hdsh) from the project folder:
#     bash deploy.sh
set -euo pipefail

cd "$(dirname "$0")"

if [ ! -f .env ]; then
    echo "ERROR: .env not found. Run: cp .env.example .env  and fill in APP_URL + MAIL_PASSWORD first." >&2
    exit 1
fi

echo "==> Pulling latest code from GitHub"
git pull --ff-only

echo "==> Installing PHP dependencies"
composer install --no-dev --optimize-autoloader --no-interaction

if grep -qE '^APP_KEY=\s*$' .env; then
    echo "==> Generating APP_KEY"
    php artisan key:generate --force
fi

if grep -qE '^DB_CONNECTION=sqlite' .env && [ ! -f database/database.sqlite ]; then
    echo "==> Creating SQLite database file"
    touch database/database.sqlite
fi

echo "==> Running migrations"
php artisan migrate --force

echo "==> Caching config, routes and views"
php artisan optimize

php artisan storage:link 2>/dev/null || true
php artisan queue:restart 

echo "Done. Open $(grep -E '^APP_URL=' .env | cut -d= -f2-)"
