<?php

use Illuminate\Http\Request;

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

//Route::group(['middleware' => ['admin_only']], function() {

//});

Route::group(['middleware' => ['auth:api', 'admin_only']], function() {

    // Only Admin has permission to create new users
    Route::post('register', 'Auth\RegisterController@register');

    // Only Admin has permission to manage Groups
//    Route::get('groups', 'GroupController@index');
//    Route::get('groups/{group}', 'GroupController@show');
//    Route::post('groups', 'GroupController@store');
//    Route::put('groups/{group}', 'GroupController@update');
//    Route::delete('groups/{group}', 'GroupController@delete');

//    Route::delete('users/{id}', 'UserController@destroy');
    Route::resource('users', 'UserController');
    Route::resource('groups', 'GroupController');

});

Route::group(['middleware' => ['auth:api']], function() {

    // User must be logged in to logout
    Route::post('logout', 'Auth\LoginController@logout');

});


Route::post('login', 'Auth\LoginController@login');