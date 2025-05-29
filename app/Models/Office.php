<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
     protected $fillable = [
        'office_name',
        'street_name',
        'house_number',
        'country',
        'is_default',
        'user_id',
    ];





}
