<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TagsController extends Controller
{
    public function index()
    {
        //
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


    public function show(Tag $tag, User $user,Book $book )
    {

        $bookTag = $tag->getBookTag($tag->id);



        $popular_tags = $tag->getPopularTags();
        $popular_users = $user->getPopularUsers();
        return view('tags.show',[
            // 'book'=> $book,
            'bookTag' => $bookTag,

            'popular_tags' => $popular_tags,
            'popular_users' => $popular_users,
        ]);
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
