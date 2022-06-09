<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Role;
class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        foreach($roles as $role)
        {
            // if($role == 'superadmin' && auth()->user()->role_id == Role::SUPER_ADMIN ){
            //     return $next($request);
            // }
            //REMOVE
            if($role == 'admin' && auth()->user()->role_id == Role::ADMIN ){
                return $next($request);
            }
    
            if($role == 'student' && auth()->user()->role_id == Role::STUDENT ){
                return $next($request);
            }    
            if($role == 'staff' && auth()->user()->role_id == Role::STAFF ){
                return $next($request);
            }    
        }
        return abort(403);
    }
}
