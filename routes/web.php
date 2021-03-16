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

Route::get('/', function () {
    return view('backend.index');
});

Route::group(['prefix' => 'admin', 'namespace' => 'Backend', 'middleware' => 'locale'], function () {
    Route::get('change-languague/{language}', 'DashboardController@changeLanguage')->name('admin.change-languague');
    Route::get('dashboard', 'DashboardController@dashboard');
    //Danh muc san pham
    Route::group(['prefix' => 'category'], function () {
        Route::get('/', 'CategoryController@index')->name('admin.category.index');
        Route::get('create', 'CategoryController@getCreate')->name('admin.category.get.create');
        Route::post('create', 'CategoryController@postCreate')->name('admin.category.post.create');
        Route::get('update/{id}', 'CategoryController@getUpdate')->name('admin.category.get.update');
        Route::get('update/{id}', 'CategoryController@postUpdate')->name('admin.category.post.update');
        Route::get('delete/{id}', 'CategoryController@index')->name('admin.category.delete');
    });
});
