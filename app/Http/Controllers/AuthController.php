<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    //
    public function handleLogin(Request $request){
        try {
            // validate the login credentials
            $request->validate([
                'email' => 'required|email',
                'password' => 'required|string|min:8'
            ]);

            $email = $request->input('email');
            $password = $request->input('password');

            // check if a user with that email exists
            $user = User::where('email', $email)->first();
            // send response if they don't exist
            if(!$user){
                return response()->json(['error' => 'Invalid credentials'], 400);
            }
            // check if passwords match
            $matches = Hash::check($password, $user->password);
            if(!$matches){
                return response()->json(['error' => 'Invalid credentials'], 400);
            }

            // generate a jwt token to send
            $token = JWTAuth::fromUser($user);

            return response()->json([
                'message' => 'User logged in',
                'token' => $token
            ], 200);
    
        } catch (\Exception $e) {
            //throw $e;
            return response()->json(['error' => 'Failed to login user: ' . $e->getMessage()]);
        }
    }
}
