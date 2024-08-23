<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class checkCountry
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $country = [
            'us',
            'uk',
            'in',
            'bd',
            'vn',
        ];
        if(!in_array($request->country, $country) && !request()->is('unvailable')){
            return redirect()->route('unvailable');
        }
        return $next($request);
    }
}
