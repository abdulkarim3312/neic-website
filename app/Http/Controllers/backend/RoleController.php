<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Requests\RoleRequest;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{

    // public static function middleware(): array
    // {
    //     return [
    //         'auth:admin',
    //         'check.permission:view-role' => ['only' => ['index', 'show', 'getPermissions']],
    //         'check.permission:create-role' => ['only' => ['create', 'store']],
    //         'check.permission:edit-role' => ['only' => ['edit', 'update', 'assignPermissions']],
    //         'check.permission:delete-role' => ['only' => ['destroy', 'bulkDelete']],
    //     ];
    // }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (!auth('admin')->user()->can('role.view')) {
            abort(403, 'Access denied');
        }
        if ($request->ajax()) {
            $roles = Role::with('permissions')->orderBy('name', 'asc');

            return DataTables::of($roles)
                ->addColumn('permissions', function ($row) {
                    $chunks = $row->permissions->chunk(ceil($row->permissions->count() / 4));
                    $html = '<div class="row">';
                    foreach ($chunks as $chunk) {
                        $html .= '<div class="col-md-3"><ul>';
                        foreach ($chunk as $permission) {
                            $html .= '<li class="text-capitalize">' . e($permission->name) . '</li>';
                        }
                        $html .= '</ul></div>';
                    }
                    $html .= '</div>';
                    return $html;
                })
                ->addColumn('action', function ($row) {
                    $buttons = '';
                    if (auth('admin')->user()->can('role.edit')) {
                        $buttons .= '<a href="' . route('roles.edit', $row->id) . '" class="btn btn-sm btn-primary mx-1"><i class="fa fa-edit"></i></a> ';
                    }

                    if (auth('admin')->user()->can('role.delete')) {
                        $buttons .= '<button class="btn btn-danger btn-sm deleteItem" data-id="' . $row->id . '"><i class="fa fa-trash"></i></button>';
                    }
                    return $buttons;
                })
                ->rawColumns(['permissions', 'action']) 
                ->make(true);
        }

        return view('backend.roles.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth('admin')->user()->can('role.create')) {
            abort(403, 'Access denied');
        }
        $permissions = Permission::orderBy('name', 'ASC')->get();
        return view('backend.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleRequest $request)
    {
        $validData = $request->validated();

        DB::beginTransaction();
        try{

            $roleData = $request->except('permissions');
            if (!isset($roleData['guard_name'])) {
                $roleData['guard_name'] = 'admin'; 
            }

            $role = Role::create($roleData);

            $permissions = $request['permissions'] ?? [];

            $role->syncPermissions($permissions);

            DB::commit();

            $sessionRoleId = session('role_id');  
            if ($sessionRoleId && $sessionRoleId == $role->id) {
                $permissions = DB::table('role_has_permissions')
                    ->join('permissions', 'role_has_permissions.permission_id', '=', 'permissions.id')
                    ->where('role_has_permissions.role_id', $sessionRoleId)
                    ->pluck('permissions.name')
                    ->toArray();

                session(['permissions' => $permissions]);
            }

            session()->flash('success', 'Role created successfully !!');
            return redirect()->route('roles.index');

        } catch (\Exception $exception){
            DB::rollBack();
            session()->flash('error', $exception->getMessage());
            return redirect()->back();
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
    public function edit(Role $role)
    {
        if (!auth('admin')->user()->can('role.edit')) {
            abort(403, 'Access denied');
        }
        $permissionNames = $role->permissions->pluck('name')->toArray();

        $permissions = Permission::select('id', 'name', 'module')
            ->orderBy('module')
            ->get()
            ->groupBy('module'); 

        return view('backend.roles.edit', compact('role', 'permissions', 'permissionNames'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (!auth('admin')->user()->can('role.edit')) {
            abort(403, 'Access denied');
        }
        
        $role = Role::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|unique:roles,name,' . $id . ',id'
        ]);

        if ($validator->passes()) {

            if (!$role->guard_name) {
                $role->guard_name = 'admin'; 
            }

            $role->name = $request->name;
            $role->save();

            if (!empty($request->permissions)) {
                $role->syncPermissions($request->permissions);
            } else {
                $role->syncPermissions([]);
            }
            
            $sessionRoleId = session('role_id');  
            if ($sessionRoleId && $sessionRoleId == $role->id) {
                $permissions = DB::table('role_has_permissions')
                    ->join('permissions', 'role_has_permissions.permission_id', '=', 'permissions.id')
                    ->where('role_has_permissions.role_id', $sessionRoleId)
                    ->pluck('permissions.name')
                    ->toArray();

                session(['permissions' => $permissions]);
            }

            session()->flash('success', 'Role updated successfully !!');
            return redirect()->route('roles.index');
        } else {
            return redirect()->route('roles.edit', $id)->withInput()->withErrors($validator);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!auth('admin')->user()->can('role.delete')) {
            abort(403, 'Access denied');
        }
        $role = Role::find($id);
        if ($role == null) {
            session()->flash('error', 'Role not found!!');
            return redirect()->route('permissions.index');
        }
        $role->delete();
        session()->flash('success', 'Role Deleted successfully !!');
        return redirect()->route('roles.index');
    }
}
