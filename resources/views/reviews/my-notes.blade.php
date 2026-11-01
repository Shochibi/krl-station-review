@extends('layouts.app')

@section('title', 'My Private Notes')

@section('content')

<div class="max-w-5xl mx-auto px-5 py-12">

    <div class="mb-9">

        <h1 class="text-3xl font-extrabold">
            🔒 My Private Notes
        </h1>

        <p class="text-gray-500 mt-2">
            Your personal KRL station journal.
        </p>

    </div>


    <div class="bg-amber-50 border border-amber-200
                rounded-xl p-5 mb-8">

        <p class="text-sm text-amber-800">

            🔒 These notes are private and can only
            be accessed by your account.

        </p>

    </div>


    @forelse($notes as $note)

        <article class="bg-white border rounded-2xl
                        p-6 mb-5">

            <div class="flex flex-col sm:flex-row
                        justify-between gap-4">

                <div>

                    <span class="text-xs text-red-600 font-bold">
                        {{ $note->station->line_name }}
                    </span>

                    <h2 class="text-xl font-extrabold mt-2">
                        {{ $note->station->name }}
                    </h2>

                    <p class="text-sm text-gray-500 mt-1">
                        📍 {{ $note->station->city }}
                    </p>

                </div>


                <div class="sm:text-right">

                    <span class="bg-amber-100 text-amber-800
                                 px-3 py-1 rounded-full
                                 text-xs font-bold">

                        🔒 Private

                    </span>

                    <p class="text-xs text-gray-400 mt-3">
                        {{ $note->created_at->format('d M Y, H:i') }}
                    </p>

                </div>

            </div>


            <div class="border-t mt-5 pt-5">

                <span class="bg-gray-100 text-gray-600
                             px-3 py-1 rounded-full
                             text-xs font-bold">

                    {{ $note->category }}

                </span>


                @if($note->rating !== null)

                    <p class="text-yellow-500 font-bold mt-4">
                        {{ str_repeat('★', $note->rating) }}
                        {{ $note->rating }}/5
                    </p>

                @endif


                <p class="text-gray-600 mt-4
                          whitespace-pre-line">

                    {{ $note->content }}

                </p>

            </div>


            <a href="{{ route('stations.show', $note->station) }}"
               class="inline-block text-red-600
                      font-bold text-sm mt-5">

                View Station →

            </a>

        </article>

    @empty

        <div class="bg-white border rounded-2xl
                    p-12 text-center">

            <div class="text-5xl">📝</div>

            <h2 class="text-xl font-bold mt-5">
                No Private Notes Yet
            </h2>

            <p class="text-gray-500 mt-2">
                Start saving your personal KRL experiences.
            </p>

            <a href="{{ route('home') }}"
               class="inline-block bg-red-600
                      text-white px-6 py-3 rounded-xl
                      font-bold mt-6">

                Explore Stations

            </a>

        </div>

    @endforelse


    <div class="mt-8">
        {{ $notes->links() }}
    </div>

</div>

@endsection