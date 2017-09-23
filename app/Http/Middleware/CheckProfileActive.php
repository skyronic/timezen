<?php

namespace App\Http\Middleware;

use App\User;
use Closure;

class CheckProfileActive
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
        if(!$request->user()) {
            return abort(403);
        }
        /** @var User $user */
        $user = $request->user();
        if($user->profile_saved === false) {
            \Session::flash('status', "Please update profile");
            return redirect()->route('profile_page');
        }

        return $next($request);
    }
}

