<?php

namespace App\Http\Middleware;

use Closure;
use App\User;

class CheckUserIsBlocked
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
    $isBlockedReturn = User::handleIsBlocked($request);
    if ($isBlockedReturn) {
      return $isBlockedReturn;
    } 
    
    return $next($request);
  }
}
