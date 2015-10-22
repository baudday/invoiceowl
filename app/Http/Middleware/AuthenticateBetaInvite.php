<?php

namespace App\Http\Middleware;

use Closure;

class AuthenticateBetaInvite
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
        if (!$request->input('email') || !$request->input('key')) {
          if ($request->ajax()) {
              return response('Not Found.', 404);
          } else {
              return redirect()->guest('/');
          }
        }

        \App\Email::where(['email' => $request->input('email'), 'key' => $request->input('key')])->firstOrFail();

        return $next($request);
    }
}
