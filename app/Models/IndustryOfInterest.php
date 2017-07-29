<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IndustryOfInterest extends Model
{
	protected $table = 'industries_of_interest';

    protected $fillable = [
        'investor_profile_id', 'industry_id', 'description',
    ];

    protected $hidden = [
    	'created_at', 'updated_at'
    ];

    public function investorProfile()
    {
    	return $this->belongsTo(InvestorProfile::class);
    }
}
