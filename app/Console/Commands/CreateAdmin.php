<?php

namespace App\Console\Commands;

use App\Models\Admin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class CreateAdmin extends ValidatesCommand
{
    protected $signature = 'app:create-admin
                           {--name= : the admin name}
                           {--email= : the admin email}
                           {--role= : the admin role}';

    protected $description = 'Create a new admin user';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $role = $this->option('role');

        if (is_null($role)) {
            $this->error('roleOptionRequired');

            return self::FAILURE;
        }//end if

        if (Role::where('name', $role)->doesntExist()) {
            $this->error('roleNotFound');

            return self::FAILURE;
        }//end if

        try {
            // password
            $password = 'password';
            $admin    = $this->createAdminUser($role, $password);

            $this->info('Admin created successfully!');
            $this->info("Admin ID: {$admin->id}");
            $this->info("Admin Name: {$admin->name}");
            $this->info("Admin Email: {$admin->email}");
            $this->info("Admin Password: {$password}");
            $this->info("Admin Role: {$role}");

            return self::SUCCESS;
        } catch (\Exception $e) {
            $this->error($e->getMessage());

            return self::FAILURE;
        }//end try
    }

    protected function createAdminUser(string $role, string $password): Admin
    {
        return DB::transaction(function () use ($role, $password) {
            $admin = Admin::create([
                'name'     => $this->option('name'),
                'email'    => $this->option('email'),
                'password' => Hash::make($password),
            ]);

            $admin->assignRole($role);

            return $admin;
        });
    }

    protected function rules(): array
    {
        return [
            'email' => 'required|email|unique:admins,email',
            'name'  => 'required|string',
            'role'  => 'required',
        ];
    }
}
