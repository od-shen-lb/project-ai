<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        if (is_null(Admin::first())) {
            $admins = [
                [
                    'name'  => 'OD',
                    'email' => 'od.shen@getoken.io',
                ],
            ];

            $roleAdmin = Role::where('name', '系統管理員')->first();

            foreach ($admins as $admin) {
                $createdUser = Admin::create([
                    'name'         => $admin['name'],
                    'email'        => $admin['email'],
                    'password'     => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                    'is_activated' => true,
                ]);

                $createdUser->assignRole($roleAdmin);
            }//end foreach
        }//end if
    }
}
