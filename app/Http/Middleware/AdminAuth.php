<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // dd("hello");
        if (!auth()->user()) {
            return redirect()->route('admin.login');
        } else {
            if (auth()->user()->is_admin == 1) {
                return $next($request);
            } else {
                
                return redirect()->route('login');
            }
        }
    }
}
