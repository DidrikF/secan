<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvestingStrategy extends Model
{
    protected $fillable = [
        'investor_profile_id', 'image', 'name', 'description',
    ];

    protected $hidden = [
    	'created_at', 'updated_at'
    ];

    public function investorProfile()
    {
    	return $this->belongsTo(InvestorProfile::class);
    }
}
