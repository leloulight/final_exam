<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Level;
use App\Role;

class LevelMiddleware
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
        $level_id = Auth::user()->level_id;
        $role_id = Level::find($level_id)->role_id;
        $role = Role::find($role_id);
        if ($role->name != 'SystemAdmin') {
            return redirect()->route('admin.department.index')->with('message', 'Access deny!');;
        }

        return $next($request);
    }
}
