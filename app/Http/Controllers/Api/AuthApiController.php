<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthApiController extends Controller
{
    /**
     * Register a new user and return a Sanctum token.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user  = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role'     => 'user',
        ]);

        // Assign default role if using spatie
        if (\Spatie\Permission\Models\Role::where('name', 'user')->exists()) {
            $user->assignRole('user');
        }

        $device = $request->input('device_name', 'api-token');
        $token = $user->createToken($device)->plainTextToken;

        return $this->successResponse([
            'user'  => $user,
            'token' => $token,
        ], 'User registered successfully', 201);
    }

    /**
     * Login and return a Sanctum token.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'       => 'required|email',
            'password'    => 'required',
            'device_name' => 'nullable|string'
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return $this->errorResponse('The provided credentials are incorrect.', 401);
        }

        $device = $request->input('device_name', 'api-token');
        $token = $user->createToken($device)->plainTextToken;

        return $this->successResponse([
            'user'  => $user,
            'token' => $token,
        ], 'Logged in successfully');
    }

    /**
     * Logout and revoke the current token.
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        
        return $this->successResponse(null, 'Logged out successfully.');
    }

    /**
     * Logout from all devices (revoke all tokens).
     */
    public function logoutAll(Request $request)
    {
        $request->user()->tokens()->delete();
        
        return $this->successResponse(null, 'Logged out from all devices successfully.');
    }

    /**
     * Return the authenticated user profile.
     */
    public function profile(Request $request)
    {
        return $this->successResponse($request->user());
    }
}
