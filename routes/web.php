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
Route::get('/user', function () {
    return view('welcome');
});
Route::get('/profile/{name}', function () {
    return view('welcome');
});
Route::get('/admin', function () {
    return view('welcome');
});
Route::get('/project/{project}', function () {
    return view('welcome');
});

// get routes
Route::get('/projects/all', 'projectController@getAll');
Route::get('/projects/oneProject/{id}', 'projectController@getProject');

Route::get('/profiles/all', 'profileController@getAll');
Route::get('/profiles/oneProfile/{username}', 'profileController@getProfile');

Route::get('/user/getUser', 'authController@getUser');
Route::get('/user/getAccessLevel', 'authController@getAccessLevel');
Route::get('/user/logout', 'authController@logout');

//admin routes
Route::get('/admin/noAct', 'adminController@getNoActivity');
Route::get('/admin/noActSum', 'adminController@getNoActivitySummary');
Route::get('/admin/noProj', 'adminController@getNoProject');
Route::get('/admin/noProjSum', 'adminController@getNoProjectSummary');
Route::get('/admin/noCon', 'adminController@getNoContribute');
Route::get('/admin/noConSum', 'adminController@getNoContributeSummary');

Route::get('/admin/topCon', 'adminController@getTopContributors');
Route::get('/admin/topConSum', 'adminController@getTopContributorsSummary');
Route::get('/admin/TopFull', 'adminController@getTopFulfilledProjects');
Route::get('/admin/TopFullSum', 'adminController@getTopFulfilledProjectsSummary');
Route::get('/admin/TopSimilar', 'adminController@getTopPairOfSimilarUsers');
Route::get('/admin/TopSimilarSum', 'adminController@getTopPairOfSimilarUsersSummary');
Route::get('/admin/TopNationCon', 'adminController@getTopNationContributor');
Route::get('/admin/TopNationConSum', 'adminController@getTopNationContributorSummary');
Route::get('/admin/TopNationProj', 'adminController@getTopNationProjectCount');
Route::get('/admin/TopNationProjSum', 'adminController@getTopNationProjectCountSummary');

//search routes (get? post?)
Route::get('/search/category/{category}', 'searchController@searchCategory');
//$searchCategory = $req->input('category');

Route::get('/search/query/{searchQuery}/{ownProject}/{contributedProject}', 'searchController@searchQuery');
/*
$searchQuery = $req->input('search');
$username = $_SESSION['userName'];
$ownProject = $req->input('ownProject');
$contributedProject = $req->input('contributedProject');
*/


// post routes
Route::post('/user/login', 'authController@login');
Route::post('/user/signup', 'authController@signup');

Route::post('/projects/create', 'projectController@create');

// test routes
Route::get('/test', 'authController@test');
Route::get('/projects/test', 'projectController@test');
