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
Route::get('/team/add', 'TeamController@addTeamPage')->name('add_team');
Route::post('/team/add', 'TeamController@addTeam');
Route::get('/team/{team}', 'TeamController@view')->name('team_view');
Route::get('/team/list/{team}', 'TeamController@listMembers');

Route::get('/user/starred', 'UserController@starred');
Route::get('/user/starred_users', 'UserController@allUsers');
Route::post('/user/toggle/{target}', 'UserController@toggleStar');

