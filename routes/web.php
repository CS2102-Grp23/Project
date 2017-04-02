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
Route::get('/register', function () {
    return view('welcome');
});
Route::get('/projects', function () {
    return view('welcome');
});
Route::get('/profile', function () {
    return view('welcome');
});
Route::get('/project/{project}', function () {
    return view('welcome');
});

// get routes
Route::get('/projects/all', 'projectController@getAll');
Route::get('/projects/oneProject/{id}', 'projectController@getProject');

Route::get('/profiles/all', 'authController@getAllUsers');

Route::get('/user/getUser', 'authController@getUser');
Route::get('/user/logout', 'authController@logout');

// post routes
Route::post('/user/login', 'authController@login');
Route::post('/user/signup', 'authController@signup');

Route::post('/projects/create', 'projectController@create');

// test routes
Route::get('/test', 'authController@test');
Route::get('/projects/test', 'projectController@test');
