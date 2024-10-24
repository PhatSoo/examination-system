<?php

namespace App\Policies;

use App\Models\User;

class ExamPolicy
{
    public function before(User $user) {
        if ($user->role->permissions->contains('name', 'full-access')) {
            return true;
        }

        return null;
    }

    public function viewByUserId(User $user) {
        if ($user->role->hasPermission('view-own-category-result')) {

        }
    }
}