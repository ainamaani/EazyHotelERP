<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function handleSignUp(Request $request){
        try {
            //validate the incoming date
            $request->validate([
                'name' => 'required|string',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8|confirmed',
                'password_confirmation' => 'required|string|min:8',
                'role' => 'required|in:admin,staff,guest'
            ]);

            // create the user in the database
            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => $request->input('password'),
                'role' => $request->input('role')
            ]);

            // return a success message after user creation
            return response()->json(['message' => 'User created successfully: ' . $user], 201);


        } catch (\Exception $e) {
            //throw $e;
            return response()->json(['error' => 'Failed to sign up new user: ' .$e->getMessage()], 500);
        }
    }

    public function handleFetchUsers(){
        try {
            // fetch all users
            $users = User::all();

            // return the users
            return response()->json($users, 200);

        } catch (\Exception $e) {
            //throw $e;
            return response()->json(['error' => 'Failed to fetch users: ' .$e->getMessage()], 500);
        }
    }

    public function handleDeleteUser($id){
        try {
            //get the user
            $user = User::find($id);

            // check if the user exists
            if(!$user){
                return response()->json(['error' => 'User does not exist'], 404);
            }
            // delete the user
            $user->delete();
            // return a response
            return response()->json(['message' => 'User deleted successfully'], 200);

        } catch (\Exception $e) {
            //throw $e;
            return response()->json(['error' => 'Failed to delete the user with that ID: ' .$e->getMessage()]);
        }
    }

    public function handleFetchSingleUser($id){
        try {
            //retrieve the user
            $user = User::find($id);

            // check if the user exists
            if(!$user){
                return response()->json(['error' => 'User does not exist'], 404);
            }

            // return the user
            return response()->json($user, 200);

        } catch (\Exception $e) {
            //throw $e;
            return response()->json(['error' => 'Failed to fetch user with that ID: ' .$e->getMessage()]);
        }
    }

    public function handleChangeRole(Request $request, $id){
        try {
            //validate the request data
            $request->validate([
                'role' => 'required|string|in:admin,staff,guest'
            ]);
            // get user whose role is to be changed
            $user = User::find($id);
            // check if the user exists
            if(!$user){
                return response()->json(['error' => 'User does not exist'], 404);
            }
            // change and save the user's role
            $user->role = $request->input('role');
            $user->save();

            return response()->json(['message' => 'User role changed successfully'], 200);


        } catch (\Exception $e) {
            //throw $e;
            return response()->json(['error' => 'Failed to change roles: ' .$e->getMessage()], 500);
        }
    }
}
