<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     *  @return string|null
     */
    public function handle(Request $request, Closure $next)
    {
        $roles = array(0, 1, 2);
        if (Auth::check() && in_array($request->user()->role, $roles)) {
            return $next($request);
        }
        return redirect('home');
    }
}
