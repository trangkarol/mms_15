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

//admin
Route::group(['prefix' => 'admin', 'middleware' => 'admin', 'namespace' => 'Admin'], function () {
    // teams
    Route::group(['prefix' => 'teams'], function () {
        Route::resource('/', 'TeamController', ['only' => ['index', 'create', 'store']]);
        Route::post('/destroy', 'TeamController@destroy');
        Route::post('/update', 'TeamController@update');
        Route::get('/add-member', 'TeamController@addMember');
        Route::post('/store-member', 'TeamController@storeMember');
        Route::post('/search', 'TeamController@search');
        Route::post('/search-member', 'TeamController@searchMember');
        Route::post('/edit-member', 'TeamController@editMember');
        Route::post('/delete-member', 'TeamController@deleteMember');
        Route::get('/{id}/edit', 'TeamController@edit');
        Route::post('/position-team', 'TeamController@positionTeam');
    });

    // user
    Route::group(['prefix' => 'users'], function () {
        Route::resource('/', 'UserController', ['only' => ['index', 'create', 'store']]);
        Route::post('/search', 'UserController@search');
        Route::post('/destroy', 'UserController@destroy');
        Route::post('/update', 'UserController@update');
        Route::get('/{id}/edit', 'UserController@edit');
        Route::post('/add-skill', 'UserController@addSkill');
        Route::post('/position-team', 'UserController@positionTeam');
        Route::post('/add-team', 'UserController@addTeam');
        Route::post('/delete-team', 'UserController@deleteTeam');
    });

    // position
    Route::group(['prefix' => 'positions'], function () {
        Route::resource('/', 'PositionController', ['only' => ['index', 'create', 'store']]);
        Route::post('/destroy', 'PositionController@destroy');
        Route::post('/update', 'PositionController@update');
        Route::get('/{id}/edit', 'PositionController@edit');
    });

    // project
    Route::group(['prefix' => 'projects'], function () {
        Route::resource('/', 'ProjectController', ['only' => ['index', 'create', 'store']]);
        Route::post('/destroy', 'ProjectController@destroy');
        Route::post('/update', 'ProjectController@update');
        Route::post('/search', 'ProjectController@search');
        Route::post('/search-member', 'ProjectController@searchMember');
        Route::post('/add-member', 'ProjectController@addMember');
        Route::post('/delete-member', 'ProjectController@deleteMember');
        Route::get('/{id}/edit', 'ProjectController@edit');
    });

    // skill
    Route::group(['prefix' => 'skills'], function () {
        Route::resource('/', 'SkillController', ['only' => ['index', 'create', 'store']]);
        Route::post('/destroy', 'SkillController@destroy');
        Route::post('/update', 'SkillController@update');
        Route::get('/{id}/edit', 'SkillController@edit');
    });

    // activity
    Route::group(['prefix' => 'activities'], function () {
        Route::resource('/', 'ActivityController', ['only' => ['index']]);
        Route::post('/destroy', 'ActivityController@destroy');
    });
});

//public
Route::group(['prefix' => 'public' , 'middleware' => 'auth',  'namespace' => 'Member'], function () {
    Route::get('/', 'HomeController@index');
    Route::get('/list-team', 'HomeController@listTeam');
    Route::get('/list-member/{id}', 'HomeController@listMember');
    Route::get('/detail-member/{id}', 'HomeController@detailMember');
});

/*login user*/
Route::group(['namespace' => 'Auth'], function() {
    Route::get('/login', 'LoginController@index');
    Route::post('/login', 'LoginController@login');
    Route::post('/logout', 'LoginController@logout');
    Route::post('/change-password', 'ResetPasswordController@changePassword');
    Route::get('/page-change-password', 'ResetPasswordController@index');
});

Route::get('/home', 'HomeController@index');
