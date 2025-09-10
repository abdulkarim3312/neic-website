<?php

namespace App\Http\Controllers\backend;

use session;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class admin extends Controller
{
    public function login()
    {
        if (auth()->check()) {
            return redirect()->route('dashboard'); 
        }
        return view('backend.auth.login');
    }

    public function adminloginCheck(Request $req)
    {
        $email = $req->email;
        $password = $req->password;

        $user = DB::table('admins')
            ->where('email', $email)
            ->first();

        if ($user && Hash::check($password, $user->password)) {

            // Role mapping
            $roleMap = [
                1 => 'admin',
                2 => 'manager',
                3 => 'sales',
            ];

            $roleName = $roleMap[$user->role_id] ?? null;

            if (!$roleName) {
                return back()->with('error', 'User role not defined. Contact admin.');
            }


            $permissions = DB::table('role_has_permissions')
                ->join('permissions', 'role_has_permissions.permission_id', '=', 'permissions.id')
                ->where('role_has_permissions.role_id', $user->role_id)
                ->pluck('permissions.name')
                ->toArray();


            session([
                'user_id'     => $user->id,
                'role_id'     => $user->role_id,
                'role'        => $roleName,
                'email'       => $user->email,
                'permissions' => $permissions,
            ]);

            // last_login update
            DB::table('admins')->where('id', $user->id)->update(['last_login' => Carbon::now()]);

            // Login history insert
            DB::table('login_histories')->insert([
                'user_type' => $roleName, // dynamic user_type
                'user_id'   => $user->id,
                'user_ip'   => $req->ip(),
                'device'    => 'web',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return redirect('/admin/dashboard');
        } else {
            return back()->with('error', 'Invalid email or password.');
        }
    }

    public function logout()
    {
        session()->flush();
        return redirect('/admin/login')->with('message', 'Logged out successfully.');
    }
}
