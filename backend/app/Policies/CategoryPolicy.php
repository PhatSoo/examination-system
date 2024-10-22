<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CategoryPolicy
{
    public function before(User $user, string $ability) {
        if ($user->role->permissions->contains('name', 'full-access')) {
            return true;
        }

        return null;
    }

    public function create(User $user) {
        if ($user->role->permissions->contains('name', 'create-category')) {
            return true;
        }

        return false;
    }

    public function manage(User $user, Category $category) {
        if ($user->role->permissions->contains('name', 'edit-delete-own-category')) {
            if ($user->id === $category->user_id) {
                return true;
            }

            return Response::denyWithStatus(403, "You have no permission to Edit|Delete other's Category");
        }
        return Response::denyWithStatus(403, 'You have no permission to perform this action.!');
    }

    public function manageQuestionAnswer(User $user, Category $category) {
        if ($user->role->permissions->contains('name', 'edit-delete-own-question-answer')) {
            if ($user->id === $category->user_id) {
                return true;
            }

            return Response::denyWithStatus(403, "You have no permission to Edit|Delete Question in other's Category");
        }
        return Response::denyWithStatus(403, 'You have no permission to perform this action.!');
    }
}