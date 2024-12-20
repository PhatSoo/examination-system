<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CategoryPolicy
{
    public function before(User $user) {
        if ($user->role->permissions->contains('name', 'full-access')) {
            return true;
        }

        return null;
    }

    public function create(User $user) {
        if ($user->role->hasPermission('create-category')) {
            return true;
        }

        return false;
    }

    public function manage(User $user, Category $category) {
        if ($user->role->hasPermission('manage-own-category')) {
            if ($user->id === $category->user_id) {
                return true;
            }

            return Response::denyWithStatus(403, "You have no permission to Edit|Delete other's Category");
        }
        return Response::denyWithStatus(403, 'You have no permission to perform this action.!');
    }
}