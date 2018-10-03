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
//UserStory02 03 04 08
Auth::routes();

//UserStory01
Route::get('/', 'statisticsController@registeredUsers')->name('welcome.index');

//Página Home ainda por implementar alguma coisa
Route::get('/home', 'HomeController@index')->name('home');

//UserStory05 06
Route::get('users', 'AdminController@index')->middleware('auth')->middleware('admin')->name('users.index');

//UserStory07
Route::patch('/users/{user}/block', 'AdminController@block')->middleware('auth')->middleware('admin')->name('users.block');
Route::patch('/users/{user}/unblock', 'AdminController@unblock')->middleware('auth')->middleware('admin')->name('users.unblock');
Route::patch('/users/{user}/promote', 'AdminController@promote')->middleware('auth')->middleware('admin')->name('users.promote');
Route::patch('/users/{user}/demote', 'AdminController@demote')->middleware('auth')->middleware('admin')->name('users.demote');

//UserStory09
Route::get('me/password', 'UserController@editPassword')->middleware('auth')->name('profile.password');
Route::patch('me/password', 'UserController@updatePassword')->middleware('auth')->name('profile.password');

//UserStory10
Route::get('profile', 'UserController@profile')->middleware('auth')->name('profile');
Route::get('me/profile', 'UserController@editProfile')->middleware('auth')->name('profile.me');
Route::put('me/profile', 'UserController@editProfileConfirm')->middleware('auth')->name('profile.me');

//UserStory11
Route::get('profiles', 'UserController@profiles')->middleware('auth')->name('profiles');

//UserStory12
Route::get('/me/associates', 'UserController@associates')->middleware('auth')->name('associate');

//UserStory13
Route::get('me/associate-of', 'UserController@associates_of')->middleware('auth')->name('associate_of');

//UserStory14
Route::get('/accounts/{user}', 'AccountController@accounts')->middleware('auth')->name('accounts');
Route::get('/accounts/{user}/opened', 'AccountController@openedAccounts')->middleware('auth')->name('opened.accounts');
Route::get('/accounts/{user}/closed', 'AccountController@closedAccounts')->middleware('auth')->name('closed.accounts');

//UserStory15
Route::delete('/account/{account}', 'AccountController@deleteAccount')->middleware('auth')->name('delete.account');
Route::patch('/account/{account}/close', 'AccountController@closeSpecificAcount')->middleware('auth')->name('closeSpecific.account');

//UserStory16
Route::patch('/account/{account}/reopen', 'AccountController@openSpecificAccount')->middleware('auth')->name('openSpecific.account');

//UserStory17
Route::get('/account', 'AccountController@createAccount')->middleware('auth')->name('createAccount');
Route::post('/account', 'AccountController@saveAccount')->middleware('auth')->name('saveAccount');

//UserStory18
Route::get('/account/{account}', 'AccountController@editAccount')->middleware('auth')->name('editAccount');
Route::put('/account/{account}', 'AccountController@updateAccount')->middleware('auth')->name('updateAccount');

//Falta a 19

//UserStory20
Route::get('/movements/{account}', 'MovementsController@showMovements')->middleware('auth')->name('showMovements');

//UserStory21
Route::get('movements/{account}/create', 'MovementsController@createMovement')->middleware('auth')->name('movements');
Route::post('movements/{account}/create', 'MovementsController@saveMovement')->middleware('auth')->name('movementsCreate');
Route::get('movement/{movement}', 'MovementsController@editMovement')->middleware('auth')->name('movementsEdit');
Route::put('movement/{movement}', 'MovementsController@updateMovement')->middleware('auth')->name('movementsUpdate');
Route::delete('movement/{movement}' , 'MovementsController@destroyMovement')->middleware('auth')->name('movementsDelete');

//UserStory23
Route::get('documents/{movements}','MovementsController@showuploadDocument')->middleware('auth')->name('showuploadDocument');
Route::post('documents/{movements}','MovementsController@uploadDocument')->middleware('auth')->name('uploadDocument');

//UserStory24
Route::delete('document/{document}','MovementsController@deleteDocument')->middleware('auth')->name('deleteDocument');

//UserStory25
Route::get('document/{document}','MovementsController@downloadDocument')->middleware('auth')->name('downloadDocument');
Route::get('documents/show/{documents}','MovementsController@showDocument')->middleware('auth')->name('showDocument');

Route::get('dashboard/{user}','StatisticsController@showStatAll')->middleware('auth')->name('showStatistics');
Route::get('dashboard','StatisticsController@ShowTimeFrame')->middleware('auth')->name('showStatisticsTimeFrame');

//UserStory29
Route::post('me/associates', 'UserController@addAssociate')->middleware('auth')->name('addAssociate');

//UserStory30
Route::delete('me/associates/{user}','UserController@removeAssociate')->middleware('auth')->name('removeAssociate');


