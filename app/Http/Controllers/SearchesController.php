<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;

class SearchesController extends Controller
{

    //
    public function index(Request $request, Book $book, Tag $tag, User $user)
    {

        $keyword = $request->input("keyword");
            $search_books_title = Book::where('title', 'LIKE', '%'.$keyword.'%')->paginate(20);  #記事タイトルから検索
            $search_books_author = Book::where('author', 'LIKE', '%'.$keyword.'%')->paginate(20); #著者から検索
            $search_users = User::where('name', 'LIKE', '%'.$keyword.'%')->paginate(20);   #ユーザーネームから検索
            $search_tags = Tag::where('name', 'LIKE', '%'.$keyword.'%')->paginate(20);     #タグから検索

        return view('search.index', [
            'keyword' => $keyword,
            'search_books_title' => $search_books_title,
            'search_books_author' => $search_books_author,
            'search_users' => $search_users,
            'search_tags' => $search_tags

        ]);
    }
}
