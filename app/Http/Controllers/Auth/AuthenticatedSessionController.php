<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): JsonResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user=auth()->user();
        return response()->json([
            'success' => true,
            'message' => 'User Logged in',
            'user' => $user,
            'token' => $user->createToken($user->name)->plainTextToken,
        ]);
//        return response()->noContent();
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): JsonResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        $user=$request->user();
        $user->tokens()->delete();

        return response()->json([
            'success' => true,
            'message' => 'User Logged out',
        ]);

//        return response()->noContent();
    }
}
