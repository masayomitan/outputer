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

Route::get('books', 'BooksController@index')->name('books.index');
Route::get('search', 'SearchesController@index')->name('search.index');

//ユーザー
Route::resource('users', 'UsersController',['only' => ['index', 'show']]);

// フォロー/フォロワー
Route::get('users/{user}/following', 'UsersController@following')->name('users.following');
Route::get('users/{user}/followers', 'UsersController@followers')->name('users.followers');
Route::get('users/{user}/favorite', 'UsersController@favorite')->name('users.favorite');
######

#ログイン状態
Route::group(['middleware' => 'auth'], function() {
  //#ユーザ関連
  Route::resource('users', 'UsersController',['only' => ['edit', 'update']]);

  // フォロー/フォロー解除を追加
  Route::post('users/{user}/follow', 'UsersController@follow')->name('users.follow');
  Route::delete('users/{user}/unfollow', 'UsersController@unfollow')->name('users.unfollow');

  //投稿記事関連
  Route::resource('books', 'BooksController',['only' => ['create', 'store', 'edit', 'update', 'destroy']]);

  //アウトプット関連
  Route::resource('output', 'OutputController', ['only' => ['store']]);

  //いいね関連
  Route::resource('favorites', 'FavoritesController', ['only' => ['store','destroy']]);

});

//タグ関連
Route::get('tags/{tag}', 'TagsController@show')->name('tags.show');
Route::get('/fetch', 'BooksController@fetch')->name('book.fetch');
Route::get('books/{book}', 'BooksController@show')->name('books.show');
