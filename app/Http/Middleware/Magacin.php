<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Magacin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()->role_id == 5 || $request->user()->role_id == 1) {
            return $next($request);
        } else {
            return redirect()->route('warehouse.index')
                ->with('error', 'Nemate dozvolu pristupa ovom delu aplikacije');
        }

    }
}
