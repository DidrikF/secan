<?php

namespace Tests\Feature;

use App\Models\{User, InvestorProfile, InvestingGoal, InvestingRule, SecurityOfInterest, IndustryOfInterest, InvestingStrategy};
Use App\Models\Common\{Security, Industry};
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class InvestorProfileTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function user_can_load_initial_application_data()
    {
        $tokenAndUser = $this->getTokenAndLogedInUser();
        $token = $tokenAndUser['token'];
        $user = $tokenAndUser['user'];

        $investorProfile = $this->createFakeInvestorProfile($user);

        $response = $this->get('api/loadapplication', ['Authorization' => "Bearer {$token}"]);

        $response->assertStatus(200);

        $response->assertJson([
            'investorProfile' => [
                'investor_profile' => [
                    'user_id' => $user->id,
                    'name' => 'Name of Profile',
                    'profile_image' => 'image url',
                    'investing_philosophy' => 'My investing philosophy in detail.',
                    'knowledge_and_experience' => 'My knowledge and experience are...'
                ]
            ]
        ]);
        $response->assertJson([
            'investorProfile' => [
                'investing_rules' => [[
                    'investor_profile_id' => $investorProfile['profile']->id,
                    'text' => 'Example rule text',
                    'type'  => 'Example rule type',
                    'quantitative_measure' => 200
                ]]
            ]
        ]);

        $response->assertJson([
            'investorProfile' => [
                'investing_goals' => [[
                    'investor_profile_id' => $investorProfile['profile']->id,
                    'text' => 'Example goal text',
                    'type'  => 'Example goal type',
                    'quantitative_measure' => 100
                ]]
            ]
        ]);

        $response->assertJson([
            'investorProfile' => [
                'securities_of_interest' => [[
                    'security_info' => [
                        'id' => $investorProfile['securities']->id,
                        'type' => $investorProfile['securities']->type,
                        'description' => $investorProfile['securities']->description,
                        'image' => $investorProfile['securities']->image
                    ],
                    'description' => 'This is a description of my interest in this particular security',
                ]]
            ]
        ]);

        $response->assertJson([
            'investorProfile' => [
                'industries_of_interest' => [[
                    'industry_info' => [
                        'id' => $investorProfile['industries']->id,
                        'name' => $investorProfile['industries']->name,
                        'description' => $investorProfile['industries']->description,
                        'image' => $investorProfile['industries']->image
                    ],
                    'description' => 'This is a description of my interest in this particular security'
                ]]
            ]
        ]);

        $response->assertJson([
            'investorProfile' => [
                'investing_strategies' => [[
                    'id' => $investorProfile['investingStrategies']->id,
                    'investor_profile_id' => $investorProfile['profile']->id,
                    'description' => 'Test Investing strategy built upon good old value investing principles.',
                    'name' => 'Test Investing Strategy',
                    'image' => 'image-url'
                ]]
            ]
        ]);

        $response->assertJson([
            'user' => $user->toArray()
        ]);


    }

    /** @test */
    function loading_application_for_user_with_no_investor_profile_will_return_a_valid_response()
    {
        $this->disableExceptionHandling();
        $user = $this->createUser();

        $token = $this->getToken($user);

        $response = $this->get('api/loadapplication', ['Authorization' => "Bearer {$token}"]);

        $response->assertStatus(200);

        $response->assertJson([
            'user' => $user->toArray()
        ]);

    }


}

