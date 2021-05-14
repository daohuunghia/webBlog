<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('checkLoginUser')->prefix('admin-login')->namespace('Backend')->group(function() {
    Route::get('/', 'UserController@getLogin')->name('admin.user.login');
    Route::post('/', 'UserController@postLogin');
});

Route::middleware(['locale', 'checkLogoutUser'])->prefix('admin')->namespace('Backend')->group(function() {
    Route::get('change-languague/{lang}', 'DashboardController@changeLanguage')->name('admin.change-languague');
    Route::get('/', 'DashboardController@dashboard')->name('admin.dashboard');
    //1. user
    Route::group(['prefix' => 'user'], function() {
        Route::get('/', 'UserController@index')->name('admin.user.index');
        Route::get('/view', 'UserController@view')->name('admin.user.view');
        Route::get('create', 'UserController@getCreate')->name('admin.user.create');
        Route::post('create', 'UserController@postCreate');
        Route::get('update/{id}', 'UserController@getUpdate')->name('admin.user.update');
        Route::post('update/{id}', 'UserController@postUpdate');
        Route::get('action/{action}/{id}', 'UserController@getAction')->name('admin.user.action');
        Route::get('logout', 'UserController@getLogout')->name('admin.user.logout');
    });

    //2. Role
    Route::prefix('role')->group(function() {
        Route::get('/', 'RoleController@index')->name('admin.role.index');
        Route::get('create', 'RoleController@getCreate')->name('admin.role.create');
        Route::post('create', 'RoleController@postCreate');
        Route::get('update/{id}', 'RoleController@getUpdate')->name('admin.role.update');
        Route::post('update/{id}', 'RoleController@postUpdate');
        Route::get('action/{action}/{id}', 'RoleController@getAction')->name('admin.role.action');
    });

    //3. Permission
    Route::prefix('permission')->group(function() {
        Route::get('/', 'PermissionController@index')->name('admin.permission.index');
        Route::get('create', 'PermissionController@getCreate')->name('admin.permission.create');
        Route::post('create', 'PermissionController@postCreate');
        Route::get('update/{id}', 'PermissionController@getUpdate')->name('admin.permission.update');
        Route::post('update/{id}', 'PermissionController@postUpdate');
    });

    //4.Danh muc san pham
    Route::group(['prefix' => 'category'], function () {
        Route::get('/', 'CategoryController@index')->name('admin.category.index');
        Route::get('create', 'CategoryController@getCreate')->name('admin.category.get.create');
        Route::post('create', 'CategoryController@postCreate')->name('admin.category.post.create');
        Route::get('update/{id}', 'CategoryController@getUpdate')->name('admin.category.get.update');
        Route::post('update/{id}', 'CategoryController@postUpdate')->name('admin.category.post.update');
        Route::get('action/{action}/{id}', 'CategoryController@getAction')->name('admin.category.action');
    });
});

//Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
