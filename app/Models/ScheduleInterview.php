<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduleInterview extends Model
{
    protected $fillable = [
        'date',
        'time',
        'application_id'
    ];
}
