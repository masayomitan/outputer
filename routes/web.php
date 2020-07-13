<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
    return redirect('/books');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('books', 'booksController@index')->name('books.index');

//投稿記事関連
Route::resource('books', 'booksController',['only' => ['create', 'store', 'edit', 'show', 'update', 'destroy']]);

#####ユーザー
Route::resource('users', 'UsersController',['only' => ['index', 'show']]);
