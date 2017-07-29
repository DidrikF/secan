<?php

use Illuminate\Database\Seeder;
use App\Models\{User, InvestorProfile, InvestingGoal, InvestingRule, SecurityOfInterest, IndustryOfInterest, InvestingStrategy};
Use App\Models\Common\{Security, Industry};

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$user = factory(User::class)->create([
            'name' => 'Didrik Fleischer',
            'email' => 'didrik@test.com',
            'username' => 'DidrikF',
            'password' => bcrypt('password123')
        ]);

        $security = factory(Security::class)->create([
        	'image' => 'image-url',
    		'type' => 'Stock',
    		'description' => 'A share of ownership in a company'
        ]);
        
        $industry = factory(Industry::class)->create([
        	'image' => 'image-url',
    		'name' => 'Software',
    		'description' => 'The software industry consists of companies developing and selling access to software.'
        ]);

        $investorProfile = factory(InvestorProfile::class)->create([
            'user_id' => $user->id,
            'name' => 'Name of Profile',
            'profile_image' => 'image url',
            'investing_philosophy' => 'My investing philosophy in detail.',
            'knowledge_and_experience' => 'My knowledge and experience are...'
        ]);

        //goals
        factory(InvestingGoal::class, 3)->create([
            'investor_profile_id' => $investorProfile->id,
            'text' => 'Example goal text',
            'type'  => 'Example goal type',
            'quantitative_measure' => 100
        ]);
        //rules
        factory(InvestingRule::class, 3)->create([
            'investor_profile_id' => $investorProfile->id,
            'text' => 'Example rule text',
            'type'  => 'Example rule type',
            'quantitative_measure' => 200
        ]);
        //securities of interest
        factory(SecurityOfInterest::class, 3)->create([
            'investor_profile_id' => $investorProfile->id,
            'security_id' => $security->id,
            'description' => 'This is a description of my interest in this particular security'
        ]);

        factory(IndustryOfInterest::class, 3)->create([
            'investor_profile_id' => $investorProfile->id,
            'industry_id' => $industry->id,
            'description' => 'This is a description of my interest in this particular security'
        ]);

        factory(InvestingStrategy::class, 3)->create([
            'investor_profile_id' => $investorProfile->id,
            'image' => 'image-url',
            'name' => 'Test Investing Strategy',
            'description' => 'Test Investing strategy built upon good old value investing principles.'
        ]);
    }
}
