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

Route::post('registration', 'Api\UserController@store');
Route::get('destroy/{id}', 'Api\UserController@destroy');

Route::middleware(['auth:api'])->group(function () {
    Route::post('roles', 'Api\RoleController@store');
    Route::put('roles/{id}', 'Api\RoleController@update');
    Route::get('roles', 'Api\RoleController@getRolesPaginate');
    Route::delete('roles/{id}', 'Api\RoleController@destroy');
    Route::get('roles/{id}', 'Api\RoleController@show');
});

Route::get('products', 'Api\PostController@getAll');
Route::post('create-products', 'Api\PostController@store')->name("createProducts");
