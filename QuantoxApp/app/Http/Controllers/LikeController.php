<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use App\Tweet;
use App\Like;


class LikeController extends Controller
{
    public function likeTweet(Request $request) {
        $tweet = Tweet::findOrFail($request->tweet_id);
        $likes = $tweet->likes->pluck('user_id')->all();
        if(in_array($request->user_id, $likes)) 
            return Response::json(['error' => 'Already liked']);
            
        $like = Like::create([
            'tweet_id' => $request->tweet_id,
            'user_id' => $request->user_id,
        ]);

        return Response::json(['like' => $like, 'tweet' => $tweet]);
    }
        
    

    public function unlikeTweet(Request $request) {
        $tweet = Tweet::findOrFail($request->tweet_id);

        Like::where('user_id', $request->user_id)->where('tweet_id', $request->tweet_id)->first()->delete();
        return Response::json(['success' => 'Tweet unliked', 'tweet' => $tweet]);
    }
}
