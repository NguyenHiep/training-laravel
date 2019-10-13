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
    'reset' => true, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
]);

Route::get('/', 'PageController@index')->name('home');
Route::get('companies/{slug}', 'PageController@company')->where('slug', '[0-9A-Za-z\-]+')->name('company.detail');
Route::get('/tnc', 'PageController@getPageTnc')->name('tnc');
Route::get('/fqa', 'PageController@getPageFqa')->name('fqa');
Route::get('language/{locale}', 'PageController@handleLanguage')->name('handle.language');

// Customer access

Route::middleware('auth')->name('customer.')->group(function () {
    Route::get('/dashboard', 'HomeController@index')->name('dashboard');
});

Route::prefix('/manage')->name('manage.')->namespace('Manage')->group(function () {
    Route::namespace('Auth')->group(function () {
        //Login Routes
        Route::get('/login', 'LoginController@showLoginForm')->name('login');
        Route::post('/login', 'LoginController@login');
        Route::post('/logout', 'LoginController@logout')->name('logout');
        //Forgot Password Routes
        Route::get('/password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
        Route::post('/password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
        //Reset Password Routes
        Route::get('/password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
        Route::post('/password/reset', 'ResetPasswordController@reset')->name('password.update');
    });
});

// Manage administrator access

Route::middleware(['auth:admin'])->namespace('Manage')->prefix('manage')->name('manage.')->group(function () {
    Route::get('/', 'ManageController@index')->name('home');
    Route::resource('companies', 'CompanyController');
    Route::resource('comments', 'CommentController');
    Route::resource('roles', 'RoleController');
    Route::resource('users', 'UserController');
    Route::resource('admins', 'AdminController');
});
