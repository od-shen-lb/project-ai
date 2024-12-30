<?php

namespace App\Policies;

use App\Models\Admin;

class ActivityPolicy
{
    public function viewAny(Admin $admin): bool
    {
        return $admin->hasRole('系統管理員');
    }

    public function view(Admin $admin): bool
    {
        return $admin->hasRole('系統管理員');
    }
}
