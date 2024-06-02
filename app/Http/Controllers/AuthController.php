<?php

namespace App\Http\Controllers;

use App\Mail\ResetToken as MailResetToken;
use App\Models\ResetToken;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
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

    public function handleGenerateResetToken(Request $request)
{
    DB::beginTransaction();

    try {
        // Validate the sent email
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);

        // Get user with that email
        $user = User::where('email', $request->input('email'))->first();

        // Generate token
        $reset_token = mt_rand(100000, 999999);

        // Check if the code has already been sent to the same user
        $exists = ResetToken::where('user_id', $user->id)->first();

        // Replace it if it exists
        if ($exists) {
            $exists->reset_token = $reset_token;
            $exists->save();

            // Send email
            Mail::to($request->input('email'))->send(new MailResetToken($user, $reset_token));

            DB::commit();

            return response()->json(['message' => 'Another token has been sent to you via email'], 200);
        }

        // Create a new record in the database
        ResetToken::create([
            'user_id' => $user->id,
            'reset_token' => $reset_token
        ]);

        // Send email
        Mail::to($user->email)->send(new MailResetToken($user, $reset_token));

        DB::commit();

        return response()->json(['message' => 'Reset token has been sent to you via email'], 200);
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Failed to generate a reset token: ' . $e->getMessage());
        return response()->json(['error' => 'Failed to generate a reset token: ' . $e->getMessage()], 500);
    }
}


    public function handleFetchResetTokens(){
        try {
            //fetch reset tokens
            $tokens = ResetToken::all();
            // send a response
            return response()->json($tokens , 200);

        } catch (\Exception $e) {
            //throw $e;
            return response()->json(['error' => 'Failed to fetch reset tokens: ' . $e->getMessage()], 500);
        }
    }

    public function handleResetPassword(Request $request){
        DB::beginTransaction();
        try {
            //validate the incoming data
            $request->validate([
                'email' => 'required|email|exists:users,email',
                'token' => 'required|integer|exists:reset_tokens,reset_token|digits:6',
                'password' => 'required|string|min:8|confirmed',
                'password_confirmation' => 'required|string|min:8'
            ]);

            // get user with that email
            $user = User::where('email' , $request->input('email'))->first();
            
            // Get the reset token record associated with the user
            $reset_password_user = ResetToken::where('user_id', $user->id)->first();


            if($reset_password_user->reset_token != $request->input('token')){
                return response()->json(['error' => 'Incorrect reset token'], 400);
            }

            // set the password
            $user->password = Hash::make($request->input('password'));
            $user->save();

            // delete the reset code record
            $reset_password_user->delete();
            
            DB::commit();
            
            // return a success response
            return response()->json(['message' => 'Password reset successful'], 200);

            

        } catch (\Exception $e) {
            //throw $e;
            DB::rollBack();
            return response()->json(['error' => 'Failed to reset password: ' . $e->getMessage()]);
        }
    }
}
