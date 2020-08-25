<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use App\User;
use App\Friend;
use Hash;

class FriendController extends Controller
{

    public function addFriend(Request $request) {
        $user_id = $request->user_id;
        $friend_id = $request->friend_id;

        if($user_id == $friend_id)
            return Response::json(['error' => 'Friends with same id']);

        if($this->alreadySent($user_id, $friend_id))
            return Response::json(['error' => 'Request already sent']);

        if($this->checkForPendingRequest($user_id, $friend_id))
            return Response::json(['success' => 'Friendship confirmed']);

        $friendship = Friend::create([
            'user_id' => $user_id,
            'friend_id' => $friend_id,
        ]);

        if($friendship) {
            return Response::json(['friendship' => $friendship]);
        }
        else
            return Response::json(['fail' => 'friendship request failed']);
    }

    public function acceptFriend(Request $request) {

        $friendship = Friend::where('user_id', $request->user_id)->where('friend_id', $request->friend_id)->first();
    
        if($friendship) {
            $friendship->update(['accepted' => true]);
            return Response::json(['friendship' => $friendship]);
        }
        else  
            return Response::json(['fail' => 'friendship acception failed']);
        
    }

    public function alreadySent($user_id, $friend_id) {
        $find = Friend::where('user_id', $user_id)->where('friend_id', $friend_id)->where('accepted', false)->first();
        
        if($find)
            return 1;
        return 0;
    }

    public function checkForPendingRequest($user_id, $friend_id) {
        $find = Friend::where('user_id', $friend_id)->where('friend_id', $user_id)->where('accepted', false)->first();
        
        if($find) {
            $find->update(['accepted' => true]);
            return 1;
        }
    }
}
