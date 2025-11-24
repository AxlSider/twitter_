<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TweetController extends Controller
{
    // 1. Show the Feed (Index)
public function index()
    {
        return view('tweets.index', [
            // 'withCount' adds a 'likes_count' variable to each tweet automatically
            'tweets' => Tweet::with('user', 'likes')->withCount('likes')->latest()->get(),
        ]);
    }

    // 2. Save a New Tweet (Store)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'message' => 'required|string|max:280',
        ]);

        $request->user()->tweets()->create($validated);

        return redirect(route('tweets.index'));
    }

    // 3. Show Edit Screen
    public function edit(Tweet $tweet)
    {
        Gate::authorize('update', $tweet);

        return view('tweets.edit', [
            'tweet' => $tweet,
        ]);
    }

    // 4. Update the Tweet
    public function update(Request $request, Tweet $tweet)
    {
        Gate::authorize('update', $tweet);

        $validated = $request->validate([
            'message' => 'required|string|max:280',
        ]);

        $tweet->update($validated);

        return redirect(route('tweets.index'));
    }

    // 5. Delete the Tweet
    public function destroy(Tweet $tweet)
    {
        Gate::authorize('delete', $tweet);

        $tweet->delete();

        return redirect(route('tweets.index'));
    } // <--- This bracket was missing or misplaced in your code

// 6. Toggle Like (AJAX Version)
    public function like(Tweet $tweet)
    {
        $user = auth()->user();
        $existingLike = $tweet->likes()->where('user_id', $user->id)->first();
        $liked = false;

        if ($existingLike) {
            $existingLike->delete(); // Unlike
            $liked = false;
        } else {
            $tweet->likes()->create(['user_id' => $user->id]); // Like
            $liked = true;
        }

        // IMPORTANT: This must return JSON, not "back()"
        return response()->json([
            'liked' => $liked,
            'likes_count' => $tweet->likes()->count(),
        ]);
    }
}