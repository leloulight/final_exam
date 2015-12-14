<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Role;
use Level;

class ReviewMiddleware
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
        if ($role->name == 'SystemAdmin') {
            return redirect()->route('admin.department.index')->with('danger', 'Access deny!');;
        }

        return $next($request);
    }
}
