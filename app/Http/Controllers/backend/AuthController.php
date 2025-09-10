<?php

namespace App\Http\Controllers\backend;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Admin;
use App\Models\LoginHistory;
use Illuminate\Http\Request;
use App\Rules\StrongPassword;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Validation\ValidationException;



class AuthController extends Controller
{

    public $user;
    
    // public function __construct()
    // {
    //     $this->middleware(function ($request, $next) {
    //         $this->user = auth()->guard('web')->user();
    //         return $next($request);
    //     });
    // }
    /**
     * admin login
     */
    public function adminLogin()
    {
        if (auth()->check()) {
            return redirect()->route('dashboard'); 
        }
        return view('backend.auth.login');
    }
    /**
     * admin login post
     */
    public function adminLoginPost(LoginRequest $request)
    {
        $user = Admin::where('email', $request->email)->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'email' => 'Invalid email!',
            ]);
        }

        $user->last_login = now();
        $user->save();

        $roles = $user->getRoleNames();

        LoginHistory::create([
            'user_type' => $roles[0] ?? null,
            'user_id' => $user->id,
            'user_ip' => $request->ip(),
        ]);

        $user->user_type = $roles[0] ?? null;

        // Authenticate using 'admin' guard
        $request->authenticate('admin');

        $request->session()->regenerate();

        return redirect('/admin/dashboard');
    }
    /**
     * admin logout
     */
    public function adminLogout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::orderBy('name', 'asc')->get();
        return view('backend.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::select('id', 'name')->get();
        return view('backend.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'role_id' => 'required|exists:roles,id',
            'email' => 'required|string|email|max:255|unique:users,email,NULL,id,deleted_at,NULL',
            'password' => ['required', 'string', new StrongPassword],
        ]);

        DB::beginTransaction();
    
        try {

            $role = Role::find($request->role_id);

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->status = $request->status;
            $user->email_verified_at = \Carbon\Carbon::now();
            $user->registered_at = \Carbon\Carbon::now();
            $user->registered_by = Auth::user()->name;
            $user->user_type = $role->name;
            $user->save();
            $user->assignRole($role);

            DB::commit();
            
            return redirect()->route('users.index')->with('success', 'User created successfully !!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::Find($id);
        $roles = Role::select('id', 'name')->get();
        return view('backend.users.edit', compact('user','roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        
        $request->validate([
            'name' => 'required|string',
            'role_id' => 'required|exists:roles,id',
            'email' => 'required|string|email|max:255' . $request->id . ',id,deleted_at,NULL',
            'password' => [
                    'nullable',
                    'string',
                    'min:8',
                    'regex:/[a-z]/',
                    'regex:/[A-Z]/',
                    'regex:/[0-9]/',
                    'regex:/[@$!%*?&#]/',
                ],
        ],[
            'password.min' => 'The password must be at least 8 characters.',
            'password.regex' => 'The password must contain lowercase, uppercase, a number, and a special character.',
        ]);

        DB::beginTransaction();
    
        try {

            $role = Role::find($request->role_id);

            $user = User::Find($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = $request->password ? bcrypt($request->password) : $user->password;
            $user->status = $request->status;
            $user->email_verified_at = \Carbon\Carbon::now();
            $user->registered_at = \Carbon\Carbon::now();
            $user->user_type = $role->name;
            $user->save();
            $user->syncRoles($role);

            DB::commit();

            session()->flash('success', 'User updated successfully !!');
            return redirect()->route('users.index');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        session()->flash('success', 'User deleted successfully !!');
        return redirect()->route('users.index');
    }
}
