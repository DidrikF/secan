<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvestorProfile extends Model
{
    protected $fillable = [
        'name', 'profile_image', 'investing_philosophy', 'knowledge_and_experience',
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function investingGoals()
    {
        return $this->hasMany(InvestingGoal::class);
    }

    public function investingRules()
    {
        return $this->hasMany(InvestingRule::class);
    }

    public function investingStrategies()
    {
        return $this->hasMany(InvestingStrategy::class);
    }

    public function industriesOfInterest()
    {
        return $this->hasMany(IndustryOfInterest::class);
    }

    public function securitiesOfInterest()
    {
        return $this->hasMany(SecurityOfInterest::class);
    }
}
