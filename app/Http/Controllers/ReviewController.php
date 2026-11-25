<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Station;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\RequiredIf;

class ReviewController extends Controller
{
    public const CATEGORIES = [
        'Fasilitas',
        'Keramaian',
        'Kuliner',
        'Tips Transit',
        'Kebersihan',
        'Keamanan',
    ];

    public function store(Request $request, Station $station)
    {
        abort_unless($station->is_active, 404);

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
                Rule::in(self::CATEGORIES),
            ],

            'content' => [
                'required',
                'string',
                'min:5',
                'max:2000',
            ],
        ]);

        $station->reviews()->create([
            'user_id' => $request->user()->id,
            'rating' => $isPrivate ? null : ($validated['rating'] ?? null),
            'category' => $validated['category'],
            'content' => $validated['content'],
            'is_private' => $isPrivate,
        ]);

        return redirect()
            ->route('stations.show', $station)
            ->with(
                'success',
                $isPrivate
                    ? 'Catatan privat berhasil disimpan ke Buku Saku Komuter Anda!'
                    : 'Ulasan publik berhasil dibagikan ke komunitas komuter!'
            );
    }

    public function edit(Review $review)
    {
        Gate::authorize('update', $review);

        $review->load('station');

        return view('reviews.edit', compact('review'));
    }

    public function update(Request $request, Review $review)
    {
        Gate::authorize('update', $review);

        $isPrivate = $review->is_private;

        $validated = $request->validate([
            'rating' => [
                new RequiredIf(! $isPrivate),
                'nullable',
                'integer',
                'between:1,5',
            ],

            'category' => [
                'required',
                Rule::in(self::CATEGORIES),
            ],

            'content' => [
                'required',
                'string',
                'min:5',
                'max:2000',
            ],
        ]);

        $review->update([
            'rating' => $isPrivate ? null : ($validated['rating'] ?? null),
            'category' => $validated['category'],
            'content' => $validated['content'],
            'is_private' => $isPrivate,
        ]);

        $redirectRoute = $isPrivate
            ? route('reviews.my-notes')
            : route('stations.show', $review->station_id);

        return redirect($redirectRoute)->with(
            'success',
            $isPrivate
                ? 'Catatan privat berhasil diperbarui!'
                : 'Ulasan stasiun berhasil diperbarui!'
        );
    }

    public function destroy(Request $request, Review $review)
    {
        Gate::authorize('delete', $review);

        $station = $review->station;
        $isPrivate = $review->is_private;

        $review->delete();

        $message = $isPrivate
            ? 'Catatan privat berhasil dihapus dari Buku Saku Komuter.'
            : 'Ulasan publik berhasil dihapus.';

        $redirectRoute = $isPrivate
            ? route('reviews.my-notes')
            : route('stations.show', $station);

        return redirect($redirectRoute)->with('success', $message);
    }

    public function myNotes(Request $request)
    {
        $search = trim((string) $request->query('search', ''));
        $selectedCategory = $request->query('category');
        $categories = self::CATEGORIES;

        if ($selectedCategory && ! in_array($selectedCategory, $categories, true)) {
            $selectedCategory = null;
        }

        $notesQuery = $request->user()
            ->privateNotes()
            ->with('station')
            ->latest('created_at');

        if ($search !== '') {
            $notesQuery->where(function ($q) use ($search) {
                $q->where('content', 'like', "%{$search}%")
                    ->orWhereHas('station', function ($sq) use ($search) {
                        $sq->where('name', 'like', "%{$search}%")
                            ->orWhere('code', 'like', "%{$search}%");
                    });
            });
        }

        if ($selectedCategory) {
            $notesQuery->where('category', $selectedCategory);
        }

        $notes = $notesQuery->paginate(10)->withQueryString();

        $totalNotes = $request->user()->privateNotes()->count();
        $uniqueStationsCount = $request->user()->privateNotes()->distinct('station_id')->count('station_id');

        return view('reviews.my-notes', compact(
            'notes',
            'totalNotes',
            'uniqueStationsCount',
            'search',
            'selectedCategory',
            'categories'
        ));
    }
}
