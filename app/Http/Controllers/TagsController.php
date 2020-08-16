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

        $user = auth()->user();
        $data = $request->all();
        $books = $book->all();
        // var_dump($data["book_id"]);
        foreach($books as $book)
            $book_ids = $book->id;
            // var_dump($book_ids);
            // $book_id = $book["id"];
            // foreach($data as $data_id)
            //     $data_id = $data["book_id"];
                // var_dump($data["book_id"]);
                // var_dump($book_id);
                // var_dump($book);
                // dd($book);



        // var_dump((int)$data["book_id"]);
        // $booking = array_search($data["book_id"], ($book->id));
        // var_dump($booking );


        // $validator = Validator::make($data,[
        //     'tags' => ['string', 'max:10'],
        // ]);
        // $validator->validate();
        #カテゴリ名の重複登録を防ぐ
        $storedTagNames = $tag->whereIn('name',$data["tags"])->pluck('name');
        $newTagNames = array_diff($data["tags"],$storedTagNames->all());
        //タグ挿入
        $tag->tagStore($newTagNames);
        //$tagテーブルに挿入した値の名前からidを取得し中間テーブルへ
        $tag_ids = $tag->getTagIds($data["tags"]);

        //中間テーブルにidを設置
        $book->bookTagSync($tag_ids);

        return redirect()->route('books.show', $book['id'])->with('success', 'タグ追加完了しました');
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
