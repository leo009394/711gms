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

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');

    Route::group([
        'middleware' => 'auth:api'
    ], function () {
        Route::delete('logout', 'AuthController@logout');
        Route::get('me', 'AuthController@user');
    });

});

Route::get('users', 'UserController@index')->name('list:user')->middleware(['auth:api', 'scopes:*,list-user']);
Route::post('users', 'UserController@register')->name('create:user')->middleware(['auth:api', 'scopes:*,create-user']);
Route::get('users/{uuid}', 'UserController@show')->name('show:user')->middleware(['auth:api', 'scopes:*,show-user']);
Route::put('users/{uuid}', 'UserController@update')->name('update:user')->middleware(['auth:api', 'scopes:*,update-user']);
Route::get('stores', 'StoreController@index')->name('list:store')->middleware(['auth:api', 'scopes:*,list-store']);;
Route::post('stores', 'StoreController@register')->name('create:store')->middleware(['auth:api', 'scopes:*,create-user']);
Route::get('stores/{uuid}', 'StoreController@show')->name('show:store')->middleware(['auth:api', 'scopes:*,show-store']);
Route::put('stores/{uuid}', 'StoreController@update')->name('update:store')->middleware(['auth:api', 'scopes:*,update-store']);
