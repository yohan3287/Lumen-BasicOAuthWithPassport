<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

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
                'password' => $request->input('password')
            ]);

            if(!empty($user)) {
                return response()->json([
                    "success!" => true,
                    "data" => $user
                ], 200);
            } else {
                return response()->json([
                    "success!" => false,
                    "data" => 'Register Failed!'
                ], 400);
            }
        } else {
            return response()->json([
                "success!" => false,
                "data" => 'Password not match!'
            ], 400);
        }


    }
}
