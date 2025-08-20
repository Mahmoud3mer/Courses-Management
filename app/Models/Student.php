<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'address',
        'email',
        'notes',
        'national_id',
        'gender',
        'image',
        'country_id',
        'active',
    ];
    protected $table = 'students';

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function trainingCourses()
    {
        return $this->belongsToMany(TrainingCourse::class, 'training_courses_enrolments');
    }
}
