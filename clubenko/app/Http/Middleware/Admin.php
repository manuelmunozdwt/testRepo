<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->guest()) {
          if ($request->ajax()) {
            return response('Unauthorized.', 401);
          } else {
            return redirect()->guest('login');
          }
        } else if (!es_administrador(Auth::guard($guard)->user())) {
            return redirect()->to('/')->withError('Permission Denied');
        }

    return $next($request);
    }
}
