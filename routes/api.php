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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

# Front end
Route::namespace('API\Frontend')->prefix('v1')->name('api.')->group(function () {
    Route::get('comments', 'HomeController@getListComment')->name('comments.latest');
    Route::get('companies', 'HomeController@getListCompany')->name('companies.list');
    Route::get('companies/{slug}', 'HomeController@getCompanyDetail')
        ->name('companies.detail')
        ->where('slug', '[A-Za-z\-]+');
    Route::get('companies/{id}/comments', 'HomeController@getCommentByCompanyId')
        ->name('companies.comment.detail')
        ->where('id', '[0-9]+');
});
