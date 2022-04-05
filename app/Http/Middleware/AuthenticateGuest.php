<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AuthenticateGuest
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        $guest = $request->cookie('guest', json_encode([
            'id' => $id = Str::uuid(),
            'name' => 'Guest-' . $id
        ]));


        return $response->cookie(cookie('guest', $guest, 60 * 24)->withSecure(false));
    }
}
