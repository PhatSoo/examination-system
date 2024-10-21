<?php

namespace App\Policies;
use App\Models\User;

class ExamPolicy
{
    public function manage(User $user) {
        dd(1);
    }
}