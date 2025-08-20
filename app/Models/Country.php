<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = ['name', 'active'];
    protected $table = 'countries';

    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
