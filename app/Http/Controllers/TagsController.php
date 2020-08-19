<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TagsController extends Controller
{
    public function index()
    {
        //
    }


    public function create(Request $request, Book $book, Tag $tag)
    {
        $user = auth()->user();
        $book_id = $request->id;
        $book->id = $book_id;
        $book = $book->getBook($book->id);

        $tags = [];
        foreach($book->tags as $tag){
            $tags[] = $tag;
        }
        $tags = DB::table('tags')->get();

        return view('tags.create', [
            'user' => $user,
            'book' => $book,
            'tags' => $tags,
        ]);
    }


    public function store(Request $request,Book $book, Tag $tag)
    {
    }


    public function show(Tag $tag, User $user)
    {

        //タグの紐づいた本の情報取得
        $bookTag = $tag->getBookTag($tag->id);
        $popular_tags = $tag->getPopularTags();
        $popular_users = $user->getPopularUsers();
        return view('tags.show',[
            'bookTag' => $bookTag,
            'popular_tags' => $popular_tags,
            'popular_users' => $popular_users,
        ]);
    }


    public function edit(Tag $tag)
    {

    }


    public function update(Request $request, Tag $tag)
    {

    }

    public function destroy($id)
    {
        //
    }
}
