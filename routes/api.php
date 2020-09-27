<?php

use Illuminate\Support\Facades\Route;

// 菜单tree
Route::get('/menu/all', 'MenuController@getAll');
// 菜单绑定api
Route::put('/menu/{id}/apis', 'MenuController@bindApi');
// 菜单获取已绑定api
Route::get('/menu/{id}/apis', 'MenuController@getBindApis');
// 获取所有角色
Route::put('/role/all', 'RoleController@getAll');
// 角色绑定菜单
Route::put('/role/{id}/menus', 'RoleController@bindMenu');
// 获取角色已绑定菜单
Route::get('/role/{id}/menus', 'RoleController@getBindMenus');
// 获取角色已绑定api
Route::get('/role/{id}/apis', 'RoleController@getBindApis');
// 用户绑定角色
Route::put('/user/{id}/roles', 'UserController@bindRole');
// 获取用户已绑定角色
Route::get('/user/{id}/roles', 'UserController@getBindRoles');

// 获取用户已绑定菜单
Route::get('/user/{id}/menus', 'UserController@getBindMenus');
// 获取用户已绑定api
Route::get('/user/{id}/apis', 'UserController@getBindApis');
// 更新密码
Route::put('/user/{id}/password', 'UserController@updatePassword');
// 去重获取所有module
Route::get('/api/modules', 'ApiController@getModules');
// 获取所有api
Route::get('/api/all', 'ApiController@getAll');
Route::resource('/role', 'RoleController');
Route::resource('/menu', 'MenuController');
Route::resource('/api', 'ApiController');
Route::resource('/user', 'UserController');

