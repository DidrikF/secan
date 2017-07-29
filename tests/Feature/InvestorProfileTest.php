<?php

namespace Tests\Feature;

use App\Models\{User, InvestorProfile, InvestingGoal, InvestingRule, SecurityOfInterest, IndustryOfInterest, InvestingStrategy};
Use App\Models\Common\{Security, Industry};
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;
use Illuminate\Support\Facades\Auth;

class InvestorProfileTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function user_can_view_his_investor_profile()
    {
        $user = factory(User::class)->create([
            'email' => 'john@test.com',
            'username' => 'UserJohn',
            'password' => bcrypt('secret')
        ]);

        $security = factory(Security::class)->create();
        $industry = factory(Industry::class)->create();

        $investorProfile = factory(InvestorProfile::class)->create([
            'user_id' => $user->id,
            'name' => 'Name of Profile',
            'profile_image' => 'image url',
            'investing_philosophy' => 'My investing philosophy in detail.',
            'knowledge_and_experience' => 'My knowledge and experience are...'
        ]);

        //goals
        $goal = factory(InvestingGoal::class)->create([
            'investor_profile_id' => $investorProfile->id,
            'text' => 'Example goal text',
            'type'  => 'Example goal type',
            'quantitative_measure' => 100
        ]);
        //rules
        $rule = factory(InvestingRule::class)->create([
            'investor_profile_id' => $investorProfile->id,
            'text' => 'Example rule text',
            'type'  => 'Example rule type',
            'quantitative_measure' => 200
        ]);
        //securities of interest
        $securityOfInterest = factory(SecurityOfInterest::class)->create([
            'investor_profile_id' => $investorProfile->id,
            'security_id' => $security->id,
            'description' => 'This is a description of my interest in this particular security'
        ]);

        $industryOfInterest = factory(IndustryOfInterest::class)->create([
            'investor_profile_id' => $investorProfile->id,
            'industry_id' => $industry->id,
            'description' => 'This is a description of my interest in this particular security'
        ]);

        $investingStrategy = factory(InvestingStrategy::class)->create([
            'investor_profile_id' => $investorProfile->id,
            'image' => 'image-url',
            'name' => 'Test Investing Strategy',
            'description' => 'Test Investing strategy built upon good old value investing principles.'
        ]);


        $loginResponse = $this->post('api/login', [
            'email' => 'john@test.com',
            'password' => 'secret'
        ]);

        $this->assertTrue(Auth::check());

        $token = $loginResponse->json()['meta']['token'];

        
        $response = $this->get("api/{$user->username}/investorprofile", ['authorization' => "bearer {$token}"]);

        $response->assertStatus(200);

        $response->assertJson([
            'investor_profile' => [
                'user_id' => $user->id,
                'name' => 'Name of Profile',
                'profile_image' => 'image url',
                'investing_philosophy' => 'My investing philosophy in detail.',
                'knowledge_and_experience' => 'My knowledge and experience are...'
            ]
        ]);
        $response->assertJson([
            'investing_rules' => [[
                'investor_profile_id' => $investorProfile->id,
                'text' => 'Example rule text',
                'type'  => 'Example rule type',
                'quantitative_measure' => 200
            ]]
        ]);

        $response->assertJson([
            'investing_goals' => [[
                'investor_profile_id' => $investorProfile->id,
                'text' => 'Example goal text',
                'type'  => 'Example goal type',
                'quantitative_measure' => 100
            ]]
        ]);

        $response->assertJson([
            'securities_of_interest' => [[
                'security_info' => [
                    'id' => $security->id,
                    'type' => $security->type,
                    'description' => $security->description,
                    'image' => $security->image
                ],
                'description' => 'This is a description of my interest in this particular security',
            ]]
        ]);

        $response->assertJson([  
            'industries_of_interest' => [[
                'industry_info' => [
                    'id' => $industry->id,
                    'name' => $industry->name,
                    'description' => $industry->description,
                    'image' => $industry->image
                ],
                'description' => 'This is a description of my interest in this particular security'
            ]]
        ]);

        $response->assertJson([
            'investing_strategies' => [[
                'id' => $investingStrategy->id,
                'investor_profile_id' => $investorProfile->id,
                'description' => 'Test Investing strategy built upon good old value investing principles.',
                'name' => 'Test Investing Strategy',
                'image' => 'image-url'
            ]]
        ]);
    }

    /** @test */
    function user_without_an_invsetor_profile_will_get_a_valid_response()
    {
        $user = $this->createUser();
        $token = $this->getToken($user); 

        $response = $this->get("api/{$user->username}/investorprofile", ['authorization' => "bearer {$token}"]);

        $response->assertStatus(200);

        $response->assertJson([
            'investor_profile' => null,
            'investing_goals' => null,
            'investing_rules' => null,
            'investing_strategies' => null,
            'securities_of_interest' => null,
            'industries_of_interest' => null
        ]);
    }

    /** @test */
    function user_with_an_investor_profile_but_no_associated_data_will_get_a_valid_response()
    {
        $user = $this->createUser();
        $token = $this->getToken($user); 

        $investorProfile = factory(InvestorProfile::class)->create([
            'user_id' => $user->id,
            'name' => 'Name of Profile',
            'profile_image' => 'image url',
            'investing_philosophy' => 'My investing philosophy in detail.',
            'knowledge_and_experience' => 'My knowledge and experience are...'
        ]);

        $response = $this->get("api/{$user->username}/investorprofile", ['authorization' => "bearer {$token}"]);

        $response->assertStatus(200);

        $response->assertJson([
            'investor_profile' => [
                'user_id' => $user->id,
                'name' => 'Name of Profile',
                'profile_image' => 'image url',
                'investing_philosophy' => 'My investing philosophy in detail.',
                'knowledge_and_experience' => 'My knowledge and experience are...'
            ],
            'investing_goals' => null,
            'investing_rules' => null,
            'investing_strategies' => null,
            'securities_of_interest' => null,
            'industries_of_interest' => null
        ]);
    }

    /** @test */
    function user_with_an_investor_profile_and_a_securit_of_interest_will_get_a_valid_response()
    {
        $user = $this->createUser();
        $token = $this->getToken($user); 

        $investorProfile = factory(InvestorProfile::class)->create([
            'user_id' => $user->id,
            'name' => 'Name of Profile',
            'profile_image' => 'image url',
            'investing_philosophy' => 'My investing philosophy in detail.',
            'knowledge_and_experience' => 'My knowledge and experience are...'
        ]);

        $security = factory(Security::class)->create();

        $securityOfInterest = factory(SecurityOfInterest::class)->create([
            'investor_profile_id' => $investorProfile->id,
            'security_id' => $security->id,
            'description' => 'This is a description of my interest in this particular security'
        ]);

        $response = $this->get("api/{$user->username}/investorprofile", ['authorization' => "bearer {$token}"]);

        $response->assertStatus(200);

        $response->assertJson([
            'investor_profile' => [
                'user_id' => $user->id,
                'name' => 'Name of Profile',
                'profile_image' => 'image url',
                'investing_philosophy' => 'My investing philosophy in detail.',
                'knowledge_and_experience' => 'My knowledge and experience are...'
            ],
            'investing_goals' => null,
            'investing_rules' => null,
            'investing_strategies' => null,
            'securities_of_interest' => [[
                'security_info' => [
                    'id' => $security->id,
                    'type' => $security->type,
                    'description' => $security->description,
                    'image' => $security->image
                ],
                'description' => 'This is a description of my interest in this particular security',
            ]],
            'industries_of_interest' => null
        ]);
    }

    /** @test */
    public function user_can_create_an_investor_profile()
    {

    }

    /** @test */
    public function user_can_publish_his_investor_profile()
    {

    }

    /** @test */
    public function user_can_unpublish_his_investor_profile()
    {

    }

    /** @test */
    public function user_can_update_his_investor_profile()
    {

    }

    /** @test */
    public function user_can_delete_his_investor_profile()
    {

    }



}


/*
factory(App\User::class, 50)->create()->each(function($u) {
    $u->posts()->save(factory(App\Post::class)->make());
});


*/


