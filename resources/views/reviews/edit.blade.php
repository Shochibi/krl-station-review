@extends('layouts.app')

@section('title', $review->is_private ? 'Edit Catatan Pribadi' : 'Edit Ulasan')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 py-10">
    <a href="{{ $review->is_private ? route('reviews.my-notes') : route('stations.show', $review->station) }}"
       class="text-sm font-semibold text-slate-600 hover:text-red-600">
        ← Kembali
    </a>

    <div class="mt-5 rounded-3xl border border-slate-200 bg-white p-6 sm:p-8 shadow-sm">
        <h1 class="text-2xl font-extrabold text-slate-900">
            {{ $review->is_private ? 'Edit Catatan Pribadi' : 'Edit Ulasan Stasiun' }}
        </h1>
        <p class="mt-1 text-sm text-slate-500">
            {{ $review->station->name }} · {{ $review->station->line_name }}
        </p>

        @if($errors->any())
            <div role="alert" class="mt-5 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-800">
                <ul class="list-disc space-y-1 pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('reviews.update', $review) }}" method="POST" class="mt-6 space-y-5"
              @if(!$review->is_private) x-data="{ rating: '{{ old('rating', $review->rating ?? 5) }}' }" @endif>
            @csrf
            @method('PUT')

            @if(!$review->is_private)
                <fieldset>
                    <div class="flex items-center justify-between mb-2">
                        <legend class="text-sm font-bold text-slate-700">Rating</legend>
                        <span class="text-xs font-bold text-amber-600" x-text="rating + ' Bintang'"></span>
                    </div>
                    <div class="flex gap-2">
                        @for($rating = 1; $rating <= 5; $rating++)
                            <label class="cursor-pointer">
                                <input type="radio" name="rating" value="{{ $rating }}" class="sr-only" x-model="rating"
                                       @checked((string) old('rating', $review->rating) === (string) $rating)>
                                <span class="inline-flex h-11 w-11 items-center justify-center rounded-xl border text-xl transition-all"
                                      :class="rating >= {{ $rating }} ? 'border-amber-300 bg-amber-50 text-amber-500' : 'border-slate-200 bg-slate-50 text-slate-300'">
                                    ★
                                </span>
                            </label>
                        @endfor
                    </div>
                </fieldset>
            @endif

            <div>
                <label for="category" class="mb-2 block text-sm font-bold text-slate-700">Kategori</label>
                <select id="category" name="category" required
                        class="w-full rounded-xl border-slate-300 text-sm focus:border-red-500 focus:ring-red-500">
                    @foreach([
                        'Fasilitas' => 'Fasilitas & Kenyamanan',
                        'Keramaian' => 'Keramaian & Jam Padat',
                        'Kuliner' => 'Kuliner & Tempat Kopi',
                        'Tips Transit' => 'Tips Transit & Posisi Gerbong',
                        'Kebersihan' => 'Kebersihan Toilet & Peron',
                        'Keamanan' => 'Keamanan & Parkir Kendaraan',
                    ] as $value => $label)
                        <option value="{{ $value }}" @selected(old('category', $review->category) === $value)>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="content" class="mb-2 block text-sm font-bold text-slate-700">Isi</label>
                <textarea id="content" name="content" rows="6" minlength="5" maxlength="2000" required
                          class="w-full rounded-xl border-slate-300 text-sm focus:border-red-500 focus:ring-red-500">{{ old('content', $review->content) }}</textarea>
                <p class="mt-1 text-xs text-slate-500">Minimal 5 dan maksimal 2000 karakter.</p>
            </div>

            <div class="flex flex-wrap gap-3">
                <button type="submit"
                        class="rounded-xl bg-red-600 px-5 py-3 text-sm font-bold text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                    Simpan Perubahan
                </button>
                <a href="{{ $review->is_private ? route('reviews.my-notes') : route('stations.show', $review->station) }}"
                   class="rounded-xl border border-slate-300 px-5 py-3 text-sm font-bold text-slate-700 hover:bg-slate-50">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
