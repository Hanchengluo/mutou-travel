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


Route::group([
    'namespace' => 'Dashboard',
    'prefix' => 'dashboard'
], function () {
    Route::post('login', 'AuthController@login');
    Route::post('unlock', 'AuthController@unlock');
    Route::post('refresh', 'AuthController@refresh');
    
    Route::group(['middleware'=>'auth:api'], function () {
        Route::get('init', 'InitController@inital');
    });
});
