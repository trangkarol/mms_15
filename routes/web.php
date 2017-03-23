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

//admin , 'middleware' => 'admin'
Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
    // teams
    Route::group(['prefix' => 'teams'], function () {
        Route::resource('/', 'TeamController', ['only' => ['index', 'create', 'store']]);
        Route::post('/destroy', 'TeamController@destroy');
        Route::post('/update', 'TeamController@update');
        Route::get('/add-member', 'TeamController@addMember');
        Route::post('/add-member', 'TeamController@storeMember');
        Route::post('/search', 'TeamController@search');
        Route::get('/{id}/edit', 'TeamController@edit');
    });

});

/*login user*/
Route::group(['namespace' => 'Auth'], function() {
    Route::get('/login', 'LoginController@index');
    Route::post('/login', 'LoginController@login');
    Route::post('/logout', 'LoginController@logout');
});

Route::get('/home', 'HomeController@index');
