<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function store(Request $request){
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required|string'
            ],
            [
                'required' => ':attribute is required',
                'string' => ':attribute must be a string',
                'email' => ':attribute must be valid'
            ]
        );

        $user = User::where('email', $request->email)->first();

        if(!$user || !Hash::check($request->password, $user->password)){
            return response()->json(['success' => false, 'message' => 'Invalid Email or/and Password'], 401);
        }

        $token = $user->createToken($user->email)->plainTextToken;

        return response()->json(['success' => true, 'msg' => "User Logged in successfuly", "data" => $user, "token" => $token], 200);

        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'msg' => $th->getMessage()], 400);
        }
    }

    public function destroy(Request $request)
    {
        try {
            $user = $request->user();

            if (!$user) {
                return response()->json(['success' => false, 'msg' => 'User is not authenticated'], 401);
            }

            $user->tokens()->delete();

            return response()->json(['success' => true, 'msg' => "User logged out successfuly"], 200);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'msg' => $th->getMessage()], 400);
        }
    }



}
