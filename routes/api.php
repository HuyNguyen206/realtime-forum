<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::group([
    'prefix' => 'auth'
], function ($router) {

    Route::post('login', 'AuthController@login')->name('auth.login');
    Route::post('register', 'AuthController@register')->name('auth.register');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
    Route::get('payload', 'AuthController@payload');

});
Route::get('notifications', 'NotificationController@getNotification');
Route::get('notifications/unread', 'NotificationController@getUnreadNotification');
Route::patch('notifications/mark-as-read/{notifyId}', 'NotificationController@markReadNotification');
Route::apiResource('questions', 'QuestionController');
Route::apiResource('categories', 'CategoryController');
Route::apiResource('questions.replies', 'ReplyController')->shallow();
Route::post('like/toggle/{reply}', 'LikeController@toggle');
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
