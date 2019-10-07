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
Auth::routes([
    'register' => false, // Registration Routes...
    'reset' => false, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
]);

Route::get('/', 'PageController@index')->name('home');
Route::get('companies/{slug}', 'PageController@company')->where('slug', '[0-9A-Za-z\-]+')->name('company.detail');
Route::get('/tnc', 'PageController@getPageTnc')->name('tnc');
Route::get('/fqa', 'PageController@getPageFqa')->name('fqa');
Route::get('language/{locale}', 'PageController@handleLanguage')->name('handle.language');

Route::middleware('auth')->namespace('Manage')->prefix('manage')->name('manage.')->group(function () {
    Route::get('/', 'ManageController@index')->name('manage');
    Route::resource('companies', 'CompanyController');
    Route::resource('comments', 'CommentController');
    Route::resource('roles','RoleController');
    Route::resource('users','UserController');
});
