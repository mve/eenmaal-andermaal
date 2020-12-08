<?php

namespace App\Http\Middleware;

use Closure;

class CheckUserIsSeller
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
        //First check if the user has been logged in
        return app(CheckUser::class)->handle($request, function ($request) use ($next) {
            if($request->session()->get('user')->is_seller===1) {
                return $next($request);
            }
            return redirect()->route("home");
        });
    }
}
