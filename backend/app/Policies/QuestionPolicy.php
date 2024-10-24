<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Question;
use Illuminate\Auth\Access\Response;

class QuestionPolicy
{
    public function before(User $user, string $ability) {
        if ($user->role->permissions->contains('name', 'full-access')) {
            return true;
        }

        return null;
    }

    public function create(User $user) {
        if ($user->role->permissions->contains('name', 'create-question-answer')) {
            return true;
        }

        return false;
    }

    public function manage(User $user, Question $question) {
        if ($user->role->permissions->contains('name', 'manage-own-question-answer')) {
            if ($user->id === $question->user_id) {
                return true;
            }
            return Response::denyWithStatus(403, "You have no permission to Edit|Delete other's Question or Answer");
        }
        return Response::denyWithStatus(403, 'You have no permission to perform this action.!');
    }
}