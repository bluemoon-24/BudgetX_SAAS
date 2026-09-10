<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserStatus
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->status === 'blocked') {
                if ($request->is('api/*') || $request->expectsJson()) {
                    $user->currentAccessToken()?->delete();

                    return response()->json([
                        'success' => false,
                        'message' => 'Your account is suspended.',
                    ], 403);
                }

                Auth::guard('web')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('login')->withErrors([
                    'email' => 'Your account has been suspended by an administrator.',
                ]);
            }
        }

        return $next($request);
    }
}
