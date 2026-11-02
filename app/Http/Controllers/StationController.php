<?php

namespace App\Http\Controllers;

use App\Models\Station;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StationController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $selectedLine = $request->query('line');
        $selectedCity = $request->query('city');
        $transitOnly = $request->boolean('transit');
        $sort = $request->query('sort', 'name');

        // Query Stasiun
        $query = Station::query()
            ->withAvg('publicReviews', 'rating')
            ->withCount('publicReviews');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%")
                    ->orWhere('line_name', 'like', "%{$search}%")
                    ->orWhere('city', 'like', "%{$search}%");
            });
        }

        if ($selectedLine) {
            $query->where('line_name', $selectedLine);
        }

        if ($selectedCity) {
            $query->where('city', $selectedCity);
        }

        if ($transitOnly) {
            $query->where('is_transit', true);
        }

        // Sorting
        match ($sort) {
            'rating' => $query->orderByDesc('public_reviews_avg_rating')->orderBy('name'),
            'reviews' => $query->orderByDesc('public_reviews_count')->orderBy('name'),
            default => $query->orderBy('name'),
        };

        $stations = $query->paginate(12)->withQueryString();

        // Line counts for quick filter tabs
        $lineCounts = Station::query()
            ->select('line_name', DB::raw('count(*) as total'))
            ->groupBy('line_name')
            ->pluck('total', 'line_name');

        // Total summary stats
        $totalStations = Station::count();
        $totalTransit = Station::where('is_transit', true)->count();
        $allCities = Station::select('city')->distinct()->orderBy('city')->pluck('city');

        return view('stations.index', compact(
            'stations',
            'search',
            'selectedLine',
            'selectedCity',
            'transitOnly',
            'sort',
            'lineCounts',
            'totalStations',
            'totalTransit',
            'allCities'
        ));
    }

    public function show(Station $station)
    {
        $station->loadAvg('publicReviews', 'rating')
            ->loadCount('publicReviews');

        // Review publik dengan pagination
        $reviews = $station->publicReviews()
            ->with('user')
            ->latest('created_at')
            ->paginate(10);

        // Rating breakdown per bintang (1-5)
        $ratingCounts = $station->publicReviews()
            ->select('rating', DB::raw('count(*) as count'))
            ->groupBy('rating')
            ->pluck('count', 'rating');

        // Private notes untuk user login
        $myPrivateNotes = collect();
        if (auth()->check()) {
            $myPrivateNotes = $station->reviews()
                ->private()
                ->where('user_id', auth()->id())
                ->latest('created_at')
                ->get();
        }

        // Stasiun lain di lin yang sama untuk navigasi cepat
        $sameLineStations = Station::where('line_name', $station->line_name)
            ->where('id', '!=', $station->id)
            ->orderBy('name')
            ->take(6)
            ->get();

        return view('stations.show', compact(
            'station',
            'reviews',
            'myPrivateNotes',
            'ratingCounts',
            'sameLineStations'
        ));
    }
}
