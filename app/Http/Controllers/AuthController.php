<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Générer un token Sanctum (type Bearer)
        $token = $user->createToken('api_token')->plainTextToken;

        return response()->json([
            'message' => 'User registered successfully',
            'user'    => $user,
            'token'   => $token,
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken('api_token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'user'    => $user,
            'token'   => $token,
        ]);
    }

    public function me(Request $request)
    {
        try {
            // Vérifie si un utilisateur est authentifié
            $user = $request->user();
            if (!$user) {
                return response()->json([
                    'error' => 'User not authenticated. Please provide a valid token.'
                ], 401);
            }

            return response()->json($user, 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred while processing the request.',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            // Vérifie si un utilisateur est authentifié
            $user = $request->user();
            if (!$user) {
                return response()->json([
                    'error' => 'User not authenticated. Cannot log out without a valid token.'
                ], 401);
            }

            // Supprime uniquement le token actuel
            $user->currentAccessToken()->delete();

            return response()->json([
                'message' => 'Logged out successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred while logging out.',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    
}
