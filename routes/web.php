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


Route::get('login/facebook', 'Auth\LoginController@redirectToProvider');
Route::get('login/facebook/callback', 'Auth\LoginController@handleProviderCallback');

Route::get('user/all', 'Auth\LoginController@findAll');
Route::get('user/{name}', 'Auth\LoginController@findByName');

Route::post('user/sendRequest','Auth\LoginController@sendRequest');

Route::get('friendRequest','Auth\LoginController@friendRequest');