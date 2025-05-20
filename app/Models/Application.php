<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable = [
        'name',
        'email',
        'contact_via',
        'consent',
        'CV',
        'company_name',
        'job_role',
        'ATA_score',
        'status',
        'job_id'
    ];
}
