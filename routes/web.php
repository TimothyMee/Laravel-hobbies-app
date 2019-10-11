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

Route::group(['prefix' => 'hobby', 'middleware' => 'auth'], function () {
    Route::post('/create', 'HobbyController@createNew');
    Route::get('/get', 'HobbyController@getAll');
    Route::get('/get-one', 'HobbyController@get');
    Route::put('/update', 'HobbyController@updateHobby');
    Route::delete('/delete/{id}', 'HobbyController@deleteHobby');
    Route::get('/categories', 'CategoryController@getAll');
});
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/auth-user', 'HomeController@getauthuser');
