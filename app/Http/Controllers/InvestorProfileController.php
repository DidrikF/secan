<?php

namespace App\Http\Controllers;

use App\Models\{User, InvestorProfile, InvestingRule, InvestingGoal, SecurityOfInterest, IndustryOfInterest};
use App\Models\Common\{Security, Industry};
use Illuminate\Http\Request;


class InvestorProfileController extends Controller
{
    public function show(User $user) 
    {   
        $investorProfile = null;
        $investingGoals = null;
        $investingRules = null;
        $investingStrategies = null;
        $securitiesOfInterest = null;
        $industriesOfInterest = null;

        $profile = InvestorProfile::where('user_id', $user->id)->first();

        if(!is_null($profile)) {
            $profileCopy = clone $profile;

            $s = $profileCopy->securitiesOfInterest->map(function ($element) {
                return [
                    'security_info' => Security::where('id', $element->security_id)->first()->toArray(),
                    'description' => $element->description
                ];
            });

            $i = $profileCopy->industriesOfInterest->map(function ($element) {
                return [
                    'industry_info' => Industry::where('id', $element->industry_id)->first()->toArray(),
                    'description' => $element->description
                ];
            });

            $investorProfile = $profile->toArray();
            $investingGoals = $profile->investingGoals ? $profile->investingGoals->toArray() : null;
            $investingRules = $profile->investingRules ? $profile->investingRules->toArray() : null;
            $investingStrategies = $profile->investingStrategies ? $profile->investingStrategies->toArray() : null;
            $securitiesOfInterest = $s ? $s->toArray() : null;
            $industriesOfInterest = $i ? $i->toArray() : null;

        }
        //return response()->json(['error' => 'The server was unable to load the application data'], 400);

        return response()->json([
            'investor_profile' => $investorProfile,
            'investing_goals' => $investingGoals,
            'investing_rules' => $investingRules,
            'investing_strategies' => $investingStrategies,
            'securities_of_interest' => $securitiesOfInterest,
            'industries_of_interest' => $industriesOfInterest, 
        ], 200);
    }

    public function create(Request $request)
    {

    }

    public function update()
    {

    }

    public function delete()
    {

    }
}
