<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function registerUser(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
            'confirm_password' => 'required'
        ]);

        if($request->input('password') == $request->input('confirm_password')) {
            $user = User::create([
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password'))
            ]);

            if(!empty($user)) {
                return response()->json([
                    "success" => true,
                    "data" => $user
                ], 200);
            } else {
                return response()->json([
                    "success" => false,
                    "data" => 'Register Failed!'
                ], 400);
            }
        } else {
            return response()->json([
                "success" => false,
                "data" => 'Password not match!'
            ], 400);
        }
    }

    public function getProfile(Request $request)
    {
        $userID = Auth::id();
        $user = User::where('id', $userID)->first();
        if(!empty($user)) {
            return response()->json([
                "success" => true,
                "data" => $user
            ], 200);
        } else {
            return response()->json([
                "success" => false,
                "data" => 'Profile not found!'
            ], 400);
        }
    }
}
