<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainingCourseEnrolment extends Model
{
    protected $fillable = [
        'student_id',
        'training_course_id',
        'enrolment_date',
    ];

    protected $table = 'training_courses_enrolments';
}
