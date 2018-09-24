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
   
});

Route::get('products', 'Api\PostController@getAll');
Route::post('create-products', 'Api\PostController@store')->name("createProducts");
