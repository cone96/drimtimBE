<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use App\User;
use App\Tweet;
use App\Friend;
use Hash;


class UserController extends Controller
{
    public function showProfileDetails(Request $request) {

        if($request->id1 == $request->id2)
        {
            $user = User::findOrFail($request->id1);
            if(!$user->locked) {
                $tweets = $user->tweets;
            }
            return Response::json(['success' => true, 'message' => $user]);
        }
        else
        {
            $user = User::findOrFail($request->id2);
            if(!$user->locked){
                $tweets = $user->tweets;
            }
                if(in_array($request->id1, $user->friends->pluck('id')->all()))
                    return Response::json(['message' => $user, 'friends' => 1]);
                
                $find = Friend::where('user_id',$request->id1)->where('friend_id',$request->id2)->where('accepted',false)->first();
                if ($find)
                    return Response::json(['message' => $user, 'friends' => 0, 'request_sender' => $request->id1, 'request_receiver' => $request->id2]);

                $find = Friend::where('user_id',$request->id2)->where('friend_id',$request->id1)->where('accepted',false)->first();
                if($find)
                    return Response::json(['message' => $user, 'friends' => 0, 'request_sender' => $request->id2, 'request_receiver' => $request->id1]);

                return Response::json(['message' => $user, 'friends' => 0, 'message' => 'No friend request']);
            
        }
    }

    public function changePassword(Request $request) {
        
        $request->validate([
            'old_password' => 'required|string',
            'new_password' => 'required|min:6|max:16',
        ]);
        
        
        $user = User::findOrFail($request->id);
        if(Hash::check($request->old_password, $user->password)) {
            User::where('id', $request->id)->update(['password' => Hash::make($request->new_password)]);
            return Response::json(['success' => true, 'message' => $user, 'password' => $request->new_password]);
        } 
        else {
            return Response::json(['success' => false, 'error' => 'Wrong old password!']);
        }

    }

    public function changeName(Request $request) {

        return Response::json(['success' => true, 'message' => User::findOrFail($request->id)->update(['name' => $request->name]), 'user' => User::findOrFail($request->id)]);
    }

    public function changeEmail(Request $request) {

        $request->validate([
            'new_email' => 'required|email',
        ]);

        return Response::json(['success' => true, 'message' => User::findOrFail($request->id)->update(['email' => $request->new_email]), 'user' => User::findOrFail($request->id)]);
    }

    public function lockProfile(Request $request) {
        
        
        $user = User::findOrFail($request->id);
        if(!$user->locked) 
            $lock = User::findOrFail($request->id)->update(['locked' => 1]);
        else
            $lock = User::findOrFail($request->id)->update(['locked' => 0]);
        
        return Response::json(['success' => true, 'message' => $lock]);
    }
}
