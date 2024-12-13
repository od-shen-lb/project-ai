<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class PermissionRoleSeeder extends Seeder
{
    public function run(): void
    {
        // Roles
        $roles = [
            '系統管理員',
            'AI管理員',
        ];

        $dbRoles = Role::all()->pluck('name')->all();

        foreach ($roles as $index => $role) {
            if (!in_array($role, $dbRoles)) {
                Role::create([
                    'id'   => $index + 1,
                    'name' => $role,
                ]);
            }//end if
        }//end foreach

        // Permissions
        $permissions = [
            '新增管理員',
            '編輯管理員',
            '檢視管理員',
            '刪除管理員',
        ];

        $dbPermissions = Permission::all()->pluck('name')->all();

        foreach ($permissions as $index => $permission) {
            if (!in_array($permission, $dbPermissions)) {
                Permission::create([
                    'id'   => $index + 1,
                    'name' => $permission,
                ]);
            }//end if
        }//end foreach

        // Roles
        $roleAdmin   = Role::where('name', '系統管理員')->first();
        $roleAIAdmin = Role::where('name', 'AI管理員')->first();

        // Permissions for admin
        $permissionViewAdmin   = Permission::where('name', '檢視管理員')->first();
        $permissionCreateAdmin = Permission::where('name', '新增管理員')->first();
        $permissionEditAdmin   = Permission::where('name', '編輯管理員')->first();
        $permissionDeleteAdmin = Permission::where('name', '刪除管理員')->first();


        // 系統管理員 permissions
        $roleAdmin->givePermissionTo($permissionViewAdmin);
        $roleAdmin->givePermissionTo($permissionCreateAdmin);
        $roleAdmin->givePermissionTo($permissionEditAdmin);
        $roleAdmin->givePermissionTo($permissionDeleteAdmin);

        // AI管理員 permissions
        $roleAIAdmin->givePermissionTo($permissionViewAdmin);
        $roleAIAdmin->givePermissionTo($permissionCreateAdmin);
        $roleAIAdmin->givePermissionTo($permissionEditAdmin);
        $roleAIAdmin->givePermissionTo($permissionDeleteAdmin);
    }
}
