<?php

use Illuminate\Http\Request;


Route::post('/register', 'Auth\AuthController@register');
Route::post('/login', 'Auth\AuthController@login');
Route::post('/logout', 'Auth\AuthController@logout');



Route::group(['middleware' => 'jwt.auth'], function () {
    Route::get('/user', 'Auth\AuthController@user');
    Route::get('/analysis', 'AnalysisController@show');
    Route::get('/{user}/investorprofile', 'InvestorProfileController@show');
    Route::get('/loadapplication', 'LoadApplicationController@show');
    Route::get('/istokenvalid', function() {
    	return response()->json([], 200);
    });	

    Route::get('/{user}/investingrule/{investingRule}', 'InvestingRuleController@show');
    Route::get('/{user}/investingrule', 'InvestingRuleController@showAll');
});



/*

Route::domain('secan.app')->group(function () {
	Route::post('/register', 'Auth\AuthController@register');
	Route::post('/login', 'Auth\AuthController@login');
	Route::post('/logout', 'Auth\AuthController@logout');

	Route::group(['middleware' => 'jwt.auth'], function () {
	    Route::get('/istokenvalid', function() {
	    	return response()->json([], 200);
	    });	
	});
});


Route::domain('app.secan.app')->group(function () {
	Route::group(['middleware' => 'jwt.auth'], function () {
	    Route::get('/user', 'Auth\AuthController@user');
	    Route::get('/analysis', 'AnalysisController@show');
	    Route::get('/{user}/investorprofile', 'InvestorProfileController@show');
	    Route::get('/loadapplication', 'LoadApplicationController@show');
	    Route::get('/istokenvalid', function() {
	    	return response()->json([], 200);
	    });	
	});
});

*/