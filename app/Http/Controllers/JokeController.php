<?php

namespace App\Http\Controllers;

use App\Models\Joke;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class JokeController extends Controller
{
    public function home() {
        return view('home');
    }

    public function getJoke() {
        $response = Http::get('https://v2.jokeapi.dev/joke/Any');
        return response()->json($response->json());
    }

    public function save(Request $request) {
        $validated = $request->validate([
            'type' => 'required|string|in:single,twopart',
            'joke' => 'nullable|string',
            'setup' => 'nullable|string',
            'delivery' => 'nullable|string',
        ]);

        // Check for duplicate jokes before saving
        $exists = Joke::where('type', $validated['type'])
            ->where(function ($query) use ($validated) {
                if ($validated['type'] === 'single') {
                    $query->where('joke', $validated['joke']);
                } else {
                    $query->where('setup', $validated['setup'])
                          ->where('delivery', $validated['delivery']);
                }
            })->exists();

        if ($exists) {
            return response()->json(['message' => 'This joke is already saved!'], 409);
        }

        try {
            Joke::create($validated);
            return response()->json(['message' => 'Joke saved successfully!'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to save joke'], 500);
        }
    }

    public function saved() {
        $jokes = Joke::all();
        return view('saved', compact('jokes'));
    }

    public function search(Request $request) {
        $query = $request->input('query');

        $jokes = Joke::where('joke', 'like', "%$query%")
            ->orWhere('setup', 'like', "%$query%")
            ->orWhere('delivery', 'like', "%$query%")
            ->paginate(10);

        return view('jokes.search', compact('jokes', 'query'));
    }
}
