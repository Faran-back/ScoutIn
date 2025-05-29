<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Integration extends Model
{
     protected $fillable = [
        'linkedin_company_profile_url',
        'user_id'
    ];
    
    public function user(){
        return $this->belongsTo(User::class);
    }
}
