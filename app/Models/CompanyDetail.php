<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyDetail extends Model
{
    protected $fillable = [
        'user_id',
        'company_logo',
        'company_name',
        'company_website',
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
