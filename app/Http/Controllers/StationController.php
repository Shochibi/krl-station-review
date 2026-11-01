<?php

namespace App\Http\Controllers;

use App\Models\Station;
use Illuminate\Http\Request;

class StationController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $stations = Station::query()
            ->withAvg('publicReviews', 'rating')
            ->withCount('publicReviews')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('line_name', 'like', "%{$search}%")
                        ->orWhere('city', 'like', "%{$search}%");
                });
            })
            ->orderBy('name')
            ->paginate(8)
            ->withQueryString();

        return view('stations.index', compact(
            'stations',
            'search'
        ));
    }

    public function show(Station $station)
    {
        $station->loadAvg('publicReviews', 'rating')
            ->loadCount('publicReviews');

        // Hanya review publik
        $reviews = $station->publicReviews()
            ->with('user')
            ->latest('created_at')
            ->paginate(10);

        // Default: tidak ada private notes untuk guest
        $myPrivateNotes = collect();

        if (auth()->check()) {
            $myPrivateNotes = $station->reviews()
                ->private()
                ->where('user_id', auth()->id())
                ->latest('created_at')
                ->get();
        }

        return view('stations.show', compact(
            'station',
            'reviews',
            'myPrivateNotes'
        ));
    }
}