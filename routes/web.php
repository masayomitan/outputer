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


#####ユーザー
Route::resource('users', 'UsersController',['only' => ['index', 'show']]);


#ログイン状態
Route::group(['middleware' => 'auth'], function() {
    #ユーザ関連
    Route::resource('users', 'UsersController',['only' => ['edit', 'update']]);

    //投稿記事関連
    Route::resource('books', 'booksController',['only' => ['create', 'store', 'edit', 'update', 'destroy']]);

    //アウトプット
    Route::resource('sentences', 'sentencesController', ['only' => ['create', 'store']]);
    Route::get('sentences/create/{id}', 'sentencesController@create')->name('sentences.create');

    //いいね関連
    Route::resource('favorites', 'FavoritesController', ['only' => ['store','destroy']]);

});

Route::get('tags/{tag}', 'TagsController@show')->name('tags.show');
Route::get('/fetch', 'BooksController@fetch')->name('book.fetch');
Route::get('books/{book}', 'BooksController@show')->name('books.show');
