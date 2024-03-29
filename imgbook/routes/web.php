<?php

use App\Profanity;

app()->singleton('App\Profanity', function ($app) {
    return new Profanity('https://www.purgomalum.com/service/');
});


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

Route::get('/', 'PostController@index');

Auth::routes();

//Posts
Route::post('posts/edit/{id}', 'PostController@update')
    ->name('posts.update')->middleware('auth');

Route::get('posts', 'PostController@index')
    ->name('posts.index');

Route::get('posts/create', 'PostController@create')
    ->name('posts.create')->middleware('auth');

Route::get('posts/edit/{id}', 'PostController@edit')
    ->name('posts.edit')->middleware('auth');

Route::post('posts', 'PostController@store')
    ->name('posts.store')->middleware('auth');

Route::get('/posts/{id}', 'PostController@show')
    ->name('posts.show')->middleware('auth');

Route::delete('/posts/{user_id}/{id}', 'PostController@destroy')
    ->name('posts.destroy')->middleware('auth');

//Comments
Route::get('comments/{id}', 'CommentController@apiIndexByPost')
    ->name('api.comments.index.post')->middleware('auth');
    
Route::post('comments', 'CommentController@apiStore')
    ->name('api.comments.store')->middleware('auth');

Route::put('comments/{id}', 'CommentController@update')
    ->name('comments.update')->middleware('auth');

Route::delete('comment/{id}/{post_id}', 'CommentController@apiDestroy')
    ->name('api.comment.destroy')->middleware('auth');