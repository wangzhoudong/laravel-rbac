<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'api'
], function () {
    Route::get('/menu/all', 'MenuController@getAll');
    Route::put('/menu/{id}/apis', 'MenuController@bindApi');
    Route::get('/menu/{id}/apis', 'MenuController@getBindApis');
    Route::get('/menu/all', 'MenuController@getAll');
    Route::put('/role/{id}/menus', 'RoleController@bindMenu');
    Route::get('/role/{id}/menus', 'RoleController@getBindMenus');
    Route::get('/role/{id}/apis', 'RoleController@getBindApis');
    Route::put('/user/{id}/roles', 'UserController@bindRole');
    Route::get('/user/{id}/roles', 'UserController@getBindRoles');
    Route::get('/user/{id}/menus', 'UserController@getBindMenus');
    Route::get('/user/{id}/apis', 'UserController@getBindApis');
    Route::put('/user/{id}/password', 'UserController@updatePassword');
    Route::get('/api/modules', 'ApiController@getModules');
    Route::get('/api/get', 'ApiController@getList');
    Route::resource('/role', 'RoleController');
    Route::resource('/menu', 'MenuController');
    Route::resource('/api', 'ApiController');
    Route::resource('/user', 'UserController');
});

Route::prefix('api')->group(function () {

});

Route::get('/{view?}', 'HomeController@index')->where('view', '(.*)')->name('rabc.index');
