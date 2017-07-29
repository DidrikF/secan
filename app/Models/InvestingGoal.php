<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvestingGoal extends Model
{
    protected $fillable = [
        'investor_profile_id', 'text', 'type', 'quantitative_measure',
    ];

    protected $hidden = [
    	'created_at', 'updated_at'
    ];

    public function investorProfile()
    {
    	return $this->belongsTo(InvestorProfile::class);
    }
}
