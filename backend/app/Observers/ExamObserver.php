<?php

namespace App\Observers;

use App\Models\Exam;

class ExamObserver
{
    public function creating(Exam $exam) {
        $total_time = $exam->category->total_time;

        $exam->start_time = now();
        $start_time = $exam->start_time;
        $exam->end_time = $start_time->addMinutes($total_time);
    }
}