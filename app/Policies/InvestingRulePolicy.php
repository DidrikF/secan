<?php

namespace App\Policies;

use App\Models\{User, InvestingRule, InvestingProfile};
use Illuminate\Auth\Access\HandlesAuthorization;

class InvestingRulePolicy
{
    use HandlesAuthorization;

    public function show(User $user, InvestingRule $investingRule)
    {
        $investingProfile = InvestingProfile::where('user_id', $user->id)->first();
        return $investingProfile->id === $investingRule->investor_profile_id;
    }

    public function showAll(User $user, InvestingRule $investingRule)
    {
        $investingProfile = InvestingProfile::where('user_id', $user->id)->first();
        return $investingProfile->id === $investingRule->investor_profile_id;
    }

    public function create(User $user)
    {
        return is_null(InvestingProfile::where('user_id', $user->id)->first());
    }

    public function update(User $user, InvestingRule $investingRule)
    {
        $investingProfile = InvestingProfile::where('user_id', $user->id)->first();
        return $investingProfile->id === $investingRule->investor_profile_id;
    }

    public function delete(User $user, InvestingRule $investingRule)
    {
        $investingProfile = InvestingProfile::where('user_id', $user->id)->first();
        return $investingProfile->id === $investingRule->investor_profile_id;
    }
}
