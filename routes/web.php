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


Route::group(['middleware' => ['auth']], function(){
    Route::get('/mypage', 'PostController@mypage');
    Route::get('/posts/mysongs', 'PostController@mysongs');
    Route::get('/posts/create', 'PostController@create');
    Route::get('/posts/{post}/edit', 'PostController@edit');
    Route::get('/like/{post}', 'PostController@like')->name('like');
    Route::get('/unlike/{post}', 'PostController@unlike')->name('unlike');
    Route::put('/posts/{post}', 'PostController@update');
    Route::post('/posts', 'PostController@store');
    Route::delete('/posts/{post}', 'PostController@delete');
    
});

Auth::routes();
Route::get('/', 'PostController@top');
Route::get('/posts/{post}', 'PostController@show');
Route::get('/search', 'PostController@search');


Route::get('/home', 'HomeController@index')->name('home');

