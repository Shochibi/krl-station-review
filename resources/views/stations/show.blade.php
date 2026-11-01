@extends('layouts.app')

@section('title', $station->name . ' - KRL Review')

@section('content')

<div class="max-w-5xl mx-auto px-5 py-12">

    <!-- Back -->
    <a href="{{ route('home') }}"
       class="text-gray-500 hover:text-red-600 text-sm">

        ← Back to Stations

    </a>


    <!-- Station Information -->
    <div class="bg-white border rounded-2xl
                overflow-hidden mt-6">

        <div class="h-64 bg-gray-200">

            @if($station->image_url)

                <img src="{{ $station->image_url }}"
                     class="w-full h-full object-cover"
                     alt="{{ $station->name }}">

            @else

                <div class="w-full h-full bg-gradient-to-br
                            from-red-700 to-gray-950
                            flex items-center justify-center">

                    <span class="text-7xl">🚆</span>

                </div>

            @endif

        </div>


        <div class="p-7">

            <span class="text-sm text-red-600 font-bold">
                {{ $station->line_name }}
            </span>

            <h1 class="text-3xl font-extrabold mt-2">
                {{ $station->name }}
            </h1>

            <p class="text-gray-500 mt-2">
                📍 {{ $station->city }}
            </p>


            <div class="flex gap-12 mt-7">

                <div>

                    <p class="text-sm text-gray-400">
                        Average Rating
                    </p>

                    <p class="text-2xl font-extrabold mt-1">

                        ⭐

                        {{ $station->public_reviews_avg_rating !== null
                            ? number_format($station->public_reviews_avg_rating, 1)
                            : 'N/A' }}

                        <span class="text-sm text-gray-400">
                            / 5
                        </span>

                    </p>

                </div>


                <div>

                    <p class="text-sm text-gray-400">
                        Public Reviews
                    </p>

                    <p class="text-2xl font-extrabold mt-1">
                        {{ $station->public_reviews_count }}
                    </p>

                </div>

            </div>

        </div>

    </div>


    <!-- Success -->
    @if(session('success'))

        <div class="bg-green-50 border border-green-200
                    text-green-700 p-4 rounded-xl mt-8">

            {{ session('success') }}

        </div>

    @endif


    <!-- Errors -->
    @if($errors->any())

        <div class="bg-red-50 border border-red-200
                    text-red-700 p-4 rounded-xl mt-8">

            <ul class="list-disc pl-5">

                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            </ul>

        </div>

    @endif


    <!-- Form -->
    <section class="mt-12">

        <h2 class="text-2xl font-extrabold">
            Share Your Experience
        </h2>

        <p class="text-gray-500 mt-2">
            Write a public review or save a private note.
        </p>


        @auth

            <form action="{{ route('reviews.store', $station) }}"
                  method="POST"
                  class="bg-white border rounded-2xl
                         p-6 mt-6 space-y-5">

                @csrf


                <!-- Rating -->
                <div>

                    <label class="block font-semibold mb-2">
                        Rating
                    </label>

                    <select name="rating"
                            class="w-full border rounded-xl
                                   px-4 py-3 outline-none
                                   focus:ring-2 focus:ring-red-500">

                        <option value="">
                            Select rating
                        </option>

                        @for($i = 5; $i >= 1; $i--)

                            <option value="{{ $i }}"
                                @selected(old('rating') == $i)>

                                {{ $i }} - {{ str_repeat('★', $i) }}

                            </option>

                        @endfor

                    </select>

                    <p class="text-xs text-gray-400 mt-2">
                        Required for public reviews, optional for private notes.
                    </p>

                </div>


                <!-- Category -->
                <div>

                    <label class="block font-semibold mb-2">
                        Category
                    </label>

                    <select name="category"
                            required
                            class="w-full border rounded-xl
                                   px-4 py-3 outline-none
                                   focus:ring-2 focus:ring-red-500">

                        <option value="">Select category</option>

                        @foreach([
                            'Fasilitas',
                            'Keramaian',
                            'Kuliner',
                            'Tips Transit',
                            'Kebersihan',
                            'Keamanan'
                        ] as $category)

                            <option value="{{ $category }}"
                                @selected(old('category') == $category)>

                                {{ $category }}

                            </option>

                        @endforeach

                    </select>

                </div>


                <!-- Content -->
                <div>

                    <label class="block font-semibold mb-2">
                        Your Experience / Notes
                    </label>

                    <textarea name="content"
                              rows="5"
                              maxlength="2000"
                              required
                              placeholder="Write your experience..."
                              class="w-full border rounded-xl
                                     px-4 py-3 outline-none
                                     focus:ring-2 focus:ring-red-500">{{ old('content') }}</textarea>

                </div>


                <!-- Privacy -->
                <label class="flex gap-3 items-start
                              p-4 border rounded-xl
                              cursor-pointer hover:bg-gray-50">

                    <input type="checkbox"
                           name="is_private"
                           value="1"
                           @checked(old('is_private'))
                           class="w-5 h-5 mt-1 accent-red-600">

                    <div>

                        <p class="font-bold">
                            🔒 Simpan sebagai Catatan Privat
                        </p>

                        <p class="text-sm text-gray-500 mt-1">
                            Hanya kamu yang bisa melihat catatan ini.
                            Catatan tidak akan memengaruhi rating stasiun.
                        </p>

                    </div>

                </label>


                <button type="submit"
                        class="bg-red-600 hover:bg-red-700
                               text-white font-bold
                               px-7 py-3 rounded-xl">

                    Save Experience

                </button>

            </form>

        @else

            <div class="bg-gray-100 rounded-2xl
                        p-8 mt-6 text-center">

                <div class="text-4xl">🔐</div>

                <h3 class="font-bold text-lg mt-4">
                    Login to Share Your Experience
                </h3>

                <p class="text-gray-500 text-sm mt-2">
                    Login to create reviews and personal notes.
                </p>

                <div class="flex justify-center gap-3 mt-5">

                    <a href="{{ route('login') }}"
                       class="bg-red-600 text-white
                              px-5 py-3 rounded-xl font-bold">

                        Login

                    </a>

                    <a href="{{ route('register') }}"
                       class="border px-5 py-3 rounded-xl font-bold">

                        Register

                    </a>

                </div>

            </div>

        @endauth

    </section>


    <!-- Public Reviews -->
    <section class="mt-14">

        <h2 class="text-2xl font-extrabold">
            🌐 Public Reviews
        </h2>

        <p class="text-gray-500 mt-2">
            Experiences shared with the community.
        </p>


        <div class="mt-7 space-y-5">

            @forelse($reviews as $review)

                <article class="bg-white border
                                rounded-2xl p-6">

                    <div class="flex justify-between gap-3">

                        <div>

                            <h3 class="font-bold text-lg">
                                {{ $review->user->name }}
                            </h3>

                            <p class="text-xs text-gray-400 mt-1">
                                {{ $review->created_at->format('d M Y, H:i') }}
                            </p>

                        </div>

                        <span class="bg-green-50 text-green-700
                                     px-3 py-1 rounded-full
                                     text-xs font-bold">
                            🌐 Public
                        </span>

                    </div>


                    <p class="text-yellow-500 font-bold mt-4">

                        {{ str_repeat('★', $review->rating) }}

                        <span class="text-gray-700">
                            {{ $review->rating }}/5
                        </span>

                    </p>


                    <span class="inline-block bg-red-50
                                 text-red-600 text-xs
                                 font-bold px-3 py-1
                                 rounded-full mt-3">

                        {{ $review->category }}

                    </span>


                    <p class="text-gray-600 leading-relaxed
                              whitespace-pre-line mt-4">

                        {{ $review->content }}

                    </p>

                </article>

            @empty

                <div class="bg-white border rounded-2xl
                            p-10 text-center">

                    <div class="text-5xl">💬</div>

                    <h3 class="font-bold text-lg mt-4">
                        No Public Reviews Yet
                    </h3>

                    <p class="text-gray-500 mt-2">
                        Be the first to share your experience!
                    </p>

                </div>

            @endforelse

        </div>


        <div class="mt-8">
            {{ $reviews->links() }}
        </div>

    </section>


    <!-- Owner's Private Notes -->
    @auth

        @if($myPrivateNotes->isNotEmpty())

            <section class="mt-14">

                <h2 class="text-2xl font-extrabold">
                    🔒 My Private Notes
                </h2>

                <div class="mt-7 space-y-5">

                    @foreach($myPrivateNotes as $note)

                        <article class="bg-amber-50
                                        border border-amber-200
                                        rounded-2xl p-6">

                            <div class="flex justify-between">

                                <span class="font-bold text-amber-800">
                                    🔒 Private Note
                                </span>

                                <span class="text-xs text-gray-500">
                                    {{ $note->created_at->format('d M Y') }}
                                </span>

                            </div>


                            <span class="inline-block mt-4
                                         bg-amber-100 text-amber-800
                                         px-3 py-1 rounded-full text-xs">

                                {{ $note->category }}

                            </span>


                            @if($note->rating !== null)

                                <p class="text-yellow-500 font-bold mt-4">
                                    {{ str_repeat('★', $note->rating) }}
                                    {{ $note->rating }}/5
                                </p>

                            @endif


                            <p class="text-gray-700 mt-4
                                      whitespace-pre-line">

                                {{ $note->content }}

                            </p>

                        </article>

                    @endforeach

                </div>

                <a href="{{ route('reviews.my-notes') }}"
                   class="inline-block mt-5 text-red-600 font-bold">

                    View All My Notes →

                </a>

            </section>

        @endif

    @endauth

</div>

@endsection