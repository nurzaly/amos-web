<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Session;
use Redirect;

class SingleSession
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
    // Session::setId('c8n4vfUlIpJYxxmiEHcy7QTy7gRNY3lM4r4qAi1K');
    // Session::start();
    // Auth::loginUsingId(1);
    // if(Auth::check())
    // {
    //   // If current session id is not same with last_session column
    //   if(Auth::user()->last_session != Session::getId())
    //   {
    //     // do logout
    //     Auth::logout();
    //
    //     // Redirecto login page
    //     return Redirect::to('login');
    //   }
    // }
    return $next($request);
  }
}
