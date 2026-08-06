# Deploying the website (laralcn-ui.abdulkadersafi.com)

The `website/` Laravel app is deployed as a **full-repo git clone** on the VPS
at `/var/www/LaralCN-UI`, served from `website/public` by Caddy → php-fpm 8.4.

## One-time server setup

The VPS runs another site on **PHP 8.3**, so PHP 8.4 is installed _alongside_
it — never replace the default `php`.

```bash
# PHP 8.4 next to 8.3 (does not change the default `php`)
sudo add-apt-repository ppa:ondrej/php -y && sudo apt update
sudo apt install -y php8.4-fpm php8.4-cli php8.4-mbstring php8.4-xml \
  php8.4-curl php8.4-zip php8.4-bcmath php8.4-intl
```

Caddyfile (php-fpm 8.4 socket; other site keeps its own 8.3 socket):

```
laralcn-ui.abdulkadersafi.com {
    root * /var/www/LaralCN-UI/website/public
    encode gzip zstd
    php_fastcgi unix//run/php/php8.4-fpm.sock
    file_server
}
www.laralcn-ui.abdulkadersafi.com {
    redir https://laralcn-ui.abdulkadersafi.com{uri} permanent
}
```

`.env` (copy from `.env.example`, then set):

```
APP_ENV=production
APP_DEBUG=false
APP_URL=https://laralcn-ui.abdulkadersafi.com
APP_KEY=base64:...        # php8.4 artisan key:generate
SESSION_DRIVER=file
CACHE_STORE=file
DB_CONNECTION=sqlite      # present but never opened (see below)
# LARALCN_UI_REGISTRY_URL  — leave unset; the default raw-GitHub URL is correct
```

Initial ownership. The split matters: the deploy user owns the checkout so
`git pull` can rewrite any tracked file, and php-fpm owns only the two
directories it actually writes to.

```bash
sudo chown -R safi:safi /var/www/LaralCN-UI          # whole checkout, for git

cd /var/www/LaralCN-UI/website
sudo chown -R www-data:www-data storage bootstrap/cache
sudo find storage bootstrap/cache -type d -exec chmod 775 {} \;
```

`public/build` is **not** in that second command on purpose. php-fpm serves it
read-only and never writes to it, and giving it to `www-data` breaks the next
deploy with `error: unable to unlink old 'website/public/build/manifest.json':
Permission denied`, followed by a `git pull` that refuses to fast-forward.

## Every deploy

```bash
cd /var/www/LaralCN-UI/website
bash deploy.sh
```

`deploy.sh` does: `git pull` → `php8.4 composer install --no-dev` →
`optimize:clear` + re-cache config/routes/views → re-chown to www-data.

## Why there is no database on the server

- **Registry** is fetched over HTTPS from the published raw-GitHub registry
  (`App\Support\Registry` remote mode, cached 10 min). No local `registry/`
  dependency at runtime.
- **Sessions + cache** use the `file` driver (`storage/framework/`), so the
  app makes **zero DB queries**. `database/database.sqlite` is never created
  or opened; `php artisan migrate` is intentionally **not** in `deploy.sh`.
- **Assets** (`website/public/build/`) are **committed to the repo** and must
  stay tracked: do not add them to `.gitignore`. Assets are built locally and
  ship via `git`; never run `npm run build` on the server, since Vite empties
  `public/build` first and would delete the deployed files. After changing
  CSS/JS:

  ```bash
  cd website && npm run build
  git add public/build && git commit -m "rebuild assets" && git push
  ```

- **Node is optional on the server** and affects exactly one thing: Shiki
  syntax highlighting in `<x-code-block>`. Without a `node` binary on
  **php-fpm's** PATH, code blocks render plain instead of highlighted; pages
  still work. An nvm install does not count, because php-fpm does not read
  your shell profile. To turn highlighting on, expose node somewhere Shiki
  looks (it searches PATH plus `/usr/local/bin` and `/opt/homebrew/bin`):

  ```bash
  sudo ln -sf "$(which node)" /usr/local/bin/node
  cd website && php8.4 artisan cache:clear   # drop the un-highlighted cache
  ```

## Package

`website/composer.json` requires `safi/laralcn-ui ^0.2.0` from **Packagist**
(no path repository). Bump the package tag and `composer update safi/laralcn-ui`
to surface CLI/package changes in the showcase.

Release order matters: `website/composer.lock` is committed and the server runs
`composer install --no-dev`, so raise the constraint **only after** the new tag
is live on Packagist, and commit `composer.json` and `composer.lock` together.
Raising it first leaves the lock stale and the deploy install fails.

## Troubleshooting

| Symptom                                     | Cause                              | Fix                                                                                |
| ------------------------------------------- | ---------------------------------- | ---------------------------------------------------------------------------------- |
| `Composer detected ... requires PHP >= 8.4` | ran under default 8.3              | use `php8.4` for every artisan/composer call                                       |
| `Registry not found at https://...`         | old code or misspelled URL         | ensure latest `main`; default URL is `Abdulkader-Safi` (hyphen)                    |
| `attempt to write a readonly database`      | `.env` still on `database` drivers | set `SESSION_DRIVER=file` + `CACHE_STORE=file`, then `php8.4 artisan config:cache` |
| `Vite manifest not found`                   | `public/build/` missing            | it's committed — `git pull`; rebuild+commit locally if stale                       |
| `unable to unlink old public/build/manifest.json` | `public/build` owned by www-data | `sudo chown -R safi:safi /var/www/LaralCN-UI`, then re-run `deploy.sh`        |
| `EACCES ... public/build/assets` from vite  | ran `npm run build` on the server  | don't; assets are built locally and committed. The error saved you: vite empties that directory first |
| `storage/logs/laravel.log ... Permission denied` | ran composer as the deploy user after a www-data chown | expected; `deploy.sh` re-chowns at the end. Run `deploy.sh`, not bare `composer i` |
| 500 after moving/clone                      | stale cached paths                 | `php8.4 artisan optimize:clear` then re-cache                                      |
| `Permission denied` writing storage/db      | dirs owned by www-data             | run writes as www-data, or `sudo chown` per above                                  |

Config check: `php8.4 artisan tinker --execute="echo config('session.driver').' / '.config('cache.default');"` → expect `file / file`.
