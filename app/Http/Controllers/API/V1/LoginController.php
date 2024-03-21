<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request; // Make sure to import the Request class
use App\Http\Controllers\Controller; // Import the base controller class
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function createToken(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Retrieve the authenticated user
            $user = Auth::user();

            // Generate a Sanctum token for the user
            $token = $user->createToken('auth_token')->plainTextToken;

            // Return both the token and user information
            return response()->json([
                'token' => $token,
                'user' => $user,
            ]);
        } else {
            // Return error if authentication fails
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }
}
