<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Station;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\RequiredIf;

class ReviewController extends Controller
{
    public function store(Request $request, Station $station)
    {
        $isPrivate = $request->boolean('is_private');

        $validated = $request->validate([
            'rating' => [
                new RequiredIf(! $isPrivate),
                'nullable',
                'integer',
                'between:1,5',
            ],

            'category' => [
                'required',
                Rule::in([
                    'Fasilitas',
                    'Keramaian',
                    'Kuliner',
                    'Tips Transit',
                    'Kebersihan',
                    'Keamanan',
                ]),
            ],

            'content' => [
                'required',
                'string',
                'min:10',
                'max:2000',
            ],
        ]);

        $station->reviews()->create([
            'user_id' => $request->user()->id,
            'rating' => $validated['rating'] ?? null,
            'category' => $validated['category'],
            'content' => $validated['content'],
            'is_private' => $isPrivate,
        ]);

        return redirect()
            ->route('stations.show', $station)
            ->with(
                'success',
                $isPrivate
                    ? 'Catatan privat berhasil disimpan!'
                    : 'Ulasan publik berhasil dipublikasikan!'
            );
    }

    public function myNotes(Request $request)
    {
        $notes = $request->user()
            ->privateNotes()
            ->with('station')
            ->latest('created_at')
            ->paginate(10);

        return view('reviews.my-notes', compact('notes'));
    }
}