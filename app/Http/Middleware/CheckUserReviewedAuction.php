<?php

namespace App\Http\Middleware;

use App\DB;
use Closure;

class CheckUserReviewedAuction
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
        //First check if the user won the auction
        return app(CheckUserWonAuction::class)->handle($request, function ($request) use ($next) {
            $review = DB::selectOne("SELECT TOP 1 * FROM reviews WHERE user_id=:user_id AND auction_id=:auction_id",[
                "user_id" => $request->session()->get('user')->id,
                "auction_id" => $request->get("auction")->id
            ]);
            if($review===false)
                return $next($request);
            return redirect()->home();
        });
    }
}
