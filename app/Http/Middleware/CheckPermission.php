<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, $permission)
    {
        if (!Session::has('permissions')) {
            return redirect('/admin/login')->with('error', 'Please login first.');
        }

        $userPermissions = Session::get('permissions', []);

        if (!in_array($permission, $userPermissions)) {
            abort(403, 'You do not have permission to access this page.');
        }

        return $next($request);
    }
}
