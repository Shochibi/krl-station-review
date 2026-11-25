<?php

namespace App\Http\Controllers;

use App\Models\Review;
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
            ->where('is_active', true)
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
            'rating' => $query->orderByDesc(
                Review::selectRaw('COALESCE(AVG(rating), 0)')
                    ->whereColumn('station_id', 'stations.id')
                    ->where('is_private', false)
            )->orderBy('name'),
            'reviews' => $query->orderByDesc('public_reviews_count')->orderBy('name'),
            default => $query->orderBy('name'),
        };

        $stations = $query->paginate(12)->withQueryString();

        // Line counts for quick filter tabs
        $lineCounts = Station::query()
            ->where('is_active', true)
            ->select('line_name', DB::raw('count(*) as total'))
            ->groupBy('line_name')
            ->pluck('total', 'line_name');

        // Total summary stats (calculated dynamically from database)
        $totalStations = Station::count();
        $totalActive = Station::where('is_active', true)->count();
        $totalTransit = Station::where('is_active', true)->where('is_transit', true)->count();
        $totalLines = Station::where('is_active', true)->distinct('line_name')->count('line_name');
        $totalReviews = Review::where('is_private', false)->count();
        $operatingPercentage = $totalStations > 0 ? round(($totalActive / $totalStations) * 100) : 0;
        $allCities = Station::where('is_active', true)
            ->select('city')
            ->distinct()
            ->orderBy('city')
            ->pluck('city');

        return view('stations.index', compact(
            'stations',
            'search',
            'selectedLine',
            'selectedCity',
            'transitOnly',
            'sort',
            'lineCounts',
            'totalStations',
            'totalActive',
            'totalTransit',
            'totalLines',
            'totalReviews',
            'operatingPercentage',
            'allCities'
        ));
    }

    public function show(Request $request, Station $station)
    {
        abort_unless($station->is_active, 404);

        $selectedCategory = $request->query('category');
        $allowedCategories = ReviewController::CATEGORIES;
        if ($selectedCategory && ! in_array($selectedCategory, $allowedCategories, true)) {
            $selectedCategory = null;
        }

        $station->loadAvg('publicReviews', 'rating')
            ->loadCount('publicReviews');

        // Review publik dengan filter kategori & pagination
        $reviewsQuery = $station->publicReviews()
            ->with('user')
            ->latest('created_at');

        if ($selectedCategory) {
            $reviewsQuery->where('category', $selectedCategory);
        }

        $reviews = $reviewsQuery->paginate(10)->withQueryString();

        // Rating breakdown per bintang (1-5)
        $ratingCounts = $station->publicReviews()
            ->whereNotNull('rating')
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
            ->where('is_active', true)
            ->where('id', '!=', $station->id)
            ->orderBy('name')
            ->take(6)
            ->get();

        return view('stations.show', compact(
            'station',
            'reviews',
            'myPrivateNotes',
            'ratingCounts',
            'sameLineStations',
            'selectedCategory',
            'allowedCategories'
        ));
    }
}
