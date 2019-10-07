<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', 'API\RegisterController@register');
Route::post('login', 'API\RegisterController@login');

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

# Front end
Route::namespace('API\Frontend')->prefix('v1')->name('api.')->group(function () {
    Route::get('comments', 'HomeController@getListComment')->name('comments.latest');
    Route::post('comments', 'HomeController@storedComment')->name('comments.store');
    Route::post('comments/reply', 'HomeController@storedCommentReply')->name('comments.store.reply');
    Route::prefix('companies')->group(function () {
        Route::get('/', 'HomeController@getListCompany')->name('companies.list');
        Route::get('{slug}', 'HomeController@getCompanyDetail')->name('companies.detail')->where('slug', '[0-9A-Za-z\-]+');
        Route::get('{id}/comments', 'HomeController@getCommentByCompanyId')->name('companies.comment.detail')->where('id', '[0-9]+');
    });
    Route::get('comments/{id}/reply', 'HomeController@getCommentReply')->name('comments.reply')->where('id', '[0-9]+');

});
