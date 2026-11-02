<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'KRL Review - Autentikasi') }}</title>

        <!-- Fonts: Plus Jakarta Sans -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            body { font-family: 'Plus Jakarta Sans', system-ui, sans-serif; }
            .font-mono-sign { font-family: 'JetBrains Mono', monospace; }
        </style>
    </head>
    <body class="flex flex-col min-h-screen bg-slate-50 text-slate-800 antialiased">
        <div class="min-h-screen flex flex-col justify-center items-center px-4 py-12 relative overflow-hidden">
            <!-- Subtle rail grid pattern background -->
            <div class="absolute inset-0 opacity-5 bg-[radial-gradient(#0f172a_1px,transparent_1px)] [background-size:20px_20px] pointer-events-none"></div>

            <!-- Brand Logo -->
            <div class="mb-6 text-center relative z-10">
                <a href="{{ route('home') }}" class="group inline-flex items-center gap-3">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-red-600 to-rose-700 flex items-center justify-center text-white shadow-lg shadow-red-500/20 group-hover:scale-105 transition-transform">
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="4" y="3" width="16" height="16" rx="3" />
                            <path d="M4 11h16" />
                            <path d="M12 3v8" />
                            <path d="m8 19-3 3" />
                            <path d="m16 19 3 3" />
                            <circle cx="8" cy="15" r="1" fill="currentColor" />
                            <circle cx="16" cy="15" r="1" fill="currentColor" />
                        </svg>
                    </div>
                    <div class="text-left">
                        <div class="flex items-center gap-1.5">
                            <span class="font-extrabold text-2xl tracking-tight text-slate-900 group-hover:text-red-600 transition-colors">KRL<span class="text-red-600">REVIEW</span></span>
                            <span class="px-1.5 py-0.5 text-[10px] font-bold bg-slate-200 text-slate-700 rounded">2026</span>
                        </div>
                        <p class="text-xs text-slate-500 font-medium">Komunitas Anak Kereta Indonesia</p>
                    </div>
                </a>
            </div>

            <!-- Card Box -->
            <div class="w-full sm:max-w-md bg-white border border-slate-200/90 shadow-sm rounded-3xl overflow-hidden relative z-10">
                <!-- Top Line Strip -->
                <div class="grid grid-cols-7 h-1 w-full">
                    <div class="bg-red-600"></div>
                    <div class="bg-blue-600"></div>
                    <div class="bg-emerald-600"></div>
                    <div class="bg-amber-700"></div>
                    <div class="bg-pink-600"></div>
                    <div class="bg-cyan-600"></div>
                    <div class="bg-yellow-600"></div>
                </div>

                <div class="p-6 sm:p-8">
                    {{ $slot }}
                </div>
            </div>

            <!-- Back to Home -->
            <div class="mt-6 text-center text-xs text-slate-500 relative z-10">
                <a href="{{ route('home') }}" class="hover:text-slate-900 font-semibold inline-flex items-center gap-1">
                    <span>← Kembali ke Direktori Stasiun KRL</span>
                </a>
            </div>
        </div>
    </body>
</html>
