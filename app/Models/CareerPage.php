<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CareerPage extends Model
{
    protected $fillable = [
        'image_gallery',
        'video',
        'domain',
        'spontaneous_application'
    ];
}
