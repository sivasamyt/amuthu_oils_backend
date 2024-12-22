<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
// use Log;


class UserController extends Controller
{
    public function signup(Request $request)
    {
        // Log::info('entry');
        $token = Str::random(60);
        try {
            $user = User::create([
                'name' => $request->Username,
                'email' => $request->Email,
                'password' => $request->Password,
                'remember_token' => $token,
            ]);
            // Log::info($user);
            // Log::info($user->id);
            if($user->id == 1){
        // Log::info('if entry');
                $user->update(['role' => 'admin']);
            }
            return response()->json([
                'message' => 'Signed up successfully',
                'success' => true,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Something went wrong. Please try again later.',
                'success' => false,
            ], 401);
        }
    }

    public function loginCheck(Request $request)
    {
        $mailId = $request->Email;
        $pwd = $request->Password;
        if ($user = User::where('email', $mailId)->exists()) {
            $user = User::where('email', $mailId)->first();
            $password = $user->password;
            if (Hash::check($pwd, $password)) {
                // return $user;
                return response()->json([
                    'message' => 'Login successful',
                    'user' => $user
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Wrong password'
                ], 401);
                // return "Wrong Password";
            }
        } else {
            return response()->json([
                'message' => 'User not found'
            ], 404);
            // return "User Not Found";
        }
    }

}