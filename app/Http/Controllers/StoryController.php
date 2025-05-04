<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Story;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use App\Services\CloudinaryService;
use Illuminate\Support\Facades\Auth;

class StoryController extends Controller
{
    public function index(Request $request)
    {
        $page = $request->query('page', 1);
        $size = $request->query('size', 10);

        $stories = Story::with('user')
            ->paginate($size, ['*'], 'page', $page);

        return response()->json($stories);
    }

    public function store(Request $request, CloudinaryService $cloudinaryService)
    {
        $validated = $request->validate([
            'description' => 'required|string',
            'namatempat' => 'required|string',
            'photo' => 'required|string',
            'lat' => 'nullable|numeric',
            'lon' => 'nullable|numeric'
        ]);


        $story = Story::create([
            'description' => $validated['description'],
            'namatempat' => $validated['namatempat'],
            'user_id' => Auth::user()->id,

            'latitude' => $validated['lat'] ?? null,
            'longitude' => $validated['lon'] ?? null
        ]);

        return response()->json([
            'message' => 'Story created successfully',
            'data' => $story
        ], 201);
    }


    public function storiesWithLocation()
    {
        $stories = Story::whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->with('user')
            ->get();

        return response()->json($stories);
    }
}
