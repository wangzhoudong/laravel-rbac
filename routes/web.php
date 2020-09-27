<?php

use Illuminate\Support\Facades\Route;


Route::group([
    'prefix' => 'api',
    'middleware' => config('rbac.middleware', 'api'),
], function () {
    Route::get('/menu/all', 'MenuController@getAll');
    Route::put('/menu/{id}/apis', 'MenuController@bindApi');
    Route::get('/menu/{id}/apis', 'MenuController@getBindApis');
    Route::put('/role/all', 'RoleController@getAll');
    Route::put('/role/{id}/menus', 'RoleController@bindMenu');
    Route::get('/role/{id}/menus', 'RoleController@getBindMenus');
    Route::get('/role/{id}/apis', 'RoleController@getBindApis');
    Route::put('/user/{id}/roles', 'UserController@bindRole');
    Route::get('/user/{id}/roles', 'UserController@getBindRoles');
    Route::get('/user/{id}/menus', 'UserController@getBindMenus');
    Route::get('/user/{id}/apis', 'UserController@getBindApis');
    Route::put('/user/{id}/password', 'UserController@updatePassword');
    Route::get('/api/modules', 'ApiController@getModules');
    Route::get('/api/all', 'ApiController@getAll');
    Route::resource('/role', 'RoleController');
    Route::resource('/menu', 'MenuController');
    Route::resource('/api', 'ApiController');
    Route::resource('/user', 'UserController');
});
Route::get('/{view?}', 'HomeController@index')->where('view', '(.*)')->name('rabc.index');
