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

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/threads', 'ThreadsController@index')->name('threads.index');
Route::get('/threads/create', 'ThreadsController@create')->name('threads.create');
Route::get('/threads/{channel}', 'ThreadsController@index');
Route::get('/threads/{channel}/{thread}', 'ThreadsController@show')->name('threads.show');
Route::delete('/threads/{channel}/{thread}', 'ThreadsController@destroy')->name('threads.destroy');
Route::resource('threads', 'ThreadsController');
Route::post('/threads/{channel}/{thread}/subscriptions', 'ThreadSubscriptionsController@store')->name('subscribe');

Route::get('/threads/{channel}/{thread}/replies', 'RepliesController@index')->name('reply.index');
Route::post('/threads/{channel}/{thread}/replies', 'RepliesController@store')->name('reply.store');
Route::post('/replies/{reply}/favorites', 'FavoritesController@store')->name('reply.favorite');
Route::delete('/replies/{reply}/favorites', 'FavoritesController@destroy')->name('reply.unfavorite');
Route::patch('/replies/{reply}', 'RepliesController@update')->name('reply.update');
Route::delete('/replies/{reply}', 'RepliesController@destroy')->name('reply.destroy');

Route::get('/profiles/{user}', 'ProfilesController@show')->name('profile.show');
