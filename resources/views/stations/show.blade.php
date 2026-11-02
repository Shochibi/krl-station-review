@extends('layouts.app')

@section('title', $station->name . ' [' . ($station->code ?? 'KRL') . '] - Ulasan & Fasilitas Stasiun KRL 2026')

@section('content')

@php $meta = $station->line_meta; @endphp

<div class="max-w-6xl mx-auto px-4 sm:px-6 py-8">

    <!-- Breadcrumb & Back Button -->
    <div class="flex items-center justify-between mb-6">
        <a href="{{ route('home', ['line' => $station->line_name]) }}"
           class="inline-flex items-center gap-2 text-xs font-bold text-slate-600 hover:text-red-600 bg-white border border-slate-200 px-3 py-1.5 rounded-xl shadow-2xs transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            <span>Kembali ke {{ $station->line_name }}</span>
        </a>

        <div class="text-xs text-slate-400 hidden sm:flex items-center gap-1.5 font-medium">
            <a href="{{ route('home') }}" class="hover:text-slate-600">Home</a>
            <span>/</span>
            <span class="text-slate-600">{{ $station->line_name }}</span>
            <span>/</span>
            <span class="text-slate-900 font-bold">{{ $station->name }}</span>
        </div>
    </div>

    <!-- Alert Success / Status -->
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-2xl mb-6 flex items-center gap-3 shadow-xs">
            <div class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <div>
                <p class="text-sm font-bold">{{ session('success') }}</p>
                <p class="text-xs text-emerald-600">Terima kasih telah berkontribusi untuk sesama pengguna KRL Commuter Line.</p>
            </div>
        </div>
    @endif

    <!-- Alert Errors -->
    @if(isset($errors) && $errors->any())
        <div class="bg-red-50 border border-red-200 text-red-800 p-4 rounded-2xl mb-6 shadow-xs">
            <div class="flex items-center gap-2 text-sm font-bold text-red-700 mb-1">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                Periksa kembali formulir Anda:
            </div>
            <ul class="list-disc pl-8 text-xs space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Station Wayfinding Hero Card -->
    <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm mb-10">
        
        <!-- Line Stripe -->
        <div class="h-2 w-full {{ $meta['stripe'] }}"></div>

        <!-- Hero Content / Image -->
        @if($station->image_url)
            <div class="h-64 sm:h-80 relative overflow-hidden bg-slate-900">
                <img src="{{ $station->image_url }}" alt="{{ $station->name }}" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/40 to-transparent"></div>
                
                <div class="absolute bottom-6 left-6 right-6 text-white flex flex-col sm:flex-row sm:items-end justify-between gap-4">
                    <div>
                        <div class="flex items-center gap-2 mb-2">
                            <span class="font-mono-sign text-xs font-bold px-2 py-0.5 rounded bg-white text-slate-900">
                                {{ $station->code }}
                            </span>
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded text-xs font-bold {{ $meta['badge_bg'] }}">
                                <span class="w-2 h-2 rounded-full {{ $meta['dot'] }}"></span>
                                {{ $station->line_name }}
                            </span>
                            @if($station->is_transit)
                                <span class="bg-emerald-500/90 text-white text-xs font-bold px-2 py-0.5 rounded">
                                    ⇄ Transit Hub
                                </span>
                            @endif
                        </div>
                        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-white font-mono-sign uppercase">
                            STASIUN {{ $station->name }}
                        </h1>
                        <p class="text-slate-300 text-sm mt-1 flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            {{ $station->city }} • KAI Commuter
                        </p>
                    </div>

                    <div class="bg-slate-900/80 backdrop-blur-md border border-white/20 rounded-2xl p-4 flex items-center gap-5 text-right sm:text-left">
                        <div>
                            <div class="text-[11px] text-slate-400 uppercase tracking-wider font-bold">Skor Komunitas</div>
                            <div class="text-2xl font-extrabold text-white flex items-center gap-1">
                                <span class="text-amber-400">★</span>
                                <span>{{ $station->public_reviews_avg_rating ? number_format($station->public_reviews_avg_rating, 1) : '-' }}</span>
                                <span class="text-xs text-slate-400 font-normal">/ 5</span>
                            </div>
                        </div>
                        <div class="border-l border-white/20 pl-4">
                            <div class="text-[11px] text-slate-400 uppercase tracking-wider font-bold">Ulasan</div>
                            <div class="text-2xl font-extrabold text-white">
                                {{ $station->public_reviews_count }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- Papan Nama Stasiun KAI Style Banner -->
            <div class="bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 p-6 sm:p-10 text-white border-b border-slate-800">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6">
                    <div>
                        <div class="flex flex-wrap items-center gap-2 mb-3">
                            <span class="font-mono-sign text-sm font-bold px-2.5 py-1 rounded bg-red-600 text-white tracking-widest">
                                [{{ $station->code ?? 'KRL' }}]
                            </span>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-md text-xs font-bold bg-slate-800 text-slate-200 border border-slate-700">
                                <span class="w-2 h-2 rounded-full {{ $meta['dot'] }}"></span>
                                {{ $station->line_name }}
                            </span>
                            @if($station->is_transit)
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-md text-xs font-bold bg-emerald-500/20 text-emerald-400 border border-emerald-500/30">
                                    ⇄ Stasiun Transit Hub
                                </span>
                            @endif
                        </div>

                        <h1 class="text-3xl sm:text-5xl font-extrabold tracking-wide font-mono-sign uppercase text-white">
                            STASIUN {{ $station->name }}
                        </h1>

                        <p class="text-slate-300 text-sm mt-2 flex items-center gap-2">
                            <svg class="w-4 h-4 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span>{{ $station->city }}</span>
                            <span class="text-slate-600">•</span>
                            <span>Wilayah Operasional KAI Commuter 2026</span>
                        </p>
                    </div>

                    <!-- Rating Score Badge -->
                    <div class="bg-slate-800/80 border border-slate-700 rounded-2xl p-4 flex sm:flex-col items-center justify-between sm:justify-center text-center min-w-[140px]">
                        <span class="text-xs text-slate-400 font-bold uppercase tracking-wider">Rating Komunitas</span>
                        <div class="text-3xl font-extrabold text-amber-400 my-1 flex items-center gap-1 justify-center font-mono-sign">
                            <span>★</span>
                            <span>{{ $station->public_reviews_avg_rating ? number_format($station->public_reviews_avg_rating, 1) : '-' }}</span>
                        </div>
                        <span class="text-xs text-slate-400">{{ $station->public_reviews_count }} Ulasan Komuter</span>
                    </div>
                </div>
            </div>
        @endif

        <!-- Description & Verified Facilities Grid -->
        <div class="p-6 sm:p-8">
            
            @if($station->description)
                <div class="mb-8 p-4 rounded-2xl bg-slate-50 border border-slate-200/80">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-1">Karakteristik & Akses Stasiun</h3>
                    <p class="text-sm text-slate-700 leading-relaxed font-medium">
                        {{ $station->description }}
                    </p>
                </div>
            @endif

            <h3 class="text-sm font-bold uppercase tracking-wider text-slate-900 mb-4 flex items-center gap-2">
                <svg class="w-4 h-4 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Fasilitas & Kelengkapan Stasiun 2026
            </h3>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                @php
                    $facList = $station->facilities ?? [
                        'Toilet Bersih', 'Musholla', 'Tap Gate Elektronik', 'Pos Kesehatan', 'CCTV 24 Jam'
                    ];
                @endphp

                @foreach($facList as $facility)
                    <div class="flex items-center gap-2.5 p-3 rounded-xl bg-slate-50 border border-slate-200/80 text-xs font-semibold text-slate-800">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 shrink-0"></span>
                        <span class="truncate">{{ $facility }}</span>
                    </div>
                @endforeach
            </div>

            <!-- Jam Operasional & Layanan -->
            <div class="mt-6 pt-6 border-t border-slate-100 flex flex-wrap items-center justify-between gap-4 text-xs text-slate-500">
                <div class="flex items-center gap-2">
                    <span class="font-bold text-slate-700">Jam Operasional:</span>
                    <span>04:00 - 24:00 WIB (Setiap Hari)</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="font-bold text-slate-700">Kartu Pembayaran:</span>
                    <span>KMT, Kartu Uang Elektronik Bank (Flazz, TapCash, e-Money, Brizzi), QRIS GoTransit</span>
                </div>
            </div>

        </div>

    </div>

    <!-- Layout Grid: Form (Left) & Reviews (Right) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- Left Column: Add Review & Notes Form -->
        <div class="lg:col-span-5 space-y-6">
            
            <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-2xs sticky top-24">
                
                <div class="flex items-center justify-between mb-4 pb-4 border-b border-slate-100">
                    <div>
                        <h2 class="text-lg font-extrabold text-slate-900 tracking-tight">
                            Tulis Ulasan / Catatan
                        </h2>
                        <p class="text-xs text-slate-500 mt-0.5">
                            Bantu sesama anker atau simpan catatan pribadi.
                        </p>
                    </div>
                    <span class="w-8 h-8 rounded-xl bg-red-50 text-red-600 flex items-center justify-center font-bold text-sm">
                        ✍️
                    </span>
                </div>

                @auth
                    <form action="{{ route('reviews.store', $station) }}" method="POST" class="space-y-4" x-data="{ isPrivate: false, rating: '5' }">
                        @csrf

                        <!-- Privacy Toggle Segmented Switch -->
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                Mode Penyimpanan
                            </label>
                            
                            <div class="grid grid-cols-2 p-1 bg-slate-100 rounded-xl text-xs font-bold gap-1">
                                <button type="button"
                                        @click="isPrivate = false"
                                        :class="!isPrivate ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-500 hover:text-slate-900'"
                                        class="py-2 px-3 rounded-lg transition-all flex items-center justify-center gap-1.5">
                                    <span>🌐</span>
                                    <span>Ulasan Publik</span>
                                </button>

                                <button type="button"
                                        @click="isPrivate = true"
                                        :class="isPrivate ? 'bg-amber-500 text-white shadow-xs' : 'text-slate-500 hover:text-slate-900'"
                                        class="py-2 px-3 rounded-lg transition-all flex items-center justify-center gap-1.5">
                                    <span>🔒</span>
                                    <span>Buku Saku (Privat)</span>
                                </button>
                            </div>

                            <input type="hidden" name="is_private" :value="isPrivate ? '1' : '0'">

                            <!-- Explanatory note based on mode -->
                            <p class="text-[11px] text-slate-500 mt-1.5" x-show="!isPrivate">
                                📢 Ulasan dapat dibaca semua komuter dan memengaruhi skor stasiun.
                            </p>
                            <p class="text-[11px] text-amber-700 mt-1.5" x-show="isPrivate">
                                🔒 Catatan hanya tersimpan di akun Anda (misal info letak pintu gerbong / tempat parkir).
                            </p>
                        </div>

                        <!-- Rating Picker -->
                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <label class="text-xs font-bold uppercase tracking-wider text-slate-700">
                                    Beri Rating Stasiun
                                </label>
                                <span class="text-xs font-bold text-amber-600" x-text="rating + ' Bintang'"></span>
                            </div>

                            <div class="flex items-center gap-2">
                                @for($i = 1; $i <= 5; $i++)
                                    <label class="cursor-pointer">
                                        <input type="radio" name="rating" value="{{ $i }}" class="sr-only" x-model="rating">
                                        <span class="w-10 h-10 rounded-xl flex items-center justify-center text-lg font-bold border transition-all"
                                              :class="rating >= {{ $i }} ? 'bg-amber-50 border-amber-300 text-amber-500' : 'bg-slate-50 border-slate-200 text-slate-300'">
                                            ★
                                        </span>
                                    </label>
                                @endfor
                            </div>
                        </div>

                        <!-- Category Selector -->
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                Kategori
                            </label>
                            <select name="category" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-red-500">
                                <option value="">Pilih Kategori Bahasan</option>
                                <option value="Fasilitas" @selected(old('category') == 'Fasilitas')>Fasilitas & Kenyamanan</option>
                                <option value="Keramaian" @selected(old('category') == 'Keramaian')>Keramaian & Jam Padat</option>
                                <option value="Kuliner" @selected(old('category') == 'Kuliner')>Kuliner & Tempat Kopi</option>
                                <option value="Tips Transit" @selected(old('category') == 'Tips Transit')>Tips Transit & Posisi Gerbong</option>
                                <option value="Kebersihan" @selected(old('category') == 'Kebersihan')>Kebersihan Toilet & Peron</option>
                                <option value="Keamanan" @selected(old('category') == 'Keamanan')>Keamanan & Parkir Kendaraan</option>
                            </select>
                        </div>

                        <!-- Experience Content -->
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                Isi Ulasan atau Catatan
                            </label>
                            <textarea
                                name="content"
                                rows="4"
                                maxlength="2000"
                                required
                                placeholder="Tuliskan pengalaman nyata Anda di stasiun ini (misal: kondisi eskalator, posisi tangga tercepat, parkir motor, dll)..."
                                class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-red-500 placeholder-slate-400"
                            >{{ old('content') }}</textarea>
                            <div class="flex justify-between text-[11px] text-slate-400 mt-1">
                                <span>Minimal 5 karakter</span>
                                <span>Maksimal 2000 karakter</span>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit"
                                class="w-full py-3 px-4 rounded-xl font-bold text-xs text-white bg-red-600 hover:bg-red-700 active:bg-red-800 shadow-md shadow-red-600/20 transition-all flex items-center justify-center gap-2">
                            <span x-text="isPrivate ? 'Simpan ke Buku Saku 🔒' : 'Kirim Ulasan Komunitas 🌐'"></span>
                        </button>

                    </form>
                @else
                    <!-- Login Prompt -->
                    <div class="bg-slate-50 rounded-2xl p-6 text-center border border-slate-200">
                        <div class="w-12 h-12 rounded-xl bg-red-100 text-red-600 flex items-center justify-center mx-auto mb-3 font-bold text-lg">
                            🔒
                        </div>
                        <h4 class="font-bold text-slate-900 text-sm">
                            Ingin Menulis Ulasan atau Catatan?
                        </h4>
                        <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                            Masuk ke akun Anda untuk membagikan pengalaman stasiun atau menyimpan catatan privat ke buku saku komuter.
                        </p>
                        <div class="mt-4 flex gap-2 justify-center">
                            <a href="{{ route('login') }}" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded-xl transition-colors">
                                Masuk
                            </a>
                            <a href="{{ route('register') }}" class="px-4 py-2 bg-white hover:bg-slate-100 text-slate-700 border border-slate-200 text-xs font-bold rounded-xl transition-colors">
                                Daftar Gratis
                            </a>
                        </div>
                    </div>
                @endauth

            </div>

            <!-- Other Stations on This Line -->
            @if($sameLineStations->isNotEmpty())
                <div class="bg-white rounded-3xl border border-slate-200 p-5 shadow-2xs">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-3 flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full {{ $meta['dot'] }}"></span>
                        Stasiun Lain di {{ $station->line_name }}
                    </h3>
                    <div class="grid grid-cols-2 gap-2">
                        @foreach($sameLineStations as $sLine)
                            <a href="{{ route('stations.show', $sLine) }}"
                               class="p-2.5 rounded-xl bg-slate-50 hover:bg-slate-100 border border-slate-200/80 transition-colors flex items-center justify-between group">
                                <span class="text-xs font-bold text-slate-800 group-hover:text-red-600 truncate">
                                    {{ $sLine->name }}
                                </span>
                                <span class="font-mono-sign text-[10px] text-slate-400 font-bold ml-1">
                                    {{ $sLine->code }}
                                </span>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>

        <!-- Right Column: User's Private Notes & Public Reviews -->
        <div class="lg:col-span-7 space-y-8">
            
            <!-- Owner's Private Notes on This Station -->
            @auth
                @if($myPrivateNotes->isNotEmpty())
                    <section class="bg-amber-50/70 border border-amber-200/80 rounded-3xl p-6 shadow-2xs">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-2">
                                <span class="w-7 h-7 rounded-lg bg-amber-500 text-white flex items-center justify-center font-bold text-xs">
                                    🔒
                                </span>
                                <div>
                                    <h3 class="text-base font-extrabold text-amber-950">
                                        Buku Saku Komuter Anda di Stasiun Ini
                                    </h3>
                                    <p class="text-xs text-amber-800">
                                        Catatan privat yang hanya bisa dibaca oleh Anda.
                                    </p>
                                </div>
                            </div>
                            <span class="text-xs font-bold bg-amber-200/80 text-amber-900 px-2.5 py-1 rounded-full">
                                {{ $myPrivateNotes->count() }} Catatan
                            </span>
                        </div>

                        <div class="space-y-3">
                            @foreach($myPrivateNotes as $note)
                                <div class="bg-white rounded-2xl p-4 border border-amber-200 shadow-2xs">
                                    <div class="flex items-center justify-between text-xs mb-2">
                                        <span class="font-bold text-amber-800 bg-amber-50 px-2 py-0.5 rounded border border-amber-200">
                                            {{ $note->category }}
                                        </span>
                                        <span class="text-slate-400 text-[11px]">
                                            {{ $note->created_at->format('d M Y, H:i') }}
                                        </span>
                                    </div>
                                    @if($note->rating)
                                        <div class="text-xs text-amber-500 font-bold mb-1">
                                            {{ str_repeat('★', $note->rating) }} ({{ $note->rating }}/5)
                                        </div>
                                    @endif
                                    <p class="text-xs text-slate-700 whitespace-pre-line leading-relaxed">
                                        {{ $note->content }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endif
            @endauth

            <!-- Public Reviews Section -->
            <section>
                
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-xl font-extrabold text-slate-900 tracking-tight flex items-center gap-2">
                            <span>💬 Ulasan Komunitas</span>
                            <span class="text-xs font-bold text-slate-500 bg-slate-100 px-2 py-0.5 rounded-full">
                                {{ $station->public_reviews_count }}
                            </span>
                        </h2>
                        <p class="text-xs text-slate-500 mt-0.5">
                            Pengalaman nyata komuter harian di Stasiun {{ $station->name }}.
                        </p>
                    </div>

                    <!-- Average Score Badge -->
                    @if($station->public_reviews_avg_rating)
                        <div class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-slate-900 text-white text-xs font-bold font-mono-sign">
                            <span class="text-amber-400">★</span>
                            <span>{{ number_format($station->public_reviews_avg_rating, 1) }}</span>
                            <span class="text-slate-400 font-normal">/ 5.0</span>
                        </div>
                    @endif
                </div>

                <!-- Reviews Feed -->
                <div class="space-y-4">
                    @forelse($reviews as $review)
                        <article class="bg-white rounded-2xl border border-slate-200 p-5 shadow-2xs hover:border-slate-300 transition-colors">
                            
                            <!-- Header: User Avatar & Meta -->
                            <div class="flex items-start justify-between gap-3">
                                
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-slate-900 text-white font-bold text-xs flex items-center justify-center uppercase shrink-0">
                                        {{ substr($review->user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <h4 class="text-sm font-bold text-slate-900">{{ $review->user->name }}</h4>
                                            <span class="text-[10px] font-semibold text-slate-500 bg-slate-100 px-1.5 py-0.2 rounded">
                                                Anker Komuter
                                            </span>
                                        </div>
                                        <span class="text-[11px] text-slate-400">
                                            {{ $review->created_at->format('d M Y, H:i') }} WIB
                                        </span>
                                    </div>
                                </div>

                                <!-- Rating Stars -->
                                @if($review->rating)
                                    <div class="flex items-center gap-1 text-amber-500 text-xs font-bold bg-amber-50 px-2 py-1 rounded-lg border border-amber-200">
                                        <span>{{ str_repeat('★', $review->rating) }}</span>
                                        <span class="text-slate-700 font-mono-sign">{{ $review->rating }}/5</span>
                                    </div>
                                @endif

                            </div>

                            <!-- Category Badge -->
                            <div class="mt-3">
                                <span class="inline-flex items-center text-[10px] font-bold px-2 py-0.5 rounded-md bg-slate-100 text-slate-700 border border-slate-200">
                                    Kategori: {{ $review->category }}
                                </span>
                            </div>

                            <!-- Content -->
                            <div class="mt-3 text-xs text-slate-700 leading-relaxed whitespace-pre-line">
                                {{ $review->content }}
                            </div>

                        </article>
                    @empty
                        <!-- Empty Reviews State -->
                        <div class="bg-white rounded-3xl border border-slate-200 p-10 text-center">
                            <div class="w-14 h-14 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3 text-xl">
                                🚉
                            </div>
                            <h3 class="font-bold text-slate-900 text-sm">
                                Belum Ada Ulasan Publik
                            </h3>
                            <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto leading-relaxed">
                                Jadilah yang pertama membagikan ulasan atau tips seputar Stasiun {{ $station->name }} untuk membantu komuter lainnya!
                            </p>
                        </div>
                    @endforelse
                </div>

                <!-- Reviews Pagination -->
                @if($reviews->hasPages())
                    <div class="mt-6">
                        {{ $reviews->links() }}
                    </div>
                @endif

            </section>

        </div>

    </div>

</div>

@endsection
