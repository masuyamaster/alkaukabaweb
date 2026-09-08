<!DOCTYPE html>
<html class="dark scroll-smooth" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Hapus Akun - Al-Kaukaba</title>
<link href="{{ asset('images/logo-hitam.svg') }}" media="(prefers-color-scheme: light)" rel="icon" type="image/svg+xml"/>
<link href="{{ asset('images/logo-putih.svg') }}" media="(prefers-color-scheme: dark)" rel="icon" type="image/svg+xml"/>
<link href="{{ asset('images/logo-putih.svg') }}" rel="icon" type="image/svg+xml"/>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com" rel="preconnect"/>
<link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&amp;family=Manrope:wght@600;700&amp;family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script id="tailwind-config">
        tailwind.config = {
          darkMode: "class",
          theme: {
            extend: {
              "colors": {
                      "surface": "#16130b",
                      "surface-container-lowest": "#110e07",
                      "surface-container-high": "#2d2a21",
                      "on-surface": "#eae1d4",
                      "on-surface-variant": "#d0c5af",
                      "primary": "#f2ca50",
                      "primary-container": "#d4af37",
                      "on-primary": "#3c2f00",
                      "starlight-white": "#FDFDFC",
                      "deep-obsidian": "#0A0A09"
              },
              "fontFamily": {
                      "body-md": ["Inter"],
                      "headline-lg": ["Manrope"]
              }
      },
          },
        }
      </script>
</head>
<body class="bg-deep-obsidian text-on-surface font-body-md antialiased">
<header class="w-full bg-surface border-b border-starlight-white/10">
<div class="flex items-center px-6 md:px-16 py-4 max-w-3xl mx-auto">
<img alt="Al-Kaukaba Logo" class="h-10 w-auto object-contain" src="{{ asset('images/logo-putih.svg') }}"/>
</div>
</header>
<main class="max-w-3xl mx-auto px-6 md:px-16 py-16 space-y-8">
<h1 class="font-headline-lg text-3xl text-starlight-white">Hapus Akun Al-Kaukaba</h1>
<p class="text-on-surface-variant leading-relaxed">
Anda dapat menghapus akun Al-Kaukaba beserta data pribadi yang terkait kapan
saja langsung dari aplikasi Android Al-Kaukaba, tanpa perlu menghubungi kami
lebih dulu.
</p>

<section class="space-y-4">
<h2 class="font-headline-lg text-xl text-primary">Cara menghapus akun</h2>
<ol class="list-decimal list-inside space-y-2 text-on-surface-variant leading-relaxed">
<li>Buka aplikasi <strong class="text-on-surface">Al-Kaukaba</strong> dan masuk (login) ke akun Anda.</li>
<li>Buka menu <strong class="text-on-surface">Profil</strong>.</li>
<li>Pilih <strong class="text-on-surface">Hapus Akun</strong>.</li>
<li>Masukkan password Anda untuk konfirmasi, lalu selesaikan proses penghapusan.</li>
</ol>
</section>

<section class="space-y-4">
<h2 class="font-headline-lg text-xl text-primary">Data yang dihapus</h2>
<p class="text-on-surface-variant leading-relaxed">
Setelah proses hapus akun selesai, data akun berikut akan dihapus secara
permanen dari server Al-Kaukaba:
</p>
<ul class="list-disc list-inside space-y-2 text-on-surface-variant leading-relaxed">
<li>Nama pengguna (username) dan alamat email.</li>
<li>Password (tersimpan dalam bentuk terenkripsi).</li>
<li>Foto profil, jika pernah diunggah.</li>
</ul>
<p class="text-on-surface-variant leading-relaxed">
Data lokasi yang dipakai untuk menghitung waktu sholat, arah kiblat, dan
kalender Hijriyah tidak disimpan di server kami — data itu hanya diteruskan
sementara ke penyedia data astronomi pihak ketiga saat aplikasi digunakan,
dan tidak terkait dengan akun Anda.
</p>
</section>

<section class="space-y-4">
<h2 class="font-headline-lg text-xl text-primary">Butuh bantuan?</h2>
<p class="text-on-surface-variant leading-relaxed">
Jika Anda mengalami kendala saat menghapus akun lewat aplikasi, hubungi kami
melalui email <a class="text-primary hover:underline" href="mailto:info@alkaukaba.com">info@alkaukaba.com</a>.
</p>
</section>
</main>
<footer class="w-full bg-surface-container-lowest border-t border-starlight-white/5">
<div class="max-w-3xl mx-auto px-6 md:px-16 py-8 text-center">
<p class="text-on-surface-variant text-sm">© {{ date('Y') }} Al-Kaukaba Study Circle.</p>
</div>
</footer>
</body></html>
