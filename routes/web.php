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

// home route
Route::get('/', function () {
    return view('welcome');
});

// get routes
Route::get('/projects/all', 'projectController@getAll');
Route::get('/profiles/all', 'authController@getAll');

// post routes
Route::post('/login', 'authController@login');
Route::post('/signup', 'authController@signup');
Route::post('/projects/create', 'projectController@create');

// test routes
Route::get('/test', 'authController@test');
Route::get('/projects/test', 'projectController@test');
