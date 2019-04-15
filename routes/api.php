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

// User resource
Route::get('/users', 'UserController@index')->middleware(\Barryvdh\Cors\HandleCors::class);
Route::post('/users', 'UserController@store')->middleware(\Barryvdh\Cors\HandleCors::class);
Route::delete('/users/{user}', 'UserController@destroy')->middleware(\Barryvdh\Cors\HandleCors::class);

// Property resource
Route::get('/properties', 'PropertyController@index')->middleware(\Barryvdh\Cors\HandleCors::class);
Route::post('/properties', 'PropertyController@store')->middleware(\Barryvdh\Cors\HandleCors::class);
Route::delete('/properties/{property}', 'PropertyController@destroy')->middleware(\Barryvdh\Cors\HandleCors::class);

// Calculate resource
Route::get('/calculate', 'AlgorithmController@calculate')->middleware(\Barryvdh\Cors\HandleCors::class);
