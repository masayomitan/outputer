<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Sentence;
use App\Models\Tag;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class BooksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Book $book)
    {

        $books = Book::all();
        return view('books.index',compact('books'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    //ok
    public function create(Book $book)
    {
        $user = auth()->user();
        $book_status_texts = $book->getPostBookStatusTexts();
        return view('books.create',[
            'user' => $user,
            'book_status_texts' => $book_status_texts,
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Book $book, Tag $tag)
    {
        $user = auth()->user();

        $file_name = $request->file('book_image')->getClientOriginalName();
        $request->file('book_image')->storeAs('public/book_image',$file_name);

        $data = $request->all();
        $validator = Validator::make($data,[
            'title' => ['string', 'max:30'],
            'over_view' => ['string', 'max:20480'],
            'book_image' => ['file', 'image', 'mimes:jpeg,png,jpg', 'max:20480']
        ]);
        $validator->validate();

        $book->bookStore($user->id, $data);
        //タグ挿入
        $tag->tagStore($data["tags"]);
        //$tagテーブルに挿入した値の名前からidを取得し中間テーブルへ
        $tag_ids = $tag->getTagIds($data["tags"]);
        //中間テーブルにidを設置
        $book->bookTagSync($tag_ids);

        $book->save();

        return redirect('/books')->with('success', '投稿が完了しました。');

    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book, Sentence $sentence)
    {
        $user = auth()->user();
        $book = $book->getBook($book->id);
        // $favorite_row = $favorite->getFavoriteRow($user->id, $book->id);
        $sentences = $sentence->getSentence($book->id);
        return view('books.show', compact('book'),[
            'user' => $user,
            'book' => $book,
            'sentences' => $sentences,
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        $book_status_texts = $book->getPostbookStatusTexts();
        $user = auth()->user();
        $books = $book->getEditbook($user->id, $book->id);

        // if(!isset($books)) {
        //     return redirect('books');
        // }
        // $tags = [];
        // foreach($book->tags as $tag){
        //     $tags[] = $tag;
        // }
        return view('books.edit', [
            'user' => $user,
            'books' => $books,
            // 'tags'=>$tags,
            // 'book_status_texts' => $book_status_texts,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book, Tag $tag)
    {


        $data = $request->all();
        $validator = Validator::make($data,[
            'title' => ['string', 'max:30'],
            'over_view' => ['string', 'max:20480'],
            'book_image' => ['file', 'image', 'mimes:jpeg,png,jpg', 'max:20480']
        ]);
        $validator->validate();
        $book->bookUpdate($book->id, $data);
        return back()->with('success', '編集完了しました');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book, Request $request)
    {
        $user = auth()->user();
        $book->bookDestroy($user->id, $book->id);
        $redirect = $request->input('redirect');
        if ($redirect == "on") {
            return redirect('/');
          } else {
            return back();
        }
    }

}
