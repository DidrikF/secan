<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;



class AuthenticationTest extends TestCase
{
	use DatabaseMigrations;

	/** @test */
	function user_can_register_an_account()
	{  
		$response = $this->post('api/register', [
			'name' => 'John Example',
			'email' => 'john@example.com',
			'username' => 'UserJohn',
			'password' => 'secret'
		]);

		$response->assertStatus(200);

		$user = User::where('email', 'john@example.com')->where('username', 'UserJohn')->first();

		$this->assertEquals($user->name, $response->json()['data']['name']);
		$this->assertEquals($user->email, $response->json()['data']['email']);
		$this->assertEquals($user->username, $response->json()['data']['username']);
	}

	/** @test */
	function user_can_log_in_with_valid_credentials()
	{
		$this->disableExceptionHandling();
	    $user = factory(User::class)->create([
	    	'email' => 'john@test.com',
	    	'password' => bcrypt('secret')
	    ]);

	    $response = $this->post('api/login', [
	    	'email' => 'john@test.com',
	    	'password' => 'secret'
	    ]);
	    //dd($response);

	   	$this->assertTrue(Auth::check());
	   	$this->assertTrue(Auth::user()->is($user));

	}

	/** @test */
	function logging_in_returns_a_valid_jwt_token()
	{
	    $user = factory(User::class)->create([
	    	'email' => 'john@test.com',
	    	'password' => bcrypt('secret')
	    ]);

	    $response = $this->post('api/login', [
	    	'email' => 'john@test.com',
	    	'password' => 'secret'
	    ]);

	    $token = $response->json()['meta']['token'];

	    $response = $this->get('api/me', ['Authorization' => "Bearer {$token}"]);
	    
	    $response->assertStatus(200);

	}

	/** @test */
	function user_can_not_log_in_with_invalid_credentials()
	{
	   	$user = factory(User::class)->create([
	    	'email' => 'john@test.com',
	    	'password' => bcrypt('secret')
	    ]);

	    $response = $this->post('api/login', [
	    	'email' => 'john@test.com',
	    	'password' => 'wrong-password'
	    ]);

	    $response->assertStatus(401);
	    $response->assertJson([	//bad practice
	    	'errors' => [
	    		'root' => 'Could not sign you in with those details.'
	    	]
	    ]);
	}

	/** @test */
	function logging_in_with_an_accont_that_does_not_exist()
	{
	    $response = $this->post('api/login', [
	    	'email' => 'nonexistent_user@test.com',
	    	'password' => 'secret'
	    ]);

	    $response->assertStatus(401);
	    $response->assertJson([ //bad practice
	    	'errors' => [
	    		'root' => 'Could not sign you in with those details.'
	    	]
	    ]);
	}

	/** @test */
	function logging_out_the_current_user()
	{
		$this->disableExceptionHandling();
		$user = factory(User::class)->create([
	    	'email' => 'john@test.com',
	    	'password' => bcrypt('secret')
	    ]);

		$this->assertFalse(Auth::check());
	    
	    $response = $this->post('api/login', [
	    	'email' => 'john@test.com',
	    	'password' => 'secret'
	    ]);

	    $this->assertTrue(Auth::check());

	   	$token = $response->json()['meta']['token'];

	   	$response = $this->post('api/logout', [],  ['authorization' => "bearer {$token}"]);

	   	//$response = $this->call('POST', 'api/logout', [], [], [], ['Authorization' => "Bearer {$token}"], null);

	   	$isTokenValidResponse = $this->get('api/istokenvalid', ['Authorization' => "Bearer {$token}"]);

	   	$isTokenValidResponse->assertStatus(401);
	   	$this->assertFalse(Auth::check());
	}

	/** @test */
	function request_with_valid_jwt_token_is_accepted()
	{
	    $tokenAndUser = $this->getTokenAndLogedInUser();

	    dd($tokenAndUser['token']);

	    $response = $this->get('/api/istokenvalid', ['Authorization' => "Bearer {$tokenAndUser['token']}"]);

	    $response->assertStatus(200);
	}

	/** @test */
	function request_with_invalid_jwt_token_is_rejected()
	{
	    $invalidToken = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEsImlzcyI6Imh0dHA6Ly9zZWNhbi5hcHAvYXBpL2xvZ2luIiwiaWF0IjoxNTAwMzgyODc0LCJleHAiOjE1MDAzODY0NzQsIm5iZiI6MTUwMDM4Mjg3NCwianRpIjoiT3hZMDNiRWpqVWd5UkU5SCJ9.Us3nxTiCK15GdVRv95j2R1Vkc_xDqvvt2BS4y1NiP';  //2Y

	    $response = $this->get('/api/istokenvalid', ['Authorization' => "Bearer {$invalidToken}"]); 

	    $response->assertStatus(400); //should be 401
	}

	//tests for the rest of the JWT errors

	/** @test */
	function request_with_valid_token_but_unknow_user_id_returns_a_404()
	{
		$tokenAndUser = $this->getTokenAndLogedInUser();

		$tokenAndUser['user']->delete();

		$tokenWithNonexistingUser = $tokenAndUser['token'];

	    $response = $this->get('/api/istokenvalid', ['Authorization' => "Bearer {$tokenWithNonexistingUser}"]); 

	    $response->assertStatus(404);
	}

	/** @test */
	function request_with_token_not_provided_returns_a_400()
	{
	    $response = $this->get('/api/istokenvalid'); 

	    $response->assertStatus(400);
	}

	/** @test */
	function request_with_expired_token_returns_a_401()
	{
	    $expiredToken = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEsImlzcyI6Imh0dHA6Ly9zZWNhbi5hcHAvYXBpL2xvZ2luIiwiaWF0IjoxNTAwMzgyODczLCJleHAiOjE1MDAzODI4NzMsIm5iZiI6MTUwMDM4Mjg3MywianRpIjoiT3hZMDNiRWpqVWd5UkU5SCJ9.oRtS8uQTpghEPUgrDzxs4YFZ0s0pZyxM8cPtXaKiOIw';

	    $response = $this->get('/api/istokenvalid', ['Authorization' => "Bearer {$expiredToken}"]); 

	    $response->assertStatus(401);
	}



}