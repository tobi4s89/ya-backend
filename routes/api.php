<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Max-Age:86400');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token,  Accept, Authorization, X-Requested-With');

// User resource
Route::get('/users', 'UserController@index');
Route::post('/users', 'UserController@store');
Route::delete('/users/{user}', 'UserController@destroy');

// Property resource
Route::get('/properties', 'PropertyController@index');
Route::post('/properties', 'PropertyController@store');
Route::delete('/properties/{property}', 'PropertyController@destroy');

// Calculate resource
Route::get('/calculate', 'AlgorithmController@calculate');
