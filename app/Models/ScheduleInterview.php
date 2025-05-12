<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduleInterview extends Model
{
    protected $fillable = [
        'date',
        'day',
        'year',
        'application_id'
    ];
}
