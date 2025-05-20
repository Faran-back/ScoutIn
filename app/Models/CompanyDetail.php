<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyDetail extends Model
{
    protected $fillable = [
        'company_logo',
        'company_name',
        'company_webiste',
        'number_of_employees',
        'industry',
        'country',
        'social_media',
        'about_your_company',
        'mission',
        'benefits',
        'values',
    ];
}
