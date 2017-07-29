<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'username' => $faker->unique()->userName,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});


$factory->define(App\Models\InvestorProfile::class, function (Faker\Generator $faker) {
    return [
    	'user_id' => function() {
    		return factory(App\Models\User::class)->create()->id;
    	},
        'name' => 'Name of Profile',
        'profile_image' => 'image url',
        'investing_philosophy' => 'My investing philosophy in detail.',
        'knowledge_and_experience' => 'My knowledge and experience are...'
    ];
});

$factory->define(App\Models\InvestingGoal::class, function (Faker\Generator $faker) {
    return [
		'investor_profile_id' => function() {
			return factory(App\Models\InvestorProfile::class)->create()->id;
		},
		'text' => 'Example goal text',
		'type'	=> 'Example goal type',
		'quantitative_measure' => 100
    ];
});

$factory->define(App\Models\InvestingRule::class, function (Faker\Generator $faker) {
    return [
		'investor_profile_id' => function() {
			return factory(App\Models\InvestorProfile::class)->create()->id;
		},
		'text' => 'Example rule text',
		'type'	=> 'Example rule type',
		'quantitative_measure' => 200
    ];
});

$factory->define(App\Models\SecurityOfInterest::class, function (Faker\Generator $faker) {
    return [
		'investor_profile_id' => function() {
			return factory(App\Models\InvestorProfile::class)->create()->id;
		},
		'security_id' => function() {
			return factory(App\Models\Common\Security::class)->create()->id;
		},
		'description' => 'This is a description of my interest in this particular security'
    ];
});

$factory->define(App\Models\IndustryOfInterest::class, function (Faker\Generator $faker) {
    return [
		'investor_profile_id' => function() {
			return factory(App\Models\InvestorProfile::class)->create()->id;
		},
		'industry_id' => function() {
			return factory(App\Models\Common\Industry::class)->create()->id;
		},
		'description' => 'This is a description of my interest in this particular security'
    ];
});

$factory->define(App\Models\InvestingStrategy::class, function (Faker\Generator $faker) {
    return [
    	'investor_profile_id' => function() {
    		return factory(App\Models\InvestorProfile::class)->create()->id;
    	},
		'image' => 'image-url',
		'name' => 'Test Investing Strategy',
		'description' => 'Test Investing strategy built upon good old value investing principles.'
    ];
});

//

/*	
*	Common Objects
*/
$factory->define(App\Models\Common\Security::class, function (Faker\Generator $faker) {
    return [
    	'image' => 'image-url',
    	'type' => 'Stock',
    	'description' => 'A share of ownership in a company'
    ];
});

$factory->define(App\Models\Common\Industry::class, function (Faker\Generator $faker) {
    return [
    	'image' => 'image-url',
    	'name' => 'Software',
    	'description' => 'The software industry consists of companies developing and selling access to software.'
    ];
});

