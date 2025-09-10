<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, ...$roles)
    {
        // লগইন চেক (role session আছে কিনা)
        if (!Session::has('role')) {
            return redirect('/admin/login')->with('error', 'Please login first.');
        }

        // ইউজারের role session থেকে নাও
        $userRole = Session::get('role');

        // একাধিক role এর মধ্যে মিল আছে কিনা চেক
        if (!in_array($userRole, $roles)) {
            abort(403, 'You do not have permission to access this page.');
        }

        return $next($request);
    }
}
