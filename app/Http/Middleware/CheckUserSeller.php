<?php

namespace App\Http\Middleware;

use Closure;

class CheckUserSeller
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if (!$request->session()->has('user') || !$request->session()->get('user')->is_seller ) {
            return redirect('/');
        }

        return $next($request);
    }
}