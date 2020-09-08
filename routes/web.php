<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect('/home');
});



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home/term_of_service', 'HomeController@term_of_service')->name('home/term_of_service');
Route::get('/home/guideline', 'HomeController@guideline')->name('home/guideline');

Route::get('books', 'BooksController@index')->name('books.index');
Route::get('books/put_new_sentence', 'BooksController@put_new_sentence');
Route::get('books/put_popular_sentence', 'BooksController@put_popular_sentence');


Route::get('search', 'SearchesController@index')->name('search.index');

#####ユーザー
Route::resource('users', 'UsersController',['only' => ['index', 'show']]);

// フォロー/フォロワー
Route::get('users/{user}/following', 'UsersController@following')->name('users.following');
Route::get('users/{user}/followers', 'UsersController@followers')->name('users.followers');
Route::get('users/{user}/favorites', 'UsersController@favorites')->name('users.favorites');


#ログイン状態
Route::group(['middleware' => 'auth'], function() {
    #ユーザ関連
    Route::resource('users', 'UsersController', ['only' => ['edit', 'update', 'destroy']]);

    // フォロー/フォロー解除を追加
    Route::post('users/{user}/follow', 'UsersController@follow')->name('users.follow');
    Route::delete('users/{user}/unfollow', 'UsersController@unfollow')->name('users.unfollow');

    //投稿記事関連
    Route::resource('books', 'BooksController',['only' => ['create', 'store']]);

    //アウトプット
    Route::resource('sentences', 'SentencesController', ['only' => ['store', 'edit', 'update', 'destroy']]);
    Route::get('sentences/create/{id}', 'SentencesController@create')->name('sentences.create');

    //タグ
    Route::resource('tags', 'TagsController', ['only' => ['store', 'destroy']]);
    Route::get('tags/create/{id}', 'TagsController@create')->name('tags.create');

    //いいね関連
    Route::post('sentences/{sentence}/favorites', 'FavoritesController@store')->name('favorites');
    Route::post('sentences/{sentence}/unfavorites', 'FavoritesController@destroy')->name('unfavorites');

});

Route::get('tags', 'TagsController@index')->name('tags.index');
Route::get('tags/{tag}', 'TagsController@show')->name('tags.show');
Route::get('books/{book}', 'BooksController@show')->name('books.show');
Route::get('sentences/{sentence}', 'SentencesController@show')->name('sentences.show');
