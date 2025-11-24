<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show(User $user)
    {
       
        $tweets = $user->tweets()
            ->with('user', 'likes')
            ->withCount('likes')
            ->latest()
            ->get();

        
        $tweetCount = $tweets->count();
        $totalLikesReceived = $tweets->sum('likes_count');

        return view('users.show', [
            'user' => $user,
            'tweets' => $tweets,
            'tweetCount' => $tweetCount,
            'totalLikesReceived' => $totalLikesReceived,
        ]);
    }
}