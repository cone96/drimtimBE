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

        //error_log($request->user_id);

        $id = $request->user_id;


        //error_log($id);
        $request->validate([
            'user_id' => 'integer|exists:users, id',
        ]);

        if($id) {
            return Response::json(Tweet::where('user_id', $id)->get());
        } else {
            return Response::json(Tweet::all());
      }
    }

}
