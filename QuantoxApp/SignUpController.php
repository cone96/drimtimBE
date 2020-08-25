<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use App\User;
use App\Tweet;
use Illuminate\Support\Facades\Hash;

class SignUpController extends Controller {

    public function register(Request $request) {

        $request->validate([
            'name' => 'required|unique:users,name',
            'email' => 'required|unique:users,email|email',
            'password' => 'required|min:6|max:16',
        ]);
    
        User::create([
            'name' => $request->name , 
            'email' => $request->email, 
            'password' => Hash::make($request->password),
        ]);

        return Response::json(['success' => 'Success!']);
    }
}

