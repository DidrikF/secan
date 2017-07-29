<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SecurityOfInterest extends Model
{
	protected $table = 'securities_of_interest';

    protected $fillable = [
        'investor_profile_id', 'security_id', 'description',
    ];

    protected $hidden = [
    	'created_at', 'updated_at'
    ];

    public function investorProfile()
    {
    	return $this->belongsTo(InvestorProfile::class);
    }
}
