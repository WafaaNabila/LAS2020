<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Auth\Middleware\Role as Middleware;
use Illuminate\Support\Facades\Auth;

class Role {

  public function handle($request, Closure $next, int $role) {

    if ((Auth::check()) && (Auth::user()->role_id == $role) && !(Auth::user()->emp_status_id == 2))
    {
      return $next($request);
    }

      return redirect()->route('error.no_permission');

  }


}
