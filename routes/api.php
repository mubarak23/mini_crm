<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::prefix('authservice')->group(function(){
    #Route::post('register', 'AuthController@register');
    #Route::post('login', 'AuthController@login');
    #Route::get('refresh', 'AuthController@refresh');

    Route::group(['middleware' => 'auth.api'], function(){
        Route::get('user', 'AuthController@user');
        Route::post('logout', 'AuthController@logout');
    });

});

Route::group(['prefix' => 'authservice'], function () {

    Route::post('login', [
        'uses' => 'AuthController@auth_login',
        'as' => 'Auth An employee Account'
    ]);

    Route::post('register', [
        'uses' => 'AuthController@register',
        'as' => 'Register An employee Account'
    ]);

    Route::get('refresh', [
        'uses' => 'AuthController@refresh',
        'as' => 'refresh auth'
    ]);

});


Route::group(['middleware' => 'auth.api'], function () {

    Route::post('logout', [
        'uses' => 'AuthController@logout',
        'as' => ' Account Logout'
    ]);

});
