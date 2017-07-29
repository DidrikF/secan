<?php

namespace Tests;

use App\Exceptions\Handler;
use App\Models\{User, InvestorProfile, InvestingGoal, InvestingRule, SecurityOfInterest, IndustryOfInterest, InvestingStrategy};
Use App\Models\Common\{Security, Industry};
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setup()
    {
        parent::setup();

        //\Mockery::getConfiguration()->allowMockingNonExistentMethods(false);
    }

    protected function disableExceptionHandling()
    {
    	$this->app->instance(ExceptionHandler::class, new Class extends Handler {
    		public function __construct() {}
    		public function report(\Exception $e) {}
    		public function render($request, \Exception $e) {
    			throw $e;
    		}
    	});
    }

    protected function createFakeInvestorProfile(User $user)
    {
        $security = factory(Security::class)->create();
        $industry = factory(Industry::class)->create();


        $investorProfile = factory(InvestorProfile::class)->create([
            'user_id' => $user->id
        ]);

        //goals
        $goal = factory(InvestingGoal::class)->create([
            'investor_profile_id' => $investorProfile->id
        ]);
        //rules
        $rule = factory(InvestingRule::class)->create([
            'investor_profile_id' => $investorProfile->id
        ]);
        //securities of interest
        $securityOfInterest = factory(SecurityOfInterest::class)->create([
            'investor_profile_id' => $investorProfile->id,
            'security_id' => $security->id
        ]);

        $industryOfInterest = factory(IndustryOfInterest::class)->create([
            'investor_profile_id' => $investorProfile->id,
            'industry_id' => $industry->id
        ]);

        $investingStrategy = factory(InvestingStrategy::class)->create([
            'investor_profile_id' => $investorProfile->id
        ]);
        //dd($investorProfile);
        return [
            'profile' => $investorProfile,
            //Could be collections, but not accounted for now
            'investingGoal' => $goal,
            'investingRule' => $rule,
            'securitiesOfInterest' => $securityOfInterest,
            'industriesOfInterest' => $industryOfInterest,
            'investingStrategies' => $investingStrategy,
            'securities' => $security,
            'industries' => $industry
        ];
    }

    protected function getTokenAndLogedInUser()
    {
        $user = factory(User::class)->create([
            'name' => 'John Johnson',
            'email' => 'john@test.com',
            'username' => 'UserJohn',
            'password' => bcrypt('secret')
        ]);

        $response = $this->post('/api/login', [
            'email' => 'john@test.com',
            'password' => 'secret'
        ]);

        return [
            'token' => $response->json()['meta']['token'],
            'user' => $user
        ];
    }

    protected function createUser()
    {
        return factory(User::class)->create([
            'name' => 'John Johnson',
            'email' => 'john@test.com',
            'username' => 'UserJohn',
            'password' => bcrypt('secret')
        ]);
    }

    protected function getToken(User $user)
    {
        $response = $this->post('/api/login', [
            'email' => $user->email,
            'password' => 'secret'
        ]);

        return $response->json()['meta']['token'];
    }
}
