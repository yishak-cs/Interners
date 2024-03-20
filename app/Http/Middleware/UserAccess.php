<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;

class UserAccess
{
    public function handle(Request $request, Closure $next, string $userType)
    {
        if (auth()->user()->type == $userType) {
            return $next($request);
        }

        if ($request->expectsJson()) {
            // Return a JSON response if the request expects JSON
            return response()->json(['error' => 'You do not have permission to access this page.'], 403);
        }

        // Redirect if it's a standard HTTP request
        return redirect()->route(auth()->user()->type.'.home')->with('error', 'You do not have permission to access for this page.');
    }
}

