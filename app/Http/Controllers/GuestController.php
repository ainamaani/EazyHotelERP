<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use Illuminate\Http\Request;


class GuestController extends Controller
{
    public function handleGuestCheckIn(Request $request){
        try {
            //validate the incoming data
            $request->validate([
                'user_id' => 'required|exists:users,id',
                'phone_number' => 'required|string|min:10',
                'email' => 'required|email|unique:guests,email',
                'address' => 'required|text',

            ]);

            // create the guest in the database
            $guest = Guest::create([
                'user_id' => $request->input('user_id'),
                'phone_number' => $request->input('phone_number'),
                'email' => $request->input('email'),
                'address' => $request->input('address'),
                'loyalty_points' => 0,
                'check_in_time' => now(),
                'status' => 'checked_in'
            ]);

            // return successful response
            return response()->json(['message' => 'Guest checked in successfully'],200);



        } catch (\Exception $e) {
            //throw $e;
            return response()->json(['error' => 'Failed to add the guest: ' . $e->getMessage()], 500);
        }
    }
    //
    public function handleFetchGuests(){
        try {
            //fetch the guests
            $guests = Guest::all();
            // return the guests in response
            return response()->json($guests , 200);

        } catch (\Exception $e) {
            //throw $e;
            return response()->json(['error' => 'Failed to fetch the guests: ' . $e->getMessage()], 500);
        }
    }

    public function handleFetchSingleGuest($id){
        try {
            //fetch the guest
            $guest = Guest::find($id);
            // check if guest exists
            if(!$guest){
                return response()->json(['error' => 'Guest does not exist'], 400);
            }
            // return the guest
            return response()->json($guest , 200);

        } catch (\Exception $e) {
            //throw $e;
            return response()->json(['error' => 'Failed to fetch single guest: ' . $e->getMessage()], 500);
        }
    }

    public function handleGuestCheckOut($id){
        try {
            //fetch the guest who has checked out
            $guest = Guest::find($id);
            //check if the guest exists
            if(!$guest){
                return response()->json(['error' => 'Guest does not exist'], 400);
            } 
            // update the guest attributes
            $guest->check_out_time = now();
            $guest->status = 'checked_out';
            // save the updated guest object
            $guest->save();

            return response()->json(['message' => 'Guest check out successful'], 200);
        } catch (\Exception $e) {
            //throw $e;
            return response()->json(['error'=>'Failed to handle guest check out: ' . $e->getMessage()], 500);
        }
    }
}
