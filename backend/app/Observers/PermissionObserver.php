<?php

namespace App\Observers;

use Illuminate\Support\Str;

use App\Models\Permission;

class PermissionObserver
{

    public function creating(Permission $permission): void {
        $permission->key = Str::of($permission->name)->slug('-');
    }

    public function updating(Permission $permission): void {
        $permission->key = Str::of($permission->name)->slug('-');
    }

}
