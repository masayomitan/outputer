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

        if(!empty($keyword)) {
            #記事タイトルから検索
            $search_books = Book::where('title', 'LIKE', '%'.$keyword.'%')->paginate(6);
            $search_users = User::where('name', 'LIKE', '%'.$keyword.'%')->paginate(6);
        }
        return view('search.index', [
            'keyword' => $keyword,
            'books' => $search_books,
            'users' => $search_users,

        ]);
    }
}
