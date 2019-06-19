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
//
Route::get('/home', 'HomeController@index')->name('home');
Route::middleware(['auth'])->group(function () {
    Route::get('/manage', function ()    {
        // User đăng nhập mới vào được manage
    });

    Route::post('comments/create', function () {
        // User đăng nhập mới được bình luận
    });
});

Route::namespace('Manage')->group(function () {
    // Controllers Within The "App\Http\Controllers\Manage" Namespace
});

Route::prefix('manage')->group(function () {
    Route::get('users', function () {
        // Matches The "/manage/users" URL
    });
});

// Sử dụng kết hợp

Route::middleware(['auth'])->prefix('manage')->group(function () {
    Route::get('posts', function () {
        // User đăng nhập mới vào được manage/posts
    });
});
