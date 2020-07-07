<?php

namespace App\Http\Controllers;

use App\Book;
use App\User;
use App\Tag;
use Illuminate\Http\Request;


class SearchesController extends Controller
{
    public function index(Request $request, Book $book, Tag $tag, User $user){
      $keyword = $request->input("keyword");

      if(!empty($keyword)){
          #記事タイトルから検索
          $search_books = Book::where('title', 'LIKE', '%'.$keyword.'%')->paginate(6);
      }
      $popular_tags = $tag->getPopularTags();
      $popular_users = $user->getPopularUsers();
      return view('search.index', [
        'keyword' => $keyword,
        'books' => $search_books,
        'popular_tags' => $popular_tags,
        'popular_users' => $popular_users,
    ]);
  }
}
