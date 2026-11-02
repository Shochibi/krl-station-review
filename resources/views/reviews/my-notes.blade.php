@extends('layouts.app')

@section('title', 'Buku Saku Komuter - Catatan Pribadi KRL')

@section('content')

<div class="max-w-5xl mx-auto px-4 sm:px-6 py-10">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8 pb-6 border-b border-slate-200">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <span class="w-8 h-8 rounded-xl bg-amber-500 text-white flex items-center justify-center font-bold text-sm shadow-sm">
                    🔒
                </span>
                <span class="text-xs font-bold uppercase tracking-wider text-amber-700 bg-amber-100/70 px-2.5 py-0.5 rounded-md">
                    Catatan Rahasia Komuter
                </span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                Buku Saku Komuter Anda
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                Koleksi catatan rahasia: posisi pintu gerbong favorit, jadwal transit, tempat parkir motor aman, hingga titik ngopi stasiun.
            </p>
        </div>

        <a href="{{ route('home') }}"
           class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold text-white bg-slate-900 hover:bg-slate-800 transition-colors shadow-xs">
            <span>+ Eksplor Stasiun Baru</span>
        </a>
    </div>

    <!-- Notebook Stats Banner -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
        <div class="bg-white border border-slate-200 rounded-2xl p-4 flex items-center gap-3 shadow-2xs">
            <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold text-lg border border-amber-100">
                📝
            </div>
            <div>
                <div class="text-xs text-slate-400 font-semibold">Total Catatan</div>
                <div class="text-lg font-extrabold text-slate-900">{{ $totalNotes }} Catatan</div>
            </div>
        </div>

        <div class="bg-white border border-slate-200 rounded-2xl p-4 flex items-center gap-3 shadow-2xs">
            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-lg border border-blue-100">
                🚉
            </div>
            <div>
                <div class="text-xs text-slate-400 font-semibold">Stasiun Tercatat</div>
                <div class="text-lg font-extrabold text-slate-900">{{ $uniqueStationsCount }} Stasiun Berbeda</div>
            </div>
        </div>

        <div class="bg-white border border-slate-200 rounded-2xl p-4 flex items-center gap-3 shadow-2xs">
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-lg border border-emerald-100">
                🛡️
            </div>
            <div>
                <div class="text-xs text-slate-400 font-semibold">Privasi Terjamin</div>
                <div class="text-xs font-bold text-emerald-700">Hanya Terlihat Oleh Anda</div>
            </div>
        </div>
    </div>

    <!-- Notes List -->
    @if($notes->count())
        <div class="space-y-4">
            @foreach($notes as $note)
                @php $meta = $note->station->line_meta; @endphp
                <article class="bg-white border border-slate-200 rounded-2xl p-5 shadow-2xs hover:border-slate-300 transition-all flex flex-col sm:flex-row sm:items-start justify-between gap-4">
                    
                    <div class="space-y-2.5 flex-1">
                        
                        <!-- Station & Line Badges -->
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="font-mono-sign text-xs font-bold px-2 py-0.5 rounded bg-slate-900 text-white">
                                {{ $note->station->code ?? 'KRL' }}
                            </span>
                            <span class="text-xs font-bold px-2 py-0.5 rounded {{ $meta['badge_bg'] }}">
                                {{ $note->station->line_name }}
                            </span>
                            <span class="text-xs font-extrabold text-slate-900">
                                {{ $note->station->name }}
                            </span>
                            <span class="text-slate-300">•</span>
                            <span class="text-xs text-slate-500">
                                {{ $note->station->city }}
                            </span>
                        </div>

                        <!-- Category & Rating -->
                        <div class="flex items-center gap-3">
                            <span class="inline-flex items-center text-[10px] font-bold px-2.5 py-0.5 rounded-md bg-amber-50 text-amber-800 border border-amber-200">
                                {{ $note->category }}
                            </span>

                            @if($note->rating)
                                <span class="text-xs text-amber-500 font-bold">
                                    {{ str_repeat('★', $note->rating) }} ({{ $note->rating }}/5)
                                </span>
                            @endif

                            <span class="text-[11px] text-slate-400">
                                Ditulis {{ $note->created_at->format('d M Y, H:i') }} WIB
                            </span>
                        </div>

                        <!-- Content Note -->
                        <p class="text-xs text-slate-700 leading-relaxed whitespace-pre-line bg-slate-50/70 p-3.5 rounded-xl border border-slate-100">
                            {{ $note->content }}
                        </p>

                    </div>

                    <!-- Station Link -->
                    <div class="sm:text-right shrink-0">
                        <a href="{{ route('stations.show', $note->station) }}"
                           class="inline-flex items-center gap-1 text-xs font-bold text-red-600 hover:text-red-700 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-xl transition-colors">
                            <span>Buka Stasiun</span>
                            <span>→</span>
                        </a>
                    </div>

                </article>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $notes->links() }}
        </div>
    @else
        <!-- Zero Notes State -->
        <div class="bg-white border border-slate-200 rounded-3xl p-12 text-center max-w-md mx-auto shadow-2xs">
            <div class="w-16 h-16 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center mx-auto mb-4 text-2xl border border-amber-100">
                📔
            </div>
            <h3 class="text-base font-bold text-slate-900">
                Buku Saku Masih Kosong
            </h3>
            <p class="text-xs text-slate-500 mt-1.5 leading-relaxed">
                Anda belum menyimpan catatan privat stasiun. Kunjungi stasiun yang sering Anda lalui dan simpan tips pribadi Anda!
            </p>
            <div class="mt-6">
                <a href="{{ route('home') }}"
                   class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white text-xs font-bold px-5 py-2.5 rounded-xl transition-colors shadow-sm">
                    Eksplor 100 Stasiun KRL
                </a>
            </div>
        </div>
    @endif

</div>

@endsection
