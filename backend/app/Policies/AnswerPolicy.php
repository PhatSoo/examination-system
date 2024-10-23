<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Answer;

class AnswerPolicy
{
    public function before(User $user, string $ability) {
        if ($user->role->permissions->contains('name', 'full-access')) {
            return true;
        }

        return null;
    }

    public function create(User $user) {
        if ($user->role->permissions->contains('name', 'create-answer')) {
            return true;
        }

        return false;
    }

    public function manage(User $user, Answer $answer) {
        if ($user->role->permissions->contains('name', 'edit-delete-own-answer')) {
            if ($user->id === $answer->question->user_id) {
                return true;
            }

            return Response::denyWithStatus(403, "You have no permission to Edit|Delete other's Answer");
        }
        return Response::denyWithStatus(403, 'You have no permission to perform this action.!');
    }
}