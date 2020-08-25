<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use App\User;
use App\Tweet;
use Hash;
use App\Http\Requests\PostRequest;



class UserController extends Controller
{
    public function showProfileDetails(Request $request) {

        $user = User::findOrFail($request->id);
        if(!$user->locked) {
            $tweets = $user->tweets;
        }
        return Response::json(['success' => true, 'message' => $user]);
      
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
        
        User::findOrFail($request->id)->update(['locked' => 1]);
        $user = User::findOrFail($request->id);
        return Response::json(['success' => true, 'message' => $user]);

    }

    public function unlockProfile(Request $request) {
        
        User::findOrFail($request->id)->update(['locked' => 0]);
        $user = User::findOrFail($request->id);
        return Response::json(['success' => true, 'message' => $user]);

    }
}
