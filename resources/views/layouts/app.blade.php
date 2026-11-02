<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'KRL Review - Direktori & Catatan Komuter 2026')</title>

    <!-- Fonts: Inter & JetBrains Mono for authentic transit signage -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
        }
        .font-mono-sign {
            font-family: 'JetBrains Mono', monospace;
        }
    </style>
</head>

<body class="flex flex-col min-h-screen bg-slate-50 text-slate-800 antialiased selection:bg-red-500 selection:text-white">

    <!-- Top Transit Network Status Bar -->
    <div class="bg-slate-900 text-slate-300 text-xs border-b border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-2 flex flex-col sm:flex-row justify-between items-center gap-2">
            <div class="flex items-center gap-2 text-[11px] sm:text-xs">
                <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full bg-emerald-500/20 text-emerald-400 font-semibold border border-emerald-500/30">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                    Jaringan KRL 2026 Normal
                </span>
                <span class="hidden md:inline text-slate-400">•</span>
                <span class="hidden md:inline text-slate-400">100 Stasiun Aktif Jabodetabek & Yogya-Solo</span>
            </div>
            <div class="flex items-center gap-4 text-[11px] sm:text-xs text-slate-400 font-medium">
                <span class="hidden lg:flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                    </svg>
                    Integrasi MRT, LRT & TJ
                </span>
                <span class="text-slate-500">|</span>
                <span class="text-slate-300">Tahun Operasional 2026</span>
            </div>
        </div>
    </div>

    <!-- Main Navigation Header -->
    <header class="bg-white/95 backdrop-blur-md border-b border-slate-200/80 sticky top-0 z-40 shadow-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 h-18 flex items-center justify-between">
            
            <!-- Logo & Brand Identity -->
            <a href="{{ route('home') }}" class="group flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-red-600 via-red-600 to-rose-700 flex items-center justify-center text-white shadow-md shadow-red-500/20 group-hover:scale-105 transition-transform">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="4" y="3" width="16" height="16" rx="3" />
                        <path d="M4 11h16" />
                        <path d="M12 3v8" />
                        <path d="m8 19-3 3" />
                        <path d="m16 19 3 3" />
                        <circle cx="8" cy="15" r="1" fill="currentColor" />
                        <circle cx="16" cy="15" r="1" fill="currentColor" />
                    </svg>
                </div>
                <div>
                    <div class="flex items-center gap-1.5">
                        <span class="font-extrabold text-xl tracking-tight text-slate-900 group-hover:text-red-600 transition-colors">KRL<span class="text-red-600">REVIEW</span></span>
                        <span class="px-1.5 py-0.5 text-[10px] font-bold tracking-wider uppercase bg-slate-100 text-slate-700 rounded border border-slate-200">2026</span>
                    </div>
                    <p class="text-[11px] text-slate-500 font-medium hidden sm:block">Panduan & Catatan Komunitas Komuter</p>
                </div>
            </a>

            <!-- Navigation Links -->
            <nav class="hidden md:flex items-center gap-1">
                <a href="{{ route('home') }}"
                   class="px-3.5 py-2 rounded-lg text-sm font-semibold transition-colors {{ request()->routeIs('home') ? 'bg-red-50 text-red-700' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                    Semua Stasiun
                </a>

                @auth
                    <a href="{{ route('reviews.my-notes') }}"
                       class="px-3.5 py-2 rounded-lg text-sm font-semibold flex items-center gap-2 transition-colors {{ request()->routeIs('reviews.my-notes') ? 'bg-amber-50 text-amber-900' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                        <svg class="w-4 h-4 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        Buku Saku Komuter
                    </a>
                @endauth
            </nav>

            <!-- User Auth Profile & Actions -->
            <div class="flex items-center gap-3">
                @auth
                    <div class="flex items-center gap-3 bg-slate-50 border border-slate-200/90 rounded-xl px-3 py-1.5">
                        <div class="w-7 h-7 rounded-lg bg-red-600 text-white font-bold text-xs flex items-center justify-center uppercase">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <div class="hidden sm:block text-left">
                            <span class="block text-xs font-bold text-slate-900 truncate max-w-[120px]">{{ auth()->user()->name }}</span>
                            <span class="block text-[10px] text-slate-500 font-medium">Anak Kereta</span>
                        </div>
                        <form action="{{ route('logout') }}" method="POST" class="ml-1">
                            @csrf
                            <button type="submit" 
                                    class="text-xs font-semibold text-slate-500 hover:text-red-600 p-1 hover:bg-red-50 rounded-md transition-colors"
                                    title="Keluar akun">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                            </button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}"
                       class="px-3.5 py-2 text-sm font-semibold text-slate-700 hover:text-slate-900 hover:bg-slate-100 rounded-lg transition-colors">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}"
                       class="px-4 py-2 text-sm font-bold text-white bg-red-600 hover:bg-red-700 active:bg-red-800 rounded-xl shadow-xs shadow-red-500/20 transition-all">
                        Daftar
                    </a>
                @endauth
            </div>

        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Authentic Transit Footer -->
    <footer class="bg-slate-950 text-slate-400 border-t border-slate-900 mt-20">
        <!-- Lines strip indicator -->
        <div class="grid grid-cols-7 h-1.5 w-full">
            <div class="bg-red-600" title="Lin Bogor"></div>
            <div class="bg-blue-600" title="Lin Cikarang"></div>
            <div class="bg-emerald-600" title="Lin Rangkasbitung"></div>
            <div class="bg-amber-700" title="Lin Tangerang"></div>
            <div class="bg-pink-600" title="Lin Tanjung Priok"></div>
            <div class="bg-cyan-600" title="Lin Bandara Soetta"></div>
            <div class="bg-yellow-600" title="Lin Yogyakarta-Solo"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-10">
                <!-- Col 1: Brand Info -->
                <div class="md:col-span-2">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-red-600 flex items-center justify-center text-white">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="4" y="3" width="16" height="16" rx="3" />
                                <path d="M4 11h16" />
                            </svg>
                        </div>
                        <span class="font-extrabold text-lg text-white tracking-tight">KRL<span class="text-red-500">REVIEW</span> <span class="text-xs font-bold text-slate-400">2026</span></span>
                    </div>
                    <p class="text-sm text-slate-400 mt-3 max-w-md leading-relaxed">
                        Platform direktori stasiun independen dan buku saku komuter terlengkap. Membantu anak kereta (anker) menemukan info fasilitas stasiun, jalur transit antarmoda, kuliner stasiun, hingga tips posisi gerbong.
                    </p>
                    <div class="flex flex-wrap items-center gap-2 mt-4 text-xs">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-slate-900 text-slate-300 border border-slate-800">
                            🔴 Lin Bogor
                        </span>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-slate-900 text-slate-300 border border-slate-800">
                            🔵 Lin Cikarang
                        </span>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-slate-900 text-slate-300 border border-slate-800">
                            🟢 Lin Rangkasbitung
                        </span>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-slate-900 text-slate-300 border border-slate-800">
                            🟤 Lin Tangerang
                        </span>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-slate-900 text-slate-300 border border-slate-800">
                            🟣 Lin Tj. Priok
                        </span>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-slate-900 text-slate-300 border border-slate-800">
                            🟡 Yogya-Solo
                        </span>
                    </div>
                </div>

                <!-- Col 2: Navigasi Cepat -->
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-200 mb-3">Navigasi Komuter</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('home') }}" class="hover:text-white transition-colors">Daftar Seluruh Stasiun</a></li>
                        <li><a href="{{ route('home', ['transit' => 1]) }}" class="hover:text-white transition-colors">Daftar Stasiun Transit Hub</a></li>
                        <li><a href="{{ route('reviews.my-notes') }}" class="hover:text-white transition-colors">Buku Saku Catatan Pribadi</a></li>
                    </ul>
                </div>

                <!-- Col 3: Layanan & Etika -->
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-200 mb-3">Informasi Kereta</h4>
                    <p class="text-xs text-slate-400 leading-relaxed mb-3">
                        Selalu dahulukan penumpang yang turun sebelum naik, dan berikan kursi prioritas bagi yang membutuhkan.
                    </p>
                    <div class="text-xs text-slate-500 space-y-1">
                        <p>Call Center Resmi KAI: <span class="text-slate-300 font-semibold">121</span></p>
                        <p>X (Twitter): <span class="text-slate-300 font-semibold">@CommuterLine</span></p>
                    </div>
                </div>
            </div>

            <div class="pt-8 border-t border-slate-900 flex flex-col sm:flex-row justify-between items-center gap-4 text-xs text-slate-500">
                <p>&copy; 2026 KRL Review. Dibuat dengan bangga untuk komunitas Anak Kereta (Anker) Indonesia.</p>
                <p>Data stasiun operasional terverifikasi 2026 (Jabodetabek & KRL Yogya-Solo).</p>
            </div>
        </div>
    </footer>

</body>
</html>
