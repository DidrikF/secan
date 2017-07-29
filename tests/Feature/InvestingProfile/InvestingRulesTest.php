<?php
use App\Models\{InvestorProfile, InvestingRule, User};
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class InvestingRulesTest extends TestCase
{
	use DatabaseMigrations;

    /** @test */
    function user_can_get_an_investing_rule()
    {
    	$this->disableExceptionHandling();
        $user = $this->createUser();
        $token = $this->getToken($user);

        $investorProfile = factory(InvestorProfile::class)->create([
            'user_id' => $user->id,
            'name' => 'Name of Profile',
            'profile_image' => 'image url',
            'investing_philosophy' => 'My investing philosophy in detail.',
            'knowledge_and_experience' => 'My knowledge and experience are...'
        ]);

        $investingRule = factory(InvestingRule::class)->create([
        	'investor_profile_id' => $investorProfile->id,
        	'text' => 'test text',
        	'type' => 'test type',
        	'quantitative_measure' => '100'
        ]);

        $response = $this->get("/api/{$user->username}/investingrule/{$investingRule->id}", ['authorization' => "bearer {$token}"]);

        $response->assertStatus(200);

        $response->assertJson([
        	'id' => $investingRule->id,
        	'investor_profile_id' => $investorProfile->id,
        	'text' => 'test text',
        	'type' => 'test type',
        	'quantitative_measure' => '100'
        ]);

    }

    /** @test */
    function user_can_get_all_investing_rules()
    {
        $this->disableExceptionHandling();
        $user = $this->createUser();
        $token = $this->getToken($user);

        $investorProfile = factory(InvestorProfile::class)->create([
            'user_id' => $user->id,
            'name' => 'Name of Profile',
            'profile_image' => 'image url',
            'investing_philosophy' => 'My investing philosophy in detail.',
            'knowledge_and_experience' => 'My knowledge and experience are...'
        ]);

        $investingRules = factory(InvestingRule::class, 3)->create([
        	'investor_profile_id' => $investorProfile->id,
        	'text' => 'test text',
        	'type' => 'test type',
        	'quantitative_measure' => '100'
        ]);

        $response = $this->get("/api/{$user->username}/investingrule", ['authorization' => "bearer {$token}"]);

        $response->assertStatus(200);

        $response->assertJson([[
        	'id' => $investingRules[0]->id,
        	'investor_profile_id' => $investorProfile->id,
        	'text' => 'test text',
        	'type' => 'test type',
        	'quantitative_measure' => '100'
        ],
        [
        	'id' => $investingRules[1]->id,
        	'investor_profile_id' => $investorProfile->id,
        	'text' => 'test text',
        	'type' => 'test type',
        	'quantitative_measure' => '100'
        ],
        [
        	'id' => $investingRules[2]->id,
        	'investor_profile_id' => $investorProfile->id,
        	'text' => 'test text',
        	'type' => 'test type',
        	'quantitative_measure' => '100'
        ]]);

    }

    /** @test */
    function user_can_only_get_investing_rules_that_belongs_to_him()
    {
        $this->disableExceptionHandling();
        $john = factory(User::class)->create([
        	'name' => 'John',
        	'username' => 'John',
        	'email' => 'john@example.com',
        	'password' => bcrypt('secret')
        ]);

        $tom = factory(User::class)->create([
        	'name' => 'Tom',
        	'username' => 'Tom',
        	'email' => 'tom@example.com',
        	'password' => bcrypt('secret')
        ]);

        $investorProfile = factory(InvestorProfile::class)->create([
            'user_id' => $tom->id,
            'name' => 'Name of Profile',
            'profile_image' => 'image url',
            'investing_philosophy' => 'My investing philosophy in detail.',
            'knowledge_and_experience' => 'My knowledge and experience are...'
        ]);

        $investingRule = factory(InvestingRule::class)->create([
        	'investor_profile_id' => $investorProfile->id,
        	'text' => 'test text',
        	'type' => 'test type',
        	'quantitative_measure' => '100'
        ]);

        $token = $this->getToken($john);

        $response = $this->get("/api/{$tom->username}/investingrule/{$investingRule->id}", ['authorization' => "bearer {$token}"]);

        $response->assertStatus(401);

        $response->assertJson([]);

    }

    /** @test */
    function user_can_create_an_investing_rule()
    {
        
    }

    /** @test */
    function user_can_update_an_investing_rule()
    {
        
    }

    /** @test */
    function user_can_delete_an_investing_rule()
    {
        
    }
}