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

    public function handleChangePassword(Request $request, $id){
        try {
            //validate incoming request data
            $request->validate([
                'current_password' => 'required|string|min:8',
                'new_password' => 'required|string|min:8|confirmed',
                'new_password_confirmation' => 'required|string|min:8'
            ]);

            // get user changing password
            $user = User::find($id);
            // check if user exists
            if(!$user){
                return response()->json(['error' => 'User does not exist'], 400);
            }

            // check if current passwords match
            $matches = Hash::check($request->input('current_password') , $user->password);
            if(!$matches){
                return response()->json(['error' => 'Incorrect current password'], 400);
            }

            // change the user's password
            $user->password = Hash::make($request->input('new_password'));
            $user->save();

            // return a response
            return response()->json(['message' => 'Password changed successfully'], 200);

        } catch (\Exception $e) {
            //throw $e;
            return response()->json(['error' => 'Failed to change passwords: ' . $e->getMessage()]);
        }
    }
}
