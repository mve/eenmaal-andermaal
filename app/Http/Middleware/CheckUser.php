<?php

namespace App\Http\Middleware;

use App\DB;
use App\Http\Controllers\Auth\LoginController;
use Closure;

class CheckUser
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
        if (!$request->session()->has('user')) {
            return redirect('login');
        } else if ($request->session()->has('user')) {
            $user = DB::selectOne("SELECT is_blocked FROM users WHERE id=:id", [
                "id" => $request->session()->get('user')->id
            ]);

            if ($user['is_blocked'] == 1) {
                return LoginController::logout($request, true);
            }
        }

        return $next($request);
    }
}
