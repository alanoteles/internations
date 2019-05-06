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

Route::group(['middleware' => ['auth:api', 'admin_only']], function() {

    // Only Admin has permission to manage Users
    Route::resource('users', 'UserController');

    // Only Admin has permission to create new users
    Route::post('users', 'Auth\RegisterController@register');

    // Only Admin has permission to manage Groups
//    Route::resource('groups', 'GroupController');
    Route::post('groups/{group}/user/{id}/add', 'GroupController@addUser');
    Route::post('groups/{group}/user/{id}/remove', 'GroupController@removeUser');

});


Route::group(['middleware' => ['auth:api']], function() {

    // User must be logged in to logout
    Route::post('logout', 'Auth\LoginController@logout');

});


Route::post('login', 'Auth\LoginController@login');