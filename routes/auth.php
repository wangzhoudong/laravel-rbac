<?php
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'api/auth'
], function () {
    Route::post('refresh', 'AuthController@refresh');
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('me', 'AuthController@me');
});
