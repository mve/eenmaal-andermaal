<?php

namespace App\Http\Middleware;

use App\Auction;
use Carbon\Carbon;
use Closure;

class CheckUserWonAuction
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
            $auction = Auction::oneWhere("id", $request->route('id'));
            if(!$auction)
                return redirect()->home();
            if(Carbon::now() < Carbon::parse($auction->end_datetime))
                return redirect()->home();
            $highestBid = $auction->getHighestBid();
            if($highestBid !== false && $highestBid->user_id===$request->session()->get('user')->id) {
                $request->attributes->add(['auction'=>$auction]);
                return $next($request);
            }
            return redirect()->home();
        });
    }
}
