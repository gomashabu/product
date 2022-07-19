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
    Route::get('/posts/mysongs', 'PostController@myPage');
    Route::get('/posts/create', 'PostController@create');
    Route::get('/posts/{post}/edit', 'PostController@edit');
    Route::get('/like/{post}', 'PostController@like')->name('like');
    Route::get('/unlike/{post}', 'PostController@unlike')->name('unlike');
    Route::get('/posts/{post}/claim', 'PostController@claim');
    Route::put('/posts/{post}', 'PostController@storeUpdate');
    Route::put('/claim/{post}/{claim}/edit', 'PostController@updateClaim');
    Route::post('/posts', 'PostController@storeUpdate');
    Route::post('/claim/{post}', 'PostController@storeClaim');
    Route::post('/posts/{post}/comment', 'PostController@storeComment');
    Route::delete('/posts/{post}', 'PostController@delete');
    
});

Auth::routes();
Route::get('/', 'PostController@top');
Route::get('/posts/{post}', 'PostController@showLyricsOrFlat');
Route::get('/search', 'PostController@search');


Route::get('/home', 'HomeController@index')->name('home');

