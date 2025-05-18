<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ClearCheckoutSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Bersihkan session jika bukan di halaman checkout
        if (!$request->is('checkout') && !$request->is('checkout/*')) {
            session()->forget('checkout_items');
        }

        return $next($request);
    }
}
