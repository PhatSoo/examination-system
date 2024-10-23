<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'image_url',
        'difficulty',
        'category_id',
        'user_id'
    ];

    // Relationships
    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function answers() {
        return $this->hasMany(Answer::class);
    }

    // Custom method
    public function checkHasCorrectAnswer() {
        return $this->answers->contains('is_correct', true);
    }
}