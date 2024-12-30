<?php

namespace App\Policies;

use App\Models\Admin;

class AdminPolicy
{
    public function viewAny(Admin $admin): bool
    {
        return $admin->hasRole('系統管理員');
    }

    public function view(Admin $admin): bool
    {
        return $admin->hasRole('系統管理員');
    }

    public function create(Admin $admin): bool
    {
        return $admin->hasRole('系統管理員');
    }

    public function update(Admin $admin, Admin $model): bool
    {
        return $admin->hasRole('系統管理員');
    }

    public function delete(Admin $admin, Admin $model): bool
    {
        return $admin->hasRole('系統管理員');
    }

    public function restore(Admin $admin, Admin $model): bool
    {
        return $admin->hasRole('系統管理員');
    }
}
