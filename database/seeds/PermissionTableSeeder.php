<?php

use App\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        // Reset all table permission
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            DB::table('roles')->truncate();
            DB::table('permissions')->truncate();
            DB::table('model_has_permissions')->truncate();
            DB::table('model_has_roles')->truncate();
            DB::table('role_has_permissions')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        // Insert data
        $permissions = [
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'company-list',
            'company-create',
            'company-edit',
            'company-delete',
            'comment-list',
            'comment-create',
            'comment-edit',
            'comment-delete',
            'comment-reply-list',
            'comment-reply-create',
            'comment-reply-edit',
            'comment-reply-delete',
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'admin-list',
            'admin-create',
            'admin-edit',
            'admin-delete'
        ];

        // Update role for user
        foreach ($permissions as $permission) {
            Permission::updateOrCreate([
                'guard_name' => 'admin',
                'name'       => $permission
            ]);
        }

        //Assign role to admins

        $roleAdmin = Role::updateOrCreate([
            'guard_name' => 'admin',
            'name'       => 'Supper Admin'
        ]);
        $roleAdmin->givePermissionTo(Permission::where('guard_name', 'admin')->get());

        Admin::truncate();
        $admin = Admin::updateOrCreate([
            'name'     => 'Hiep Nguyen Administrator',
            'email'    => 'nguyenminhhiep9x@gmail.com',
            'password' => bcrypt('Demo@admin.com'),
        ]);
        $admin->assignRole($roleAdmin);

    }
}
