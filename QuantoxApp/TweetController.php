<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use App\User;
use App\Tweet;
use App\Http\Requests\PostRequest;



class TweetController extends Controller
{
    public function showAllTweets(Request $request) {

        $request->validate([
            'id' => 'integer|exists:users,id',
        ]);

        if($request->id) {
            $name = User::select('name')->where('id', $request->id)->get();
            return Response::json(['name' => $name, 'tweet' => Tweet::where('user_id', $request->id)->orderBy('created_at', 'desc')->get()]);
        } 
        else {
            return Response::json(['tweet' => Tweet::join('users', 'tweets.user_id', '=', 'users.id')->orderBy('tweets.created_at', 'desc')->select('*')->get()]);
      }
    }


    public function addTweet(Request $request) {
        
        $user = User::findOrFail($request->id);

        $id = Tweet::create([
            'user_id' => $request->id,
            'content' => $request->content,
        ])->id;

        $tweet = Tweet::findOrFail($id);
        $user->tweets()->save($tweet);

        return Response::json(['success' => true, 'id' => $id, 'message' => $user]);
    }
}
