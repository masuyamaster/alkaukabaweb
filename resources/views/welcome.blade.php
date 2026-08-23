<!DOCTYPE html>
<html class="dark scroll-smooth" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Al-Kaukaba - Ilmu Hisab Rukyat Lamongan</title>
<link href="{{ asset('images/logo-hitam.svg') }}" media="(prefers-color-scheme: light)" rel="icon" type="image/svg+xml"/>
<link href="{{ asset('images/logo-putih.svg') }}" media="(prefers-color-scheme: dark)" rel="icon" type="image/svg+xml"/>
<link href="{{ asset('images/logo-putih.svg') }}" rel="icon" type="image/svg+xml"/>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<script src="https://cdn.jsdelivr.net/npm/suncalc@1.9.0/suncalc.js"></script>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com" rel="preconnect"/>
<link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&amp;family=JetBrains+Mono:wght@500&amp;family=Manrope:wght@600;700&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script id="tailwind-config">
        tailwind.config = {
          darkMode: "class",
          theme: {
            extend: {
              "colors": {
                      "primary-fixed": "#ffe088",
                      "surface-container": "#231f17",
                      "surface-variant": "#38342b",
                      "inverse-surface": "#eae1d4",
                      "on-tertiary-fixed": "#00174b",
                      "surface": "#16130b",
                      "on-primary": "#3c2f00",
                      "tertiary-fixed-dim": "#b4c5ff",
                      "error": "#ffb4ab",
                      "primary": "#f2ca50",
                      "surface-container-high": "#2d2a21",
                      "inverse-primary": "#735c00",
                      "secondary-container": "#474743",
                      "secondary-fixed-dim": "#c9c6c1",
                      "tertiary": "#bfcdff",
                      "on-primary-fixed-variant": "#574500",
                      "surface-dim": "#16130b",
                      "surface-container-lowest": "#110e07",
                      "lunar-gray": "#706F6C",
                      "starlight-white": "#FDFDFC",
                      "on-tertiary-container": "#254188",
                      "background": "#16130b",
                      "secondary": "#c9c6c1",
                      "on-error-container": "#ffdad6",
                      "primary-container": "#d4af37",
                      "outline": "#99907c",
                      "calculation-red": "#F53003",
                      "on-secondary-fixed-variant": "#474743",
                      "on-error": "#690005",
                      "surface-container-low": "#1f1b13",
                      "on-secondary": "#31302d",
                      "surface-tint": "#e9c349",
                      "on-tertiary": "#082b72",
                      "inverse-on-surface": "#343027",
                      "on-secondary-container": "#b7b5b0",
                      "on-primary-container": "#554300",
                      "primary-fixed-dim": "#e9c349",
                      "outline-variant": "#4d4635",
                      "surface-bright": "#3d392f",
                      "deep-obsidian": "#0A0A09",
                      "on-surface": "#eae1d4",
                      "secondary-fixed": "#e5e2dd",
                      "on-secondary-fixed": "#1c1c19",
                      "on-tertiary-fixed-variant": "#27438a",
                      "error-container": "#93000a",
                      "tertiary-container": "#97b0ff",
                      "surface-container-highest": "#38342b",
                      "on-surface-variant": "#d0c5af",
                      "on-background": "#eae1d4",
                      "on-primary-fixed": "#241a00",
                      "tertiary-fixed": "#dbe1ff"
              },
              "borderRadius": {
                      "DEFAULT": "0.125rem",
                      "lg": "0.25rem",
                      "xl": "0.5rem",
                      "full": "0.75rem"
              },
              "spacing": {
                      "margin-desktop": "64px",
                      "gutter": "24px",
                      "unit": "8px",
                      "container-max": "1200px",
                      "margin-mobile": "16px"
              },
              "fontFamily": {
                      "body-md": [
                              "Inter"
                      ],
                      "headline-lg-mobile": [
                              "Manrope"
                      ],
                      "headline-lg": [
                              "Manrope"
                      ],
                      "display-lg": [
                              "Manrope"
                      ],
                      "data-mono": [
                              "JetBrains Mono"
                      ],
                      "label-caps": [
                              "Inter"
                      ]
              },
              "fontSize": {
                      "body-md": [
                              "16px",
                              {
                                      "lineHeight": "24px",
                                      "fontWeight": "400"
                              }
                      ],
                      "headline-lg-mobile": [
                              "24px",
                              {
                                      "lineHeight": "32px",
                                      "fontWeight": "600"
                              }
                      ],
                      "headline-lg": [
                              "32px",
                              {
                                      "lineHeight": "40px",
                                      "fontWeight": "600"
                              }
                      ],
                      "display-lg": [
                              "48px",
                              {
                                      "lineHeight": "56px",
                                      "letterSpacing": "-0.02em",
                                      "fontWeight": "700"
                              }
                      ],
                      "data-mono": [
                              "14px",
                              {
                                      "lineHeight": "20px",
                                      "letterSpacing": "0.05em",
                                      "fontWeight": "500"
                              }
                      ],
                      "label-caps": [
                              "12px",
                              {
                                      "lineHeight": "16px",
                                      "letterSpacing": "0.1em",
                                      "fontWeight": "700"
                              }
                      ]
              }
      },
          },
        }
      </script>
<style>
        /* Custom Utilities for Scholarly Minimalism */
        .glass-panel {
            background: rgba(27, 27, 24, 0.4);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(253, 253, 252, 0.1);
        }

        .gold-glow:hover {
            box-shadow: 0 0 15px rgba(212, 175, 55, 0.2);
        }

        .data-card-border {
            border-top: 1px solid #d4af37;
        }

        /* Hero Animation Background */
        .starfield {
            background-image:
                radial-gradient(1px 1px at 10% 10%, #FDFDFC 100%, transparent),
                radial-gradient(1px 1px at 20% 50%, #FDFDFC 100%, transparent),
                radial-gradient(2px 2px at 30% 80%, #FDFDFC 100%, transparent),
                radial-gradient(1px 1px at 40% 20%, #FDFDFC 100%, transparent),
                radial-gradient(1px 1px at 60% 60%, #FDFDFC 100%, transparent),
                radial-gradient(2px 2px at 80% 30%, #FDFDFC 100%, transparent),
                radial-gradient(1px 1px at 90% 90%, #FDFDFC 100%, transparent);
            background-size: 200px 200px;
            animation: twinkle 5s infinite linear;
            opacity: 0.3;
        }

        @keyframes twinkle {
            0% { opacity: 0.2; transform: translateY(0); }
            50% { opacity: 0.4; }
            100% { opacity: 0.2; transform: translateY(-10px); }
        }
      </style>
</head>
<body class="bg-deep-obsidian text-on-surface font-body-md antialiased selection:bg-primary-container selection:text-on-primary-container">
<!-- TopNavBar -->
<header class="w-full top-0 sticky z-50 bg-surface dark:bg-surface border-b border-starlight-white/10 transition-all duration-300" id="navbar">
<div class="flex justify-between items-center px-margin-mobile md:px-margin-desktop py-unit w-full max-w-container-max mx-auto">
<!-- Brand -->
<div class="flex items-center gap-4">
<img alt="Al-Kaukaba Logo" class="h-10 md:h-12 w-auto object-contain" src="{{ asset('images/logo-putih.svg') }}"/>
</div>
<!-- Desktop Nav -->
<nav class="hidden md:flex items-center gap-8">
<a class="font-label-caps text-label-caps text-primary border-b-2 border-primary pb-1 relative after:content-[''] after:absolute after:-bottom-[3px] after:left-1/2 after:-translate-x-1/2 after:w-1 after:h-1 after:bg-primary after:rounded-full" href="#">Home</a>
<a class="font-label-caps text-label-caps text-on-surface-variant hover:text-primary transition-colors duration-150" href="#ilmu-hisab">Ilmu Hisab</a>
<a class="font-label-caps text-label-caps text-on-surface-variant hover:text-primary transition-colors duration-150" href="#rukyat">Rukyat</a>
<a class="font-label-caps text-label-caps text-on-surface-variant hover:text-primary transition-colors duration-150" href="#workshops">Workshops</a>
<a class="font-label-caps text-label-caps text-on-surface-variant hover:text-primary transition-colors duration-150" href="#resources">Resources</a>
</nav>
<!-- Actions -->
<div class="flex items-center gap-4">
<button class="hidden md:flex bg-primary-container text-on-primary px-6 py-2 rounded font-label-caps text-label-caps uppercase tracking-widest hover:bg-primary-fixed transition-colors duration-150" onclick="document.getElementById('join-circle-modal').classList.remove('hidden')" type="button">
                    Join Circle
                </button>
<button class="md:hidden text-on-surface" id="mobile-menu-btn">
<span class="material-symbols-outlined text-2xl">menu</span>
</button>
</div>
</div>
<!-- Mobile Menu (Hidden by default) -->
<div class="md:hidden hidden absolute top-full left-0 w-full bg-surface-container-high border-b border-starlight-white/10" id="mobile-menu">
<div class="flex flex-col px-margin-mobile py-4 gap-4">
<a class="font-label-caps text-label-caps text-primary border-l-2 border-primary pl-4 py-2" href="#">Home</a>
<a class="font-label-caps text-label-caps text-on-surface-variant hover:text-primary pl-4 py-2" href="#ilmu-hisab">Ilmu Hisab</a>
<a class="font-label-caps text-label-caps text-on-surface-variant hover:text-primary pl-4 py-2" href="#rukyat">Rukyat</a>
<a class="font-label-caps text-label-caps text-on-surface-variant hover:text-primary pl-4 py-2" href="#workshops">Workshops</a>
<a class="font-label-caps text-label-caps text-on-surface-variant hover:text-primary pl-4 py-2" href="#resources">Resources</a>
<button class="w-full mt-4 bg-primary-container text-on-primary px-6 py-3 rounded font-label-caps text-label-caps uppercase tracking-widest" onclick="document.getElementById('join-circle-modal').classList.remove('hidden')" type="button">
                    Join Circle
                </button>
</div>
</div>
</header>
<!-- Hero Section -->
<section class="relative min-h-[90vh] flex flex-col justify-center overflow-hidden w-full px-margin-mobile md:px-margin-desktop">
<!-- Celestial Background -->
<div class="absolute inset-0 z-0 bg-surface">
<div class="absolute inset-0 bg-gradient-to-b from-[#0A0A09] via-[#110e07] to-[#16130b]"></div>
<div class="absolute inset-0 starfield"></div>
<!-- Crescent Moon Abstract Graphic -->
<div class="absolute top-1/4 right-1/4 w-96 h-96 rounded-full border border-primary/20 bg-gradient-to-tr from-transparent to-primary/5 blur-3xl"></div>
</div>
<div class="relative z-10 max-w-container-max mx-auto w-full grid grid-cols-1 lg:grid-cols-12 gap-gutter items-center py-20">
<div class="lg:col-span-8 space-y-8">
<div class="inline-flex items-center gap-2 px-3 py-1 rounded-full border border-primary/30 bg-primary/5 text-primary text-label-caps font-label-caps uppercase tracking-widest mb-4">
<span class="material-symbols-outlined text-[14px]">auto_awesome</span>
                    Observatory Digital
                </div>
<h1 class="font-display-lg text-display-lg text-starlight-white max-w-4xl">
                    Menyibak Rahasia Langit dengan Presisi <span class="text-primary">Hisab</span> dan Kejelasan <span class="text-primary">Rukyat</span>.
                </h1>
<p class="font-body-md text-body-md text-on-surface-variant max-w-2xl text-lg leading-relaxed">
                    Lingkaran Studi Ilmu Hisab Rukyat Lamongan — Pusat edukasi dan observasi astronomi Islam terpercaya. Menggabungkan kearifan falak klasik dengan ketepatan komputasi modern.
                </p>
<div class="flex flex-wrap gap-4 pt-4">
<button class="bg-primary-container text-on-primary px-8 py-3 rounded font-label-caps text-label-caps uppercase tracking-widest hover:bg-primary-fixed transition-colors duration-150 flex items-center gap-2">
                        Gabung Sekarang
                        <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
</button>
<button class="border border-primary text-primary px-8 py-3 rounded font-label-caps text-label-caps uppercase tracking-widest hover:bg-primary/10 transition-colors duration-150 flex items-center gap-2">
                        Pelajari Lebih Lanjut
                    </button>
</div>
</div>
<!-- Hero Data Widget -->
<div class="lg:col-span-4 mt-12 lg:mt-0">
<div class="glass-panel p-6 rounded-lg relative overflow-hidden group hover:border-primary/50 transition-colors duration-300">
<div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
<span class="material-symbols-outlined text-6xl text-primary">public</span>
</div>
<h3 class="font-label-caps text-label-caps text-on-surface-variant uppercase tracking-widest mb-6 border-b border-starlight-white/10 pb-2">Data Observasi Terkini</h3>
<div class="space-y-4">
<div class="flex justify-between items-end border-b border-starlight-white/5 pb-2">
<span class="font-body-md text-sm text-on-surface-variant">Fase Bulan</span>
<span class="font-data-mono text-data-mono text-starlight-white" id="moon-phase">Memuat...</span>
</div>
<div class="flex justify-between items-end border-b border-starlight-white/5 pb-2">
<span class="font-body-md text-sm text-on-surface-variant">Iluminasi</span>
<span class="font-data-mono text-data-mono text-primary" id="moon-illumination">Memuat...</span>
</div>
<div class="flex justify-between items-end border-b border-starlight-white/5 pb-2">
<span class="font-body-md text-sm text-on-surface-variant">Ketinggian Bulan Saat Ini</span>
<span class="font-data-mono text-data-mono text-starlight-white" id="moon-altitude">Memuat...</span>
</div>
<div class="flex justify-between items-end">
<span class="font-body-md text-sm text-on-surface-variant">Lokasi</span>
<span class="font-data-mono text-data-mono text-starlight-white">Lamongan, Indonesia</span>
</div>
<p class="font-data-mono text-[10px] text-on-surface-variant/70 mt-4" id="moon-updated">Memperbarui...</p>
</div>
</div>
</div>
</div>
</section>
<!-- Ilmu Hisab Section -->
<section class="w-full py-24 px-margin-mobile md:px-margin-desktop bg-surface-container-lowest" id="ilmu-hisab">
<div class="max-w-container-max mx-auto">
<div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
<!-- Data Visual -->
<div class="order-2 md:order-1 glass-panel p-8 rounded-lg data-card-border relative h-full min-h-[400px] flex flex-col justify-center">
<div class="absolute top-4 left-4 text-primary opacity-50">
<span class="material-symbols-outlined">calculate</span>
</div>
<div class="space-y-6 mt-8">
<div class="flex items-center gap-4 border-b border-starlight-white/10 pb-4">
<div class="w-12 h-12 rounded bg-surface flex items-center justify-center text-primary font-data-mono">Ep</div>
<div>
<p class="font-label-caps text-[10px] text-on-surface-variant uppercase tracking-widest">Epoch</p>
<p class="font-data-mono text-data-mono text-starlight-white">J2000.0</p>
</div>
</div>
<div class="flex items-center gap-4 border-b border-starlight-white/10 pb-4">
<div class="w-12 h-12 rounded bg-surface flex items-center justify-center text-primary font-data-mono">λ</div>
<div>
<p class="font-label-caps text-[10px] text-on-surface-variant uppercase tracking-widest">Bujur Ekliptika</p>
<p class="font-data-mono text-data-mono text-starlight-white">214.352°</p>
</div>
</div>
<div class="flex items-center gap-4">
<div class="w-12 h-12 rounded bg-surface flex items-center justify-center text-primary font-data-mono">ΔT</div>
<div>
<p class="font-label-caps text-[10px] text-on-surface-variant uppercase tracking-widest">Delta T</p>
<p class="font-data-mono text-data-mono text-starlight-white">69.2s</p>
</div>
</div>
</div>
</div>
<!-- Content -->
<div class="order-1 md:order-2 space-y-6">
<h2 class="font-headline-lg text-headline-lg md:font-display-lg md:text-display-lg text-starlight-white">
                        Presisi <span class="text-primary">Ilmu Hisab</span>
</h2>
<p class="font-body-md text-body-md text-on-surface-variant leading-relaxed">
                        Kami mengkaji dan mengembangkan metode komputasi astronomi untuk penentuan awal bulan Hijriyah, jadwal shalat, dan arah kiblat. Menggunakan algoritma kontemporer yang diuji secara empiris untuk memastikan akurasi matematis tertinggi dalam kalender Islam.
                    </p>
<ul class="space-y-4 pt-4">
<li class="flex items-start gap-3">
<span class="material-symbols-outlined text-primary mt-1 text-[20px]">check_circle</span>
<span class="font-body-md text-on-surface">Algoritma Ephemeris presisi tinggi.</span>
</li>
<li class="flex items-start gap-3">
<span class="material-symbols-outlined text-primary mt-1 text-[20px]">check_circle</span>
<span class="font-body-md text-on-surface">Validasi kriteria MABIMS terkini.</span>
</li>
<li class="flex items-start gap-3">
<span class="material-symbols-outlined text-primary mt-1 text-[20px]">check_circle</span>
<span class="font-body-md text-on-surface">Analisis elongasi dan ketinggian bulan.</span>
</li>
</ul>
</div>
</div>
</div>
</section>
<!-- Observasi Rukyat Section -->
<section class="w-full py-24 px-margin-mobile md:px-margin-desktop bg-surface" id="rukyat">
<div class="max-w-container-max mx-auto">
<div class="text-center mb-16 max-w-3xl mx-auto space-y-4">
<span class="font-label-caps text-label-caps text-primary uppercase tracking-widest">Observasi Lapangan</span>
<h2 class="font-headline-lg text-headline-lg md:font-display-lg md:text-display-lg text-starlight-white">
                    Kejelasan <span class="text-primary">Rukyatul Hilal</span>
</h2>
<p class="font-body-md text-body-md text-on-surface-variant">
                    Menggabungkan tradisi pengamatan langsung dengan teknologi optik modern. Tim kami secara rutin melakukan observasi hilal di titik-titik strategis untuk memverifikasi data hisab.
                </p>
</div>
<!-- Bento Grid -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
<!-- Large Card -->
<div class="md:col-span-2 glass-panel rounded-lg overflow-hidden relative group min-h-[300px]">
<div class="absolute inset-0 bg-cover bg-center opacity-40 mix-blend-luminosity group-hover:opacity-60 transition-opacity duration-500" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuBdC5ife7Ey4gIdqsK--2W1pSRRrQSHdF1zRlDXpYqzlOz4OnkKXUf8POWuTPSP15O6Rxj0cS7JqmSWMwFVsPwMilJy-of70oC1zQuXJ8OodIp9mLzRWSwbLkTHnta7QWhncn7hj0WO6CizljSA0-0rEJaOXy-iDfWgIk7Ps5nxSiGax1iUEtNpOLaEE4tA4z8fzA3IshR8yXupgmPdmd_SkjPw6NuWFTerpkDj_eCRUnGLHrPz1GEZyQ')"></div>
<div class="absolute inset-0 bg-gradient-to-t from-deep-obsidian via-deep-obsidian/50 to-transparent"></div>
<div class="absolute bottom-0 left-0 p-8">
<h3 class="font-headline-lg-mobile text-headline-lg-mobile text-starlight-white mb-2">Peralatan Modern</h3>
<p class="font-body-md text-on-surface-variant max-w-md">Menggunakan teleskop refraktor apokromatik dan kamera CCD sensitivitas tinggi untuk menangkap hilal tipis di ambang visibilitas.</p>
</div>
</div>
<!-- Small Card 1 -->
<div class="glass-panel p-6 rounded-lg flex flex-col justify-between group hover:border-primary/30 transition-colors">
<span class="material-symbols-outlined text-4xl text-primary mb-4">explore</span>
<div>
<h4 class="font-headline-lg-mobile text-[20px] text-starlight-white mb-2">Penentuan Titik</h4>
<p class="font-body-md text-sm text-on-surface-variant">Survei horizon dan kalibrasi arah barat presisi sebelum matahari terbenam.</p>
</div>
</div>
<!-- Small Card 2 -->
<div class="glass-panel p-6 rounded-lg flex flex-col justify-between group hover:border-primary/30 transition-colors">
<span class="material-symbols-outlined text-4xl text-primary mb-4">analytics</span>
<div>
<h4 class="font-headline-lg-mobile text-[20px] text-starlight-white mb-2">Analisis Citra</h4>
<p class="font-body-md text-sm text-on-surface-variant">Pemrosesan citra digital untuk membedakan cahaya hilal dari hamburan cahaya senja.</p>
</div>
</div>
<!-- Wide Card -->
<div class="md:col-span-2 glass-panel p-6 rounded-lg flex items-center justify-between group hover:border-primary/30 transition-colors">
<div>
<h4 class="font-headline-lg-mobile text-[20px] text-starlight-white mb-1">Jaringan Observatorium</h4>
<p class="font-body-md text-sm text-on-surface-variant">Terkoneksi dengan simpul hisab rukyat nasional.</p>
</div>
<span class="material-symbols-outlined text-primary text-3xl">hub</span>
</div>
</div>
</div>
</section>
<!-- Program Kami / Workshops -->
<section class="w-full py-24 px-margin-mobile md:px-margin-desktop bg-surface-container-high border-y border-starlight-white/5" id="workshops">
<div class="max-w-container-max mx-auto">
<div class="flex flex-col md:flex-row justify-between items-end mb-12">
<div class="max-w-2xl">
<h2 class="font-headline-lg text-headline-lg md:font-display-lg md:text-display-lg text-starlight-white mb-4">
                        Program &amp; <span class="text-primary">Edukasi</span>
</h2>
<p class="font-body-md text-body-md text-on-surface-variant">
                        Membangun generasi faqih di bidang falak melalui pelatihan intensif dan kajian terstruktur.
                    </p>
</div>
<button class="hidden md:flex text-primary font-label-caps text-label-caps uppercase tracking-widest items-center gap-2 hover:text-primary-fixed-dim transition-colors">
                    Lihat Semua Program
                    <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
</button>
</div>
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
<!-- Program Card 1 -->
<div class="glass-panel p-8 rounded-lg data-card-border hover:-translate-y-1 transition-transform duration-300">
<div class="w-12 h-12 rounded bg-surface flex items-center justify-center text-primary mb-6">
<span class="material-symbols-outlined">menu_book</span>
</div>
<h3 class="font-headline-lg-mobile text-[20px] text-starlight-white mb-3">Daurah Falakiyah</h3>
<p class="font-body-md text-sm text-on-surface-variant mb-6">Pelatihan dasar dan menengah ilmu falak untuk santri dan mahasiswa. Membahas kitab-kitab turats hingga aplikasi modern.</p>
<div class="font-label-caps text-label-caps text-primary border border-primary/20 bg-primary/5 px-3 py-1 rounded inline-block">Q3 2024</div>
</div>
<!-- Program Card 2 -->
<div class="glass-panel p-8 rounded-lg data-card-border hover:-translate-y-1 transition-transform duration-300">
<div class="w-12 h-12 rounded bg-surface flex items-center justify-center text-primary mb-6">
<span class="material-symbols-outlined">biotech</span>
</div>
<h3 class="font-headline-lg-mobile text-[20px] text-starlight-white mb-3">Workshop Rukyat</h3>
<p class="font-body-md text-sm text-on-surface-variant mb-6">Praktik lapangan penggunaan instrumen astronomi, perakitan teleskop, dan teknik astrofotografi hilal.</p>
<div class="font-label-caps text-label-caps text-primary border border-primary/20 bg-primary/5 px-3 py-1 rounded inline-block">Pendaftaran Buka</div>
</div>
<!-- Program Card 3 -->
<div class="glass-panel p-8 rounded-lg data-card-border hover:-translate-y-1 transition-transform duration-300">
<div class="w-12 h-12 rounded bg-surface flex items-center justify-center text-primary mb-6">
<span class="material-symbols-outlined">group_work</span>
</div>
<h3 class="font-headline-lg-mobile text-[20px] text-starlight-white mb-3">Halaqah Rutin</h3>
<p class="font-body-md text-sm text-on-surface-variant mb-6">Kajian rutin dua mingguan membahas isu-isu kontemporer penanggalan hijriyah dan bedah algoritma hisab.</p>
<div class="font-label-caps text-label-caps text-primary border border-primary/20 bg-primary/5 px-3 py-1 rounded inline-block">Setiap Minggu</div>
</div>
</div>
<button class="md:hidden mt-8 w-full border border-primary text-primary px-8 py-3 rounded font-label-caps text-label-caps uppercase tracking-widest justify-center flex items-center gap-2">
                Lihat Semua Program
            </button>
</div>
</section>
<!-- Footer -->
<footer class="w-full bottom-0 bg-surface-container-lowest dark:bg-surface-container-lowest border-t border-starlight-white/5">
<div class="flex flex-col md:flex-row justify-between items-center px-margin-mobile md:px-margin-desktop py-12 w-full max-w-container-max mx-auto gap-8 md:gap-0">
<!-- Brand / Copyright -->
<div class="flex flex-col items-center md:items-start gap-4">
<img alt="Al-Kaukaba Logo" class="h-8 w-auto object-contain" src="{{ asset('images/logo-putih.svg') }}"/>
<p class="font-body-md text-body-md text-on-surface-variant text-sm text-center md:text-left">
                    © {{ date('Y') }} Al-Kaukaba Study Circle. Precision in Hisab, Clarity in Rukyat.
                </p>
</div>
<!-- Links -->
<nav class="flex flex-wrap justify-center gap-6">
<a class="font-body-md text-body-md text-on-surface-variant hover:text-primary-fixed-dim transition-colors focus:ring-1 focus:ring-primary-container outline-none rounded px-1" href="#">Academic Journal</a>
<a class="font-body-md text-body-md text-on-surface-variant hover:text-primary-fixed-dim transition-colors focus:ring-1 focus:ring-primary-container outline-none rounded px-1" href="#">Observation Map</a>
<a class="font-body-md text-body-md text-on-surface-variant hover:text-primary-fixed-dim transition-colors focus:ring-1 focus:ring-primary-container outline-none rounded px-1" href="#">Hijri Calendar</a>
<a class="font-body-md text-body-md text-on-surface-variant hover:text-primary-fixed-dim transition-colors focus:ring-1 focus:ring-primary-container outline-none rounded px-1" href="#">Privacy Policy</a>
</nav>
</div>
</footer>
<!-- Join Circle Modal -->
<div class="hidden fixed inset-0 z-[60] flex items-center justify-center px-margin-mobile" id="join-circle-modal">
<div class="absolute inset-0 bg-deep-obsidian/80" onclick="document.getElementById('join-circle-modal').classList.add('hidden')"></div>
<div class="relative w-full max-w-md glass-panel bg-surface-container-high rounded-lg p-8">
<button aria-label="Tutup" class="absolute top-4 right-4 text-on-surface-variant hover:text-primary" onclick="document.getElementById('join-circle-modal').classList.add('hidden')" type="button">
<span class="material-symbols-outlined">close</span>
</button>
<h3 class="font-headline-lg-mobile text-[20px] text-starlight-white mb-2">Join Circle</h3>
<p class="font-body-md text-sm text-on-surface-variant mb-6">Daftarkan diri Anda untuk bergabung dengan Al-Kaukaba Study Circle.</p>
@if (session('circle_joined'))
<div class="mb-4 px-4 py-3 rounded bg-primary/10 border border-primary/30 text-primary text-sm">
                Pendaftaran berhasil! Kami akan menghubungi Anda segera.
            </div>
@endif
<form action="{{ route('circle.join') }}" class="space-y-4" method="POST">
@csrf
<div>
<label class="font-label-caps text-[10px] text-on-surface-variant uppercase tracking-widest" for="name">Nama Lengkap</label>
<input class="mt-1 w-full bg-surface border border-starlight-white/10 rounded px-4 py-2 text-on-surface focus:outline-none focus:border-primary" id="name" name="name" required type="text" value="{{ old('name') }}"/>
@error('name')
<p class="text-error text-xs mt-1">{{ $message }}</p>
@enderror
</div>
<div>
<label class="font-label-caps text-[10px] text-on-surface-variant uppercase tracking-widest" for="email">Email</label>
<input class="mt-1 w-full bg-surface border border-starlight-white/10 rounded px-4 py-2 text-on-surface focus:outline-none focus:border-primary" id="email" name="email" required type="email" value="{{ old('email') }}"/>
@error('email')
<p class="text-error text-xs mt-1">{{ $message }}</p>
@enderror
</div>
<div>
<label class="font-label-caps text-[10px] text-on-surface-variant uppercase tracking-widest" for="phone">No. WhatsApp/HP</label>
<input class="mt-1 w-full bg-surface border border-starlight-white/10 rounded px-4 py-2 text-on-surface focus:outline-none focus:border-primary" id="phone" name="phone" required type="text" value="{{ old('phone') }}"/>
@error('phone')
<p class="text-error text-xs mt-1">{{ $message }}</p>
@enderror
</div>
<button class="w-full bg-primary-container text-on-primary px-6 py-3 rounded font-label-caps text-label-caps uppercase tracking-widest hover:bg-primary-fixed transition-colors duration-150" type="submit">
                    Daftar Sekarang
                </button>
</form>
</div>
</div>
<script>
        // Simple mobile menu toggle
        document.getElementById('mobile-menu-btn').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });

        // Navbar blur on scroll
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('glass-panel');
                navbar.classList.remove('bg-surface');
            } else {
                navbar.classList.remove('glass-panel');
                navbar.classList.add('bg-surface');
            }
        });

                const lamongan = { latitude: -7.1167, longitude: 112.4167 };
                const phaseLabels = [
                        [0.03, 'Bulan Baru'],
                        [0.22, 'Sabit Menjelang Perbani'],
                        [0.28, 'Perbani Awal'],
                        [0.47, 'Cembung Menjelang Purnama'],
                        [0.53, 'Purnama'],
                        [0.72, 'Cembung Menjelang Perbani Akhir'],
                        [0.78, 'Perbani Akhir'],
                        [1, 'Sabit Menjelang Bulan Baru']
                ];

                function getPhaseLabel(phase) {
                        return phaseLabels.find(([boundary]) => phase < boundary)?.[1] ?? 'Bulan Baru';
                }

                function updateMoonObservation() {
                        const now = new Date();
                        const illumination = SunCalc.getMoonIllumination(now);
                        const position = SunCalc.getMoonPosition(now, lamongan.latitude, lamongan.longitude);
                        const altitude = position.altitude * 180 / Math.PI;

                        document.getElementById('moon-phase').textContent = getPhaseLabel(illumination.phase);
                        document.getElementById('moon-illumination').textContent = `${(illumination.fraction * 100).toFixed(1)}%`;
                        document.getElementById('moon-altitude').textContent = `${altitude >= 0 ? '+' : ''}${altitude.toFixed(1)}° ${altitude >= 0 ? '(di atas horizon)' : '(di bawah horizon)'}`;
                        document.getElementById('moon-updated').textContent = `Diperbarui ${now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' })} WIB`;
                }

                updateMoonObservation();
                window.setInterval(updateMoonObservation, 60000);

                @if (session('circle_joined') || $errors->any())
                document.getElementById('join-circle-modal').classList.remove('hidden');
                @endif
    </script>
</body></html>
