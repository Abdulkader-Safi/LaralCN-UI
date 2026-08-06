#!/usr/bin/env bash
#
# Production deploy for laralcn-ui.abdulkadersafi.com
#
# Run as the deploy user from the project root on the VPS:
#   bash deploy.sh
#
# Assumptions (see DEPLOYMENT.md):
#   - PHP 8.4 is installed as `php8.4` (the default `php` is 8.3 for another site)
#   - php-fpm runs as www-data:www-data
#   - compiled assets (public/build) are committed — the VPS does NOT build them
#   - .env uses SESSION_DRIVER=file and CACHE_STORE=file (no database needed:
#     the registry is fetched over HTTPS, sessions/cache live in storage/)
#
set -euo pipefail

cd "$(dirname "$0")"

PHP=php8.4
COMPOSER="$(command -v composer)"

echo "==> git pull"
git pull origin main

echo "==> composer install (no-dev)"
"$PHP" "$COMPOSER" install --no-dev --optimize-autoloader

echo "==> rebuild caches"
"$PHP" artisan optimize:clear
"$PHP" artisan config:cache
"$PHP" artisan route:cache
"$PHP" artisan view:cache

echo "==> fix ownership for php-fpm (www-data)"
# Only the directories php-fpm WRITES to. public/build is deliberately absent:
# it is served read-only, it arrives via git, and handing it to www-data makes
# the next `git pull` fail with "unable to unlink old public/build/manifest.json".
sudo chown -R www-data:www-data storage bootstrap/cache

echo "==> done — reload https://laralcn-ui.abdulkadersafi.com"
