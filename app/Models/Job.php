<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $fillable = [
        'title',
        'experience',
        'salary_offered',
        'timings',
        'job_type',
        'description'
    ];
}
