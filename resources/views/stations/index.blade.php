@extends('layouts.app')

@section('title', 'Direktori & Ulasan Seluruh Stasiun KRL 2026 - KRL Review')

@section('content')

<!-- Transit Network Header & Search Hub -->
<section class="bg-gradient-to-b from-slate-900 via-slate-900 to-slate-800 text-white border-b border-slate-700/60 pt-10 pb-12 relative overflow-hidden">
    <!-- Subtle railway track grid pattern overlay -->
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#ffffff_1px,transparent_1px)] [background-size:16px_16px] pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 relative z-10">
        
        <!-- Wayfinding Header Badge -->
        <div class="flex flex-wrap items-center gap-2 mb-4">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-red-600/20 text-red-400 border border-red-500/30">
                <span class="w-2 h-2 rounded-full bg-red-500"></span>
                KAI COMMUTER 2026
            </span>
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-slate-800 text-slate-300 border border-slate-700">
                100 Stasiun Terintegrasi
            </span>
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-slate-800 text-slate-300 border border-slate-700">
                Jabodetabek & Lin Yogya-Solo
            </span>
        </div>

        <div class="max-w-3xl">
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold tracking-tight text-white leading-tight">
                Direktori Stasiun & Panduan Komuter <span class="text-transparent bg-clip-text bg-gradient-to-r from-red-400 via-rose-300 to-amber-200">KRL 2026</span>
            </h1>
            <p class="text-slate-300 text-sm sm:text-base mt-3 leading-relaxed">
                Jelajahi seluruh stasiun di jaringan KRL Commuter Line. Temukan info fasilitas stasiun, jalur transit antarmoda (MRT, LRT, Transjakarta), tempat kuliner, hingga catatan rahasia komuter harian.
            </p>
        </div>

        <!-- Integrated Search & Filter Form -->
        <form action="{{ route('home') }}" method="GET" class="mt-8 bg-white/10 backdrop-blur-md p-2.5 sm:p-3 rounded-2xl border border-white/15 shadow-xl max-w-4xl">
            <div class="flex flex-col sm:flex-row gap-2.5">
                
                <!-- Search Keyword -->
                <div class="relative flex-1">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <input
                        type="text"
                        name="search"
                        value="{{ $search }}"
                        placeholder="Ketik nama stasiun, kode (misal: MRI, THB, BOO), atau wilayah..."
                        class="w-full pl-11 pr-4 py-3 bg-white text-slate-900 rounded-xl text-sm placeholder-slate-400 font-medium focus:outline-none focus:ring-2 focus:ring-red-500 shadow-inner"
                    >
                </div>

                <!-- City / Region Filter Dropdown -->
                <div class="sm:w-56">
                    <select name="city"
                            class="w-full px-3.5 py-3 bg-white text-slate-800 rounded-xl text-sm font-medium focus:outline-none focus:ring-2 focus:ring-red-500 cursor-pointer shadow-inner">
                        <option value="">Semua Wilayah</option>
                        @foreach($allCities as $city)
                            <option value="{{ $city }}" @selected($selectedCity === $city)>
                                {{ $city }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Retain active line or transit filters -->
                @if($selectedLine)
                    <input type="hidden" name="line" value="{{ $selectedLine }}">
                @endif
                @if($transitOnly)
                    <input type="hidden" name="transit" value="1">
                @endif
                @if($sort && $sort !== 'name')
                    <input type="hidden" name="sort" value="{{ $sort }}">
                @endif

                <!-- Search Button -->
                <button type="submit"
                        class="bg-red-600 hover:bg-red-700 active:bg-red-800 text-white font-bold px-6 py-3 rounded-xl text-sm flex items-center justify-center gap-2 shadow-md shadow-red-600/30 transition-all">
                    <span>Cari Stasiun</span>
                </button>

                @if($search || $selectedCity || $selectedLine || $transitOnly)
                    <a href="{{ route('home') }}"
                       class="bg-slate-700 hover:bg-slate-600 text-white text-sm font-semibold px-4 py-3 rounded-xl flex items-center justify-center transition-colors"
                       title="Reset Semua Filter">
                        Reset
                    </a>
                @endif

            </div>
        </form>

        <!-- Quick Transit Stats -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mt-8 pt-6 border-t border-slate-800 text-slate-300">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-slate-800 flex items-center justify-center text-red-400 font-mono-sign font-bold text-sm border border-slate-700">
                    {{ $totalStations }}
                </div>
                <div>
                    <div class="text-xs text-slate-400">Total Stasiun 2026</div>
                    <div class="text-sm font-bold text-white">100% Beroperasi</div>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-slate-800 flex items-center justify-center text-blue-400 font-mono-sign font-bold text-sm border border-slate-700">
                    7
                </div>
                <div>
                    <div class="text-xs text-slate-400">Jalur / Lin KRL</div>
                    <div class="text-sm font-bold text-white">Jabodetabek & Yogya</div>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-slate-800 flex items-center justify-center text-emerald-400 font-mono-sign font-bold text-sm border border-slate-700">
                    {{ $totalTransit }}
                </div>
                <div>
                    <div class="text-xs text-slate-400">Stasiun Transit Hub</div>
                    <div class="text-sm font-bold text-white">Integrasi Antarmoda</div>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-slate-800 flex items-center justify-center text-amber-400 font-mono-sign font-bold text-sm border border-slate-700">
                    TOD
                </div>
                <div>
                    <div class="text-xs text-slate-400">Kawasan Berkelanjutan</div>
                    <div class="text-sm font-bold text-white">Ramah Komuter</div>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- Main Stations Explorer Area -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 py-8">

    <!-- Interactive Line Filter Tabs -->
    <div class="mb-6">
        <div class="flex items-center justify-between mb-3">
            <h2 class="text-xs font-bold uppercase tracking-wider text-slate-500">
                Filter Berdasarkan Lin KRL (Tahun 2026)
            </h2>
            <span class="text-xs text-slate-400 font-medium hidden sm:inline">
                Klik salah satu lin untuk memfilter stasiun
            </span>
        </div>

        <div class="flex items-center gap-2 overflow-x-auto pb-2 scrollbar-none">
            
            <!-- All Lines Tab -->
            <a href="{{ route('home', array_filter(['search' => $search, 'city' => $selectedCity, 'transit' => $transitOnly ? '1' : null, 'sort' => $sort])) }}"
               class="px-4 py-2 rounded-xl text-xs font-bold whitespace-nowrap transition-all flex items-center gap-2 border {{ empty($selectedLine) ? 'bg-slate-900 text-white border-slate-900 shadow-sm' : 'bg-white text-slate-700 border-slate-200 hover:border-slate-300 hover:bg-slate-50' }}">
                <span>Semua Lin</span>
                <span class="px-1.5 py-0.2 rounded-full text-[10px] {{ empty($selectedLine) ? 'bg-slate-700 text-slate-200' : 'bg-slate-100 text-slate-600' }}">
                    {{ $totalStations }}
                </span>
            </a>

            <!-- Lin Bogor -->
            @php $bogorCount = $lineCounts['Lin Bogor'] ?? 0; @endphp
            <a href="{{ route('home', array_filter(['line' => 'Lin Bogor', 'search' => $search, 'city' => $selectedCity, 'transit' => $transitOnly ? '1' : null, 'sort' => $sort])) }}"
               class="px-3.5 py-2 rounded-xl text-xs font-bold whitespace-nowrap transition-all flex items-center gap-2 border {{ $selectedLine === 'Lin Bogor' ? 'bg-red-600 text-white border-red-600 shadow-sm shadow-red-500/20' : 'bg-white text-slate-700 border-slate-200 hover:border-red-300 hover:bg-red-50/50' }}">
                <span class="w-2.5 h-2.5 rounded-full bg-red-500 {{ $selectedLine === 'Lin Bogor' ? 'ring-2 ring-white' : '' }}"></span>
                <span>Lin Bogor</span>
                <span class="px-1.5 py-0.2 rounded-full text-[10px] {{ $selectedLine === 'Lin Bogor' ? 'bg-red-700 text-red-100' : 'bg-slate-100 text-slate-600' }}">
                    {{ $bogorCount }}
                </span>
            </a>

            <!-- Lin Cikarang -->
            @php $cikarangCount = $lineCounts['Lin Cikarang'] ?? 0; @endphp
            <a href="{{ route('home', array_filter(['line' => 'Lin Cikarang', 'search' => $search, 'city' => $selectedCity, 'transit' => $transitOnly ? '1' : null, 'sort' => $sort])) }}"
               class="px-3.5 py-2 rounded-xl text-xs font-bold whitespace-nowrap transition-all flex items-center gap-2 border {{ $selectedLine === 'Lin Cikarang' ? 'bg-blue-600 text-white border-blue-600 shadow-sm shadow-blue-500/20' : 'bg-white text-slate-700 border-slate-200 hover:border-blue-300 hover:bg-blue-50/50' }}">
                <span class="w-2.5 h-2.5 rounded-full bg-blue-500 {{ $selectedLine === 'Lin Cikarang' ? 'ring-2 ring-white' : '' }}"></span>
                <span>Lin Cikarang</span>
                <span class="px-1.5 py-0.2 rounded-full text-[10px] {{ $selectedLine === 'Lin Cikarang' ? 'bg-blue-700 text-blue-100' : 'bg-slate-100 text-slate-600' }}">
                    {{ $cikarangCount }}
                </span>
            </a>

            <!-- Lin Rangkasbitung -->
            @php $rangkasCount = $lineCounts['Lin Rangkasbitung'] ?? 0; @endphp
            <a href="{{ route('home', array_filter(['line' => 'Lin Rangkasbitung', 'search' => $search, 'city' => $selectedCity, 'transit' => $transitOnly ? '1' : null, 'sort' => $sort])) }}"
               class="px-3.5 py-2 rounded-xl text-xs font-bold whitespace-nowrap transition-all flex items-center gap-2 border {{ $selectedLine === 'Lin Rangkasbitung' ? 'bg-emerald-600 text-white border-emerald-600 shadow-sm shadow-emerald-500/20' : 'bg-white text-slate-700 border-slate-200 hover:border-emerald-300 hover:bg-emerald-50/50' }}">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 {{ $selectedLine === 'Lin Rangkasbitung' ? 'ring-2 ring-white' : '' }}"></span>
                <span>Lin Rangkasbitung</span>
                <span class="px-1.5 py-0.2 rounded-full text-[10px] {{ $selectedLine === 'Lin Rangkasbitung' ? 'bg-emerald-700 text-emerald-100' : 'bg-slate-100 text-slate-600' }}">
                    {{ $rangkasCount }}
                </span>
            </a>

            <!-- Lin Tangerang -->
            @php $tangerangCount = $lineCounts['Lin Tangerang'] ?? 0; @endphp
            <a href="{{ route('home', array_filter(['line' => 'Lin Tangerang', 'search' => $search, 'city' => $selectedCity, 'transit' => $transitOnly ? '1' : null, 'sort' => $sort])) }}"
               class="px-3.5 py-2 rounded-xl text-xs font-bold whitespace-nowrap transition-all flex items-center gap-2 border {{ $selectedLine === 'Lin Tangerang' ? 'bg-amber-700 text-white border-amber-700 shadow-sm shadow-amber-700/20' : 'bg-white text-slate-700 border-slate-200 hover:border-amber-300 hover:bg-amber-50/50' }}">
                <span class="w-2.5 h-2.5 rounded-full bg-amber-600 {{ $selectedLine === 'Lin Tangerang' ? 'ring-2 ring-white' : '' }}"></span>
                <span>Lin Tangerang</span>
                <span class="px-1.5 py-0.2 rounded-full text-[10px] {{ $selectedLine === 'Lin Tangerang' ? 'bg-amber-800 text-amber-100' : 'bg-slate-100 text-slate-600' }}">
                    {{ $tangerangCount }}
                </span>
            </a>

            <!-- Lin Tanjung Priok -->
            @php $priokCount = $lineCounts['Lin Tanjung Priok'] ?? 0; @endphp
            <a href="{{ route('home', array_filter(['line' => 'Lin Tanjung Priok', 'search' => $search, 'city' => $selectedCity, 'transit' => $transitOnly ? '1' : null, 'sort' => $sort])) }}"
               class="px-3.5 py-2 rounded-xl text-xs font-bold whitespace-nowrap transition-all flex items-center gap-2 border {{ $selectedLine === 'Lin Tanjung Priok' ? 'bg-pink-600 text-white border-pink-600 shadow-sm shadow-pink-500/20' : 'bg-white text-slate-700 border-slate-200 hover:border-pink-300 hover:bg-pink-50/50' }}">
                <span class="w-2.5 h-2.5 rounded-full bg-pink-500 {{ $selectedLine === 'Lin Tanjung Priok' ? 'ring-2 ring-white' : '' }}"></span>
                <span>Lin Tanjung Priok</span>
                <span class="px-1.5 py-0.2 rounded-full text-[10px] {{ $selectedLine === 'Lin Tanjung Priok' ? 'bg-pink-700 text-pink-100' : 'bg-slate-100 text-slate-600' }}">
                    {{ $priokCount }}
                </span>
            </a>

            <!-- Lin Bandara Soetta -->
            @php $bandaraCount = $lineCounts['Lin Bandara Soekarno-Hatta'] ?? 0; @endphp
            <a href="{{ route('home', array_filter(['line' => 'Lin Bandara Soekarno-Hatta', 'search' => $search, 'city' => $selectedCity, 'transit' => $transitOnly ? '1' : null, 'sort' => $sort])) }}"
               class="px-3.5 py-2 rounded-xl text-xs font-bold whitespace-nowrap transition-all flex items-center gap-2 border {{ $selectedLine === 'Lin Bandara Soekarno-Hatta' ? 'bg-cyan-600 text-white border-cyan-600 shadow-sm shadow-cyan-500/20' : 'bg-white text-slate-700 border-slate-200 hover:border-cyan-300 hover:bg-cyan-50/50' }}">
                <span class="w-2.5 h-2.5 rounded-full bg-cyan-500 {{ $selectedLine === 'Lin Bandara Soekarno-Hatta' ? 'ring-2 ring-white' : '' }}"></span>
                <span>Lin Bandara Soetta</span>
                <span class="px-1.5 py-0.2 rounded-full text-[10px] {{ $selectedLine === 'Lin Bandara Soekarno-Hatta' ? 'bg-cyan-700 text-cyan-100' : 'bg-slate-100 text-slate-600' }}">
                    {{ $bandaraCount }}
                </span>
            </a>

            <!-- Lin Yogyakarta-Solo -->
            @php $jogjaCount = $lineCounts['Lin Yogyakarta-Solo'] ?? 0; @endphp
            <a href="{{ route('home', array_filter(['line' => 'Lin Yogyakarta-Solo', 'search' => $search, 'city' => $selectedCity, 'transit' => $transitOnly ? '1' : null, 'sort' => $sort])) }}"
               class="px-3.5 py-2 rounded-xl text-xs font-bold whitespace-nowrap transition-all flex items-center gap-2 border {{ $selectedLine === 'Lin Yogyakarta-Solo' ? 'bg-yellow-600 text-white border-yellow-600 shadow-sm shadow-yellow-500/20' : 'bg-white text-slate-700 border-slate-200 hover:border-yellow-300 hover:bg-yellow-50/50' }}">
                <span class="w-2.5 h-2.5 rounded-full bg-yellow-500 {{ $selectedLine === 'Lin Yogyakarta-Solo' ? 'ring-2 ring-white' : '' }}"></span>
                <span>Lin Yogya-Solo</span>
                <span class="px-1.5 py-0.2 rounded-full text-[10px] {{ $selectedLine === 'Lin Yogyakarta-Solo' ? 'bg-yellow-700 text-yellow-100' : 'bg-slate-100 text-slate-600' }}">
                    {{ $jogjaCount }}
                </span>
            </a>

        </div>
    </div>

    <!-- Controls Bar: Transit Filter, Sorting & Result Count -->
    <div class="bg-white border border-slate-200 rounded-2xl p-4 mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4 shadow-2xs">
        
        <div class="flex flex-wrap items-center gap-3">
            <span class="text-sm font-bold text-slate-900">
                Menampilkan <span class="text-red-600">{{ $stations->total() }}</span> Stasiun
            </span>

            @if($selectedLine)
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold bg-slate-100 text-slate-700 border border-slate-200">
                    Jalur: {{ $selectedLine }}
                    <a href="{{ route('home', array_filter(['search' => $search, 'city' => $selectedCity, 'transit' => $transitOnly ? '1' : null, 'sort' => $sort])) }}" class="text-slate-400 hover:text-red-600 ml-1">×</a>
                </span>
            @endif

            @if($selectedCity)
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold bg-slate-100 text-slate-700 border border-slate-200">
                    Wilayah: {{ $selectedCity }}
                    <a href="{{ route('home', array_filter(['line' => $selectedLine, 'search' => $search, 'transit' => $transitOnly ? '1' : null, 'sort' => $sort])) }}" class="text-slate-400 hover:text-red-600 ml-1">×</a>
                </span>
            @endif

            @if($transitOnly)
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                    ⇄ Stasiun Transit Saja
                    <a href="{{ route('home', array_filter(['line' => $selectedLine, 'city' => $selectedCity, 'search' => $search, 'sort' => $sort])) }}" class="text-emerald-500 hover:text-red-600 ml-1">×</a>
                </span>
            @endif
        </div>

        <div class="flex flex-wrap items-center gap-3">
            
            <!-- Transit Hub Toggle -->
            <a href="{{ route('home', array_filter(['line' => $selectedLine, 'city' => $selectedCity, 'search' => $search, 'sort' => $sort, 'transit' => $transitOnly ? null : '1'])) }}"
               class="px-3 py-1.5 rounded-xl text-xs font-semibold flex items-center gap-1.5 border transition-colors {{ $transitOnly ? 'bg-emerald-600 text-white border-emerald-600' : 'bg-slate-50 text-slate-600 border-slate-200 hover:bg-slate-100' }}">
                <span>⇄</span>
                <span>Hanya Transit Hub</span>
            </a>

            <!-- Sort Selector -->
            <div class="flex items-center gap-2">
                <span class="text-xs text-slate-500 font-medium">Urutkan:</span>
                <div class="flex rounded-lg border border-slate-200 overflow-hidden text-xs font-semibold">
                    <a href="{{ route('home', array_filter(['line' => $selectedLine, 'city' => $selectedCity, 'search' => $search, 'transit' => $transitOnly ? '1' : null, 'sort' => 'name'])) }}"
                       class="px-2.5 py-1.5 {{ $sort === 'name' ? 'bg-slate-900 text-white' : 'bg-white text-slate-600 hover:bg-slate-50' }}">
                        A-Z
                    </a>
                    <a href="{{ route('home', array_filter(['line' => $selectedLine, 'city' => $selectedCity, 'search' => $search, 'transit' => $transitOnly ? '1' : null, 'sort' => 'rating'])) }}"
                       class="px-2.5 py-1.5 border-l border-slate-200 {{ $sort === 'rating' ? 'bg-slate-900 text-white' : 'bg-white text-slate-600 hover:bg-slate-50' }}">
                        Rating ⭐
                    </a>
                    <a href="{{ route('home', array_filter(['line' => $selectedLine, 'city' => $selectedCity, 'search' => $search, 'transit' => $transitOnly ? '1' : null, 'sort' => 'reviews'])) }}"
                       class="px-2.5 py-1.5 border-l border-slate-200 {{ $sort === 'reviews' ? 'bg-slate-900 text-white' : 'bg-white text-slate-600 hover:bg-slate-50' }}">
                        Terpopuler
                    </a>
                </div>
            </div>

        </div>

    </div>

    <!-- Stations Grid -->
    @if($stations->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($stations as $station)
                @php $meta = $station->line_meta; @endphp
                <article class="bg-white rounded-2xl border border-slate-200/90 overflow-hidden shadow-2xs hover:shadow-md hover:border-slate-300 transition-all duration-200 flex flex-col group">
                    
                    <!-- Line Color Accent Stripe -->
                    <div class="h-1.5 w-full {{ $meta['stripe'] }}"></div>

                    <!-- Station Platform Header / Signage Box -->
                    <div class="p-4 sm:p-5 pb-3">
                        
                        <div class="flex items-start justify-between gap-2 mb-2.5">
                            <!-- Line Badge -->
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[11px] font-bold border {{ $meta['badge_bg'] }}">
                                <span class="w-2 h-2 rounded-full {{ $meta['dot'] }}"></span>
                                {{ $station->line_name }}
                            </span>

                            <!-- Station Code Badge in High Contrast Monospace -->
                            <span class="font-mono-sign text-xs font-bold px-2 py-0.5 rounded bg-slate-900 text-white tracking-wider">
                                {{ $station->code ?? 'KRL' }}
                            </span>
                        </div>

                        <!-- Station Name -->
                        <h3 class="text-xl font-extrabold text-slate-900 tracking-tight group-hover:text-red-600 transition-colors">
                            <a href="{{ route('stations.show', $station) }}">
                                {{ $station->name }}
                            </a>
                        </h3>

                        <!-- City / Region & Transit Hub Indicator -->
                        <div class="flex items-center gap-2 text-xs text-slate-500 mt-1">
                            <span class="flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                {{ $station->city }}
                            </span>

                            @if($station->is_transit)
                                <span class="text-slate-300">•</span>
                                <span class="inline-flex items-center gap-1 text-[11px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded">
                                    ⇄ Transit Hub
                                </span>
                            @endif
                        </div>

                    </div>

                    <!-- Visual Signboard / Photo Card -->
                    <div class="px-4 sm:px-5">
                        @if($station->image_url)
                            <div class="h-36 rounded-xl overflow-hidden relative border border-slate-100">
                                <img src="{{ $station->image_url }}" alt="{{ $station->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 via-transparent to-transparent"></div>
                                <div class="absolute bottom-2 left-2.5 text-white text-[11px] font-bold drop-shadow-sm flex items-center gap-1">
                                    <span class="w-2 h-2 rounded-full {{ $meta['dot'] }}"></span>
                                    {{ $station->code }} • {{ $station->name }}
                                </div>
                            </div>
                        @else
                            <!-- Authentic KAI-style Platform Signboard (Papan Stasiun) -->
                            <div class="h-32 rounded-xl bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 p-3.5 flex flex-col justify-between border border-slate-800 text-white relative overflow-hidden shadow-inner">
                                <div class="flex items-center justify-between text-[11px] text-slate-400 font-mono-sign">
                                    <span class="flex items-center gap-1">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $meta['dot'] }}"></span>
                                        {{ $meta['name_short'] }}
                                    </span>
                                    <span class="bg-slate-800 px-1.5 py-0.5 rounded text-[10px] text-slate-300 font-bold border border-slate-700">
                                        {{ $station->is_transit ? 'STASIUN TRANSIT' : 'STASIUN KOMUTER' }}
                                    </span>
                                </div>

                                <div class="my-auto text-center">
                                    <span class="text-xs font-mono-sign text-slate-400 tracking-widest block mb-0.5">KODE [{{ $station->code }}]</span>
                                    <h4 class="text-lg font-extrabold tracking-wide text-white font-mono-sign uppercase truncate">
                                        {{ $station->name }}
                                    </h4>
                                </div>

                                <div class="flex items-center justify-between text-[10px] text-slate-400 border-t border-slate-800 pt-1.5">
                                    <span>Jaringan KRL 2026</span>
                                    <span>KAI Commuter</span>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Facilities Chips -->
                    <div class="px-4 sm:px-5 pt-3">
                        @if(!empty($station->facilities) && is_array($station->facilities))
                            <div class="flex flex-wrap gap-1.5">
                                @foreach(array_slice($station->facilities, 0, 3) as $fac)
                                    <span class="inline-flex items-center text-[10px] font-medium bg-slate-100 text-slate-600 px-2 py-0.5 rounded">
                                        {{ $fac }}
                                    </span>
                                @endforeach
                                @if(count($station->facilities) > 3)
                                    <span class="text-[10px] text-slate-400 font-medium px-1">
                                        +{{ count($station->facilities) - 3 }} fasilitas
                                    </span>
                                @endif
                            </div>
                        @endif
                    </div>

                    <!-- Card Footer: Ratings & CTA -->
                    <div class="mt-auto p-4 sm:p-5 pt-4 flex items-center justify-between border-t border-slate-100 mt-4 bg-slate-50/50">
                        
                        <!-- Community Score -->
                        <div>
                            <div class="flex items-center gap-1 text-sm font-bold text-slate-900">
                                <span class="text-amber-500">★</span>
                                <span>{{ $station->public_reviews_avg_rating ? number_format($station->public_reviews_avg_rating, 1) : 'Baru' }}</span>
                                @if($station->public_reviews_avg_rating)
                                    <span class="text-xs text-slate-400 font-normal">/ 5</span>
                                @endif
                            </div>
                            <span class="text-[11px] text-slate-500">
                                {{ $station->public_reviews_count }} ulasan
                            </span>
                        </div>

                        <!-- Action Button -->
                        <a href="{{ route('stations.show', $station) }}"
                           class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl text-xs font-bold text-red-600 hover:text-white hover:bg-red-600 border border-red-200 hover:border-red-600 transition-all">
                            <span>Buka Info</span>
                            <span>→</span>
                        </a>

                    </div>

                </article>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-12">
            {{ $stations->links() }}
        </div>

    @else
        <!-- No Stations Found / Empty State -->
        <div class="bg-white border border-slate-200 rounded-3xl p-12 text-center max-w-lg mx-auto shadow-sm">
            <div class="w-16 h-16 rounded-2xl bg-red-50 text-red-600 flex items-center justify-center mx-auto mb-4 border border-red-100">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            
            <h3 class="text-lg font-bold text-slate-900">
                Stasiun Tidak Ditemukan
            </h3>
            
            <p class="text-sm text-slate-500 mt-2 leading-relaxed">
                Tidak ada stasiun yang cocok dengan kriteria pencarian "{{ $search }}". Pastikan ejaan nama stasiun atau kode stasiun sudah sesuai.
            </p>

            <div class="mt-6 flex flex-wrap justify-center gap-3">
                <a href="{{ route('home') }}"
                   class="bg-red-600 hover:bg-red-700 text-white font-bold px-5 py-2.5 rounded-xl text-sm transition-colors">
                    Lihat Seluruh 100 Stasiun
                </a>
            </div>
        </div>
    @endif

</section>

@endsection
