<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">
                    Dashboard Komuter
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">
                    Selamat datang kembali, {{ auth()->user()->name }}. Pantau ulasan dan catatan pribadi Anda di sini.
                </p>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('home') }}"
                   class="px-4 py-2 rounded-xl text-xs font-bold bg-red-600 hover:bg-red-700 text-white transition-colors">
                    Eksplor Stasiun
                </a>
                <a href="{{ route('reviews.my-notes') }}"
                   class="px-4 py-2 rounded-xl text-xs font-bold bg-amber-50 hover:bg-amber-100 text-amber-900 border border-amber-200 transition-colors">
                    Buku Saku Komuter
                </a>
                <a href="{{ route('profile.edit') }}"
                   class="px-4 py-2 rounded-xl text-xs font-bold bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 transition-colors">
                    Pengaturan Profil
                </a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-8 space-y-8">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-2xs">
                <div class="text-xs font-semibold text-slate-500">Ulasan Publik Saya</div>
                <div class="text-2xl font-extrabold text-slate-900 mt-1">{{ $publicReviewsCount }} Ulasan</div>
                <p class="text-xs text-slate-500 mt-1">Kontribusi untuk sesama komuter KRL.</p>
            </div>

            <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-2xs">
                <div class="text-xs font-semibold text-slate-500">Buku Saku (Privat)</div>
                <div class="text-2xl font-extrabold text-amber-700 mt-1">{{ $privateNotesCount }} Catatan</div>
                <p class="text-xs text-slate-500 mt-1">Hanya dapat diakses oleh akun Anda.</p>
            </div>

            <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-2xs">
                <div class="text-xs font-semibold text-slate-500">Status Akun</div>
                <div class="text-lg font-extrabold text-emerald-700 mt-1">
                    {{ auth()->user()->isAdmin() ? 'Admin Komunitas' : 'Anggota Komuter' }}
                </div>
                <p class="text-xs text-slate-500 mt-1 truncate">{{ auth()->user()->email }}</p>
            </div>
        </div>

        <section class="bg-white border border-slate-200 rounded-3xl p-6 shadow-2xs">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-base font-extrabold text-slate-900">Aktivitas Ulasan &amp; Catatan Terbaru</h2>
                <a href="{{ route('reviews.my-notes') }}" class="text-xs font-bold text-red-600 hover:text-red-700">
                    Lihat Buku Saku →
                </a>
            </div>

            @if($recentReviews->isNotEmpty())
                <div class="space-y-3">
                    @foreach($recentReviews as $item)
                        <div class="p-4 rounded-2xl border border-slate-200/80 bg-slate-50/60 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                            <div class="flex items-start gap-3">
                                @if($item->station->image_url)
                                    <img src="{{ $item->station->image_url }}"
                                         alt="Stasiun {{ $item->station->name }}"
                                         loading="lazy"
                                         referrerpolicy="no-referrer"
                                         class="w-16 h-12 rounded-xl object-cover border border-slate-200 shrink-0 hidden sm:block">
                                @endif
                                <div class="space-y-1">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <span class="text-xs font-bold px-2 py-0.5 rounded {{ $item->is_private ? 'bg-amber-100 text-amber-800' : 'bg-blue-50 text-blue-700' }}">
                                            {{ $item->is_private ? '🔒 Catatan Privat' : '🌐 Ulasan Publik' }}
                                        </span>
                                        <span class="text-xs font-bold text-slate-900">{{ $item->station->name }}</span>
                                        <span class="text-xs text-slate-500">• {{ $item->category }}</span>
                                        @if($item->rating)
                                            <span class="text-xs font-bold text-amber-600">★ {{ $item->rating }}/5</span>
                                        @endif
                                    </div>
                                    <p class="text-xs text-slate-600 line-clamp-2">{{ $item->content }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 shrink-0">
                                <a href="{{ route('stations.show', $item->station) }}" class="text-xs font-bold text-red-600 hover:text-red-700">
                                    Buka Stasiun
                                </a>
                                <a href="{{ route('reviews.edit', $item) }}" class="text-xs font-bold text-blue-700 hover:text-blue-900">
                                    Edit
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-xs text-slate-500">
                    Belum ada ulasan atau catatan pribadi. Mulai jelajahi direktori stasiun untuk menambahkan catatan pertama Anda!
                </p>
            @endif
        </section>
    </div>
</x-app-layout>
