<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{User, InvestingRule, InvestorProfile};

class InvestingRuleController extends Controller
{
    public function show(User $user, InvestingRule $investingRule)
    {
    	$this->authorize([

    	]);

    	return response()->json($investingRule->toArray(), 200);
    }

    public function showAll(User $user)
    {
    	$investorProfile = InvestorProfile::where('user_id', $user->id)->firstOrFail();
    	$investingRules = InvestingRule::where('investor_profile_id', $investorProfile->id)->get();

    	return response()->json($investingRules->toArray(), 200);
    }

    public function create()
    {

    }

    public function update()
    {

    }

    public function delete() 
    {

    }
}
