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

Route::get('books', 'BooksController@index')->name('books.index');
Route::get('search', 'SearchesController@index')->name('search.index');

#####ユーザー
Route::resource('users', 'UsersController',['only' => ['index', 'show']]);

