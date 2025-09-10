<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Define permissions with dot notation
        $permissions = [
            'user'          => ['manage', 'create', 'edit', 'view', 'delete'],
            'role'          => ['create', 'edit', 'view', 'delete'],
            'menu_categories' => ['manage','create', 'edit', 'view', 'delete'],
            'menus'           => ['create', 'edit', 'view', 'delete'],
            'article_categories' => ['manage','create', 'edit', 'view', 'delete'],
            'articles'        => ['create', 'edit', 'view', 'delete'],
            'designations'    => ['manage','create', 'edit', 'view', 'delete'],
            'committee_member_info' => ['create', 'edit', 'view', 'delete'],
            'attachment_categories' => ['manage','create', 'edit', 'view', 'delete'],
            'attachments'     => ['create', 'edit', 'view', 'delete'],
        ];

        // Create permissions
        foreach ($permissions as $module => $actions) {
            foreach ($actions as $action) {
                Permission::firstOrCreate([
                    'name'       => "{$module}.{$action}",  
                    'guard_name' => 'admin',
                    'module'     => ucfirst(str_replace('_', ' ', $module)), 
                ]);
            }
        }

        // Create only admin role
        $adminRole = Role::firstOrCreate([
            'name'       => 'admin',
            'guard_name' => 'admin',
        ]);

        // Assign all permissions to admin
        $adminRole->syncPermissions(Permission::where('guard_name', 'admin')->get());

        // Create default admin user
        $admin = Admin::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name'     => 'Super Admin',
                'password' => Hash::make('123456789'),
                'role_id'  => $adminRole->id,
            ]
        );

        $admin->assignRole('admin');
    }
}
