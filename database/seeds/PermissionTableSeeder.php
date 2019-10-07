<?php

use App\User;
use Illuminate\Database\Seeder;
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
            'user-delete'
        ];


        // Update role for user
        foreach ($permissions as $permission) {
            Permission::updateOrCreate(['name' => $permission]);
        }

        $role = Role::updateOrCreate(['name' => 'Supper Admin']);
        $role->givePermissionTo(Permission::all());

        // Assign role to users
        User::truncate();
        $user = User::updateOrCreate([
            'name'     => 'Hiep Nguyen',
            'email'    => 'minhhiep.q@gmail.com',
            'password' => bcrypt('Demo@admin.com'),
        ]);
        $user->assignRole($role);

    }
}
