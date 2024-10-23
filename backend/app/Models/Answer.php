<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_id',
        'title',
        'is_correct',
        'type'
    ];

    // Relationships
    public function question() {
        return $this->belongsTo(Question::class);
    }

    // Custom Method
    public function checkValid() {
        $has_correct_answer = $this->question->checkHasCorrectAnswer();

        return $has_correct_answer;
    }
}