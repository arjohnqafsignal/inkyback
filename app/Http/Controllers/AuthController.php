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
            $registerData['email'] = $request->email;
            $registerData['name'] = $request->name;
            $registerData['google_id'] = $request->google_id;
            $registerData['image'] = $request->image;
            $registerData['password'] = bcrypt($request->google_id);
        
            $user = User::create($registerData);
            $accessToken = $user->createToken('authToken')->accessToken;
        }
        else
        {
            $loginData['email'] = $request->email;

            $user = $this->auth($loginData);
            $accessToken = $user->createToken('authToken')->accessToken;
        }

        return response()->json([
            'user' => $user,
            'token' => $accessToken
        ], 200);
    }

    private function auth($loginData)
    {
        $user = User::where($loginData)->first();

        return $user;
    }
}
