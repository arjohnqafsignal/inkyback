<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function loginGoogle(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'image' => 'required',
            'google_id' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if(!$user)
        {
            $userData['email'] = $request->email;
            $userData['name'] = $request->name;
            $userData['googele_id'] = $request->google_id;
            $userData['image'] = $request->image;
            $userData['password'] = bcrypt('$request->google_id');
        
            $user = User::create();
        }
        else
        {
            echo 2;
        }

        
    }
}
