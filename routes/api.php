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


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', 'Auth\RegisterController@register');


Route::group(['middleware' => ['auth:api', 'admin_only']], function() {

    // Only Admin has permission to create new users


    // Only Admin has permission to manage Groups
    Route::get('groups', 'GroupController@index');
    Route::get('groups/{group}', 'GroupController@show');
    Route::post('groups', 'GroupController@store');
    Route::put('groups/{group}', 'GroupController@update');
    Route::delete('groups/{group}', 'GroupController@delete');

});

Route::group(['middleware' => ['auth:api']], function() {

    // User must be logged in to logout
    Route::post('logout', 'Auth\LoginController@logout');

});


Route::post('login', 'Auth\LoginController@login');