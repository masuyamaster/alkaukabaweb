# alkaukabaweb — Backend & Landing Page Al-Kaukaba

Laravel 12. Situs "Al-Kaukaba" (Ilmu Hisab Rukyat Lamongan) — landing page + backend API auth untuk app Android `alkaukabaandroid`.

## Infrastruktur produksi

- **VPS**: `root@202.155.17.2` (SSH config lokal: host alias `server-al-kaukaba`), project di `/var/www/alkaukaba`.
- **Domain**: `alkaukaba.com` (landing page + API) dan `api.alkaukaba.com` (subdomain khusus API, root sama). SSL via Certbot, config di `/etc/nginx/sites-available/alkaukaba`.
- **PHP-FPM**: `php8.2-fpm` (socket `/run/php/php8.2-fpm.sock`).
- **Database produksi**: MySQL, nama database **`laravel_api`** (BUKAN `alkaukaba` — jangan asumsikan nama DB sama dengan nama app tanpa cek `.env` dulu).
- **Deploy workflow**: manual. Claude Code & VS Code Server sengaja **dilepas** dari VPS ini (buat hemat RAM) — dev/tulis kode di lokal, push ke `main`, lalu `git pull` manual di server via SSH langsung (bukan via Claude Code yang jalan di server). Tidak ada CI/CD.
- Kalau butuh generate ulang runbook deploy (backup DB, migrate, cache, dst), lihat riwayat percakapan Claude Code lokal — polanya: backup dulu (`mysqldump --no-tablespaces ...` karena user app biasanya nggak punya PROCESS privilege), `git pull`, `composer install --no-dev --optimize-autoloader`, `migrate --force`, `config:cache`/`route:cache`/`view:cache`, baru test endpoint.

## ⚠️ Gotcha nginx: route yang berakhiran `.php`

`AuthController` di-mount di `routes/web.php` sebagai `Route::post('/api.php', ...)` — sengaja pakai path literal `.php` untuk mirror kontrak lama `alkaukabaauth/api.php?action=...` yang dipanggil app Android.

**Masalahnya**: config nginx standar Laravel (termasuk yang direkomendasikan resmi di docs Laravel) punya block:
```
location ~ \.php$ {
    fastcgi_pass unix:/run/php/php8.2-fpm.sock;
    fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
    include fastcgi_params;
}
```
Regex location ini match duluan untuk URL apa pun yang **terlihat** berakhiran `.php` — termasuk `/api.php` — dan langsung fastcgi_pass ke file itu SEBAGAI FILE FISIK, bypass `location /` (yang punya `try_files ... /index.php?$query_string`). Karena `public/api.php` tidak pernah ada sebagai file nyata (itu cuma route virtual Laravel), PHP-FPM balas literal `File not found.` — bukan 404 Laravel, bukan error Laravel sama sekali, jadi gampang salah diagnosis dikira bug di kode.

**Fix yang sudah diterapkan** (di kedua server block, `alkaukaba.com` & `api.alkaukaba.com`): tambah `try_files` di dalam block PHP itu juga, supaya fallback ke `index.php` kalau file-nya nggak ada:
```
location ~ \.php$ {
    try_files $uri /index.php?$query_string;
    fastcgi_pass unix:/run/php/php8.2-fpm.sock;
    fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
    include fastcgi_params;
}
```

**Implikasi ke depan**: kalau nanti nambah route baru yang juga sengaja berakhiran `.php` (demi kompatibilitas legacy), route itu OTOMATIS akan kena masalah yang sama di server ini kecuali fix di atas tetap ada di nginx config. Config nginx TIDAK ikut ter-track di git repo ini (dia hidup di `/etc/nginx/` di VPS, di luar `/var/www/alkaukaba`), jadi kalau server di-rebuild/pindah, fix ini gampang ketinggalan — perlu direplikasi manual.

## Auth API (mirror kontrak legacy)

Single entry point: `POST /api.php?action=register|login|google_login` (lihat `app/Http/Controllers/AuthController.php`). Tidak domain-scoped (beda dari route landing page yang dikunci `Route::domain(config('app.route_domain'))`), supaya app Android bisa hit lewat IP/host apa pun saat testing lokal maupun dari kedua domain produksi di atas.

- `google_login` butuh `GOOGLE_CLIENT_ID` di `.env` — harus **OAuth 2.0 Client ID bertipe "Web application"** dari Google Cloud Console project `al-kaukaba` (https://console.cloud.google.com/apis/credentials?project=al-kaukaba), BUKAN client ID tipe Android. `verifyIdToken()` mencocokkan audience token terhadap ID ini; Client ID yang dipakai harus sama persis dengan yang dipanggil app Android di `requestIdToken(...)`.

## Catatan skema DB

- Tabel `sessions` (dipakai karena `SESSION_DRIVER=database`) **sudah ada di database produksi**, tapi migration file-nya **hilang dari repo** (kemungkinan dibuat manual sebelum VS Code Server dibersihkan dari VPS, lalu file-nya kehapus tanpa rollback). Akibatnya: `php artisan session:table` akan gagal dengan "Migration already exists" (dia cek keberadaan TABEL, bukan file), padahal filenya nggak kelihatan di `database/migrations/` maupun di `migrate:status`. Kalau butuh cek tabel ini beneran ada atau nggak, pakai `php artisan db:table sessions`, jangan percaya cuma dari `migrate:status`/listing file.
