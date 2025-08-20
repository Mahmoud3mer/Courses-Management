<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainingCourse extends Model
{
    protected $fillable = [
        'course_id',
        'start_date',
        'end_date',
        'price',
        'note',
    ];

    protected $table = 'training_courses';

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'training_courses_enrolments');
    }
}
