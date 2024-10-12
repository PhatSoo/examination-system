<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Describe:  This table is designed to store `questions` for an `exam`.
//            The `answer_id` field is utilized to record the answers selected by the `user`.
class ExamQuestion extends Model
{
    use HasFactory;

    protected $table = 'exam_question';

    protected $fillable = [
        'exam_id',
        'question_id',
        'answer_id'
    ];
}