<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class TeamMiddleware
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
        $role = Auth::user()->level->role;
        if ($role->name == 'SystemAdmin' || $role->name == 'Developer') {
            return redirect()->route('admin.department.index')->with('danger', 'Access deny!');;
        }
        return $next($request);
    }
}
