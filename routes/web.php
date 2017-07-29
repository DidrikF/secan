<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('frontpage');
});


Route::get('/app', 'LoadApplicationController@show');




/*

Route::domain('secan.app')->group(function () {
	Route::get('/', function () {
	    return view('frontpage');
	});
});


Route::domain('app.secan.app')->group(function () {
	Route::group(['middleware' => 'jwt.auth'], function () {
    	Route::get('/', 'LoadApplicationController@show');
    });
});
*/