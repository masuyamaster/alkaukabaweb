<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

# alkaukabaweb

Backend & landing page Al-Kaukaba (Ilmu Hisab Rukyat Lamongan) — Laravel 12. Detail infrastruktur produksi & gotcha deployment ada di [CLAUDE.md](CLAUDE.md).

## Konvensi kode

Konvensi ini berlaku untuk semua kode baru di project ini, bukan cuma yang sudah ada.

### Controller & validasi

- Jangan validasi input manual pakai `empty()`/`if` berantai. Pakai `Illuminate\Support\Facades\Validator::make()` (controller ini bukan resource controller standar, jadi FormRequest class terpisah dianggap overkill untuk 3 endpoint kecil — cukup `Validator::make()` inline).
- Endpoint yang **mem-mirror kontrak API legacy** (lihat `AuthController`) harus mempertahankan bentuk response persis seperti sebelumnya (`status`/`message`/`data`, kode HTTP yang sama) — jangan pakai `$request->validate()` langsung karena itu melempar `ValidationException` yang di-render Laravel dengan bentuk berbeda (422 + `errors` object) dan akan memutus kontrak yang dipakai app Android.
- Untuk route baru yang **bukan** mirror kontrak legacy (mis. `CircleMemberController`), `$request->validate()` biasa tetap jadi pilihan default karena lebih ringkas dan bentuk error Laravel standar tidak masalah di situ.

### Response JSON

- Jangan pernah mengembalikan pesan exception mentah (`$e->getMessage()`) ke client di response API publik — itu bisa membocorkan detail internal. Log detailnya lewat `Log::error()`/`Log::warning()` dengan context yang cukup untuk debugging, lalu balas client dengan pesan generik.
- Kalau ada bentuk data yang dipakai berulang di beberapa response (mis. `id`/`username`/`email` milik `User`), ekstrak jadi method private kecil (contoh: `userResponse(User $user): array` di `AuthController`) daripada mengulang array literal yang sama di banyak tempat.

### Gaya kode

- Sebelum commit, jalankan `vendor/bin/pint` (Laravel Pint, sudah ada di `require-dev`) untuk auto-format sesuai style resmi Laravel (import order, spacing, dll).
- Jalankan `php artisan test` sebelum commit kalau ada test yang relevan; untuk endpoint yang mengubah `AuthController`/`CircleMemberController`, tes manual (curl/Postman) ke endpoint yang bersangkutan karena test suite saat ini masih skeleton (`tests/*/ExampleTest.php`) dan belum meng-cover kontroler-kontroler tersebut.
