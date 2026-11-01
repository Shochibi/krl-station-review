@extends('layouts.app')

@section('title', 'Explore Stations - KRL Review')

@section('content')

<!-- Hero -->
<section class="bg-gray-950 text-white">

    <div class="max-w-7xl mx-auto px-5 py-20 md:py-28">

        <div class="max-w-3xl">

            <span class="bg-red-600/20 text-red-400
                         px-4 py-2 rounded-full text-sm font-bold">
                KRL Commuter Line Community
            </span>

            <h1 class="text-4xl md:text-6xl
                       font-extrabold leading-tight mt-7">

                Every Station Has
                <span class="text-red-500">A Story.</span>

            </h1>

            <p class="text-gray-400 text-lg mt-5">
                Discover station experiences, share useful tips,
                and help fellow commuters travel better.
            </p>


            <!-- Search -->
            <form action="{{ route('home') }}"
                  method="GET"
                  class="mt-9 flex flex-col sm:flex-row gap-3">

                <input
                    type="text"
                    name="search"
                    value="{{ $search }}"
                    placeholder="Search station or KRL line..."
                    class="flex-1 px-5 py-4 rounded-xl
                           bg-white text-gray-900 outline-none
                           focus:ring-2 focus:ring-red-500"
                >

                <button
                    type="submit"
                    class="bg-red-600 hover:bg-red-700
                           px-8 py-4 rounded-xl font-bold">

                    Search

                </button>

            </form>

        </div>

    </div>

</section>


<!-- Stations -->
<section class="max-w-7xl mx-auto px-5 py-16">

    <div class="mb-9">

        <p class="text-red-600 text-sm font-bold">
            EXPLORE
        </p>

        <h2 class="text-3xl font-extrabold mt-2">
            Popular Stations
        </h2>

        <p class="text-gray-500 mt-2">
            Discover information and commuter reviews.
        </p>

    </div>


    @if($stations->count())

        <div class="grid grid-cols-1 sm:grid-cols-2
                    lg:grid-cols-4 gap-6">

            @foreach($stations as $station)

                <a href="{{ route('stations.show', $station) }}"
                   class="bg-white rounded-2xl overflow-hidden
                          border border-gray-200
                          hover:shadow-xl hover:-translate-y-1
                          transition duration-300">

                    <div class="h-48 bg-gray-200">

                        @if($station->image_url)

                            <img
                                src="{{ $station->image_url }}"
                                alt="{{ $station->name }}"
                                class="w-full h-full object-cover"
                            >

                        @else

                            <div class="w-full h-full
                                        bg-gradient-to-br
                                        from-red-700 to-gray-950
                                        flex items-center justify-center">

                                <span class="text-5xl">🚆</span>

                            </div>

                        @endif

                    </div>


                    <div class="p-5">

                        <span class="text-xs font-bold
                                     text-red-600 bg-red-50
                                     px-3 py-1 rounded-full">

                            {{ $station->line_name }}

                        </span>

                        <h3 class="text-xl font-bold mt-4">
                            {{ $station->name }}
                        </h3>

                        <p class="text-sm text-gray-500 mt-1">
                            {{ $station->city }}
                        </p>


                        <div class="flex justify-between
                                    items-center mt-5">

                            <span class="font-bold">

                                ⭐

                                {{ $station->public_reviews_avg_rating !== null
                                    ? number_format($station->public_reviews_avg_rating, 1)
                                    : 'N/A' }}

                            </span>

                            <span class="text-xs text-gray-500">

                                {{ $station->public_reviews_count }} reviews

                            </span>

                        </div>

                    </div>

                </a>

            @endforeach

        </div>


        <div class="mt-10">
            {{ $stations->links() }}
        </div>

    @else

        <div class="bg-white border rounded-2xl
                    p-12 text-center">

            <div class="text-5xl">🚉</div>

            <h3 class="font-bold text-xl mt-4">
                No Stations Found
            </h3>

            <p class="text-gray-500 mt-2">
                Try another search keyword.
            </p>

            <a href="{{ route('home') }}"
               class="inline-block text-red-600
                      font-bold mt-5">

                Clear Search

            </a>

        </div>

    @endif

</section>

@endsection