<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class ClientOrdersHistoric
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::user() && Auth::user()->user_type !== 'C')
        {
            return $request->expectsJson()
                ? abort(403, 'You are not allowed')
                :redirect()->route('root')
                ->with('alert-msg', 'You cannot see your historic!')
                ->with('alert-type', 'danger');
        }
        return $next($request);
    }
}
