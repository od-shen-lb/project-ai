<?php

namespace Database\Seeders\Develop;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        if (is_null(Admin::first())) {
            $users = [
                [
                    'name'  => '系統管理員',
                    'email' => 'admin1@test.com',
                    'roles' => '系統管理員',
                ],
                [
                    'name'  => 'AI管理員',
                    'email' => 'ai-admin1@test.com',
                    'roles' => 'AI管理員',
                ],
            ];

            foreach ($users as $user) {
                $createdUser = Admin::create([
                    'name'     => $user['name'],
                    'email'    => $user['email'],
                    'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                ]);

                $createdUser->assignRole($user['roles']);
            }//end foreach
        }//end if
    }
}
