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
    Route::post('create-role', 'Api\RoleController@store');
    Route::put('update-role/{id}', 'Api\RoleController@update');
    Route::get('list-roles', 'Api\RoleController@getRolesPaginate');
    Route::get('destroy-role/{id}', 'Api\RoleController@destroy');
});

Route::get('products', 'Api\PostController@getAll');
Route::post('create-products', 'Api\PostController@store')->name("createProducts");
