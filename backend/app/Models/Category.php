<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id'
    ];

    // Relationships
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function questions() {
        return $this->hasMany(Question::class);
    }

    // Custom method
    private function countQuestions() {
        return $this->questions->count();
    }

    public function checkEnoughQuestions() {
        $max_questions = $this->num_question;
        $total_questions = $this->countQuestions();

        return $total_questions >= $max_questions;
    }
}