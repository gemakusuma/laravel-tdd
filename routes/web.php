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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::get('/blog', 'BlogController@index');

Route::group(['middleware' => 'auth'], function(){
    Route::post('/blog', 'BlogController@store');
    Route::get('/blog/create', 'BlogController@create');
    Route::get('/blog/{slug}/edit', 'BlogController@edit');
    Route::put('/blog/{id}', 'BlogController@update');
});

Route::get('/blog/{slug}', 'BlogController@show');

