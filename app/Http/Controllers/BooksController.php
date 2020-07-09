<?php

namespace App\Http\Controllers;

use App\Models\Book;
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

    $user = auth()->user();

        // $book = $book->getBook($book->id);
        // $favorite_row = $favorite->getFavoriteRow($user->id, $book->id);
        // $comments = $comment->getComments($book->id);

        return view('books/index',[
            'user' => $user,
            'book' => $book,
            // 'comments' => $comments,
            // 'twitter_share_param' => $twitter_share_param,
            // 'favorite_id' => $favorite_id,
        ]);
    return view('books/index');
}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Book $book)
    {
        // $book_status_texts = $book->getPostBookStatusTexts();
        $user = auth()->user();
        return view('books.create',[
            'user' => $user,
            // 'book_status_texts' => $book_status_texts,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        $data = $request->all();
        $validator = Validator::make($data,[
            'title' => ['string', 'max:30'],
            'over_view' => ['string', 'max:20480'],
            'book_image' => ['file', 'image', 'mimes:jpeg,png,jpg', 'max:20480']
        ]);
        $validator->validate();




        $book = new Book;
        $book->bookStore($user->id, $data);
        $file_name = $request->file('book_image')->getClientOriginalName();
        $request->file('book_image')->storeAs('',$file_name);
        $book->save();
        // dd($book);
        return redirect('/books')->with('success', '投稿が完了しました。');

    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        $user = auth()->user();

        $book = $book->getBook($book->id);
        // $favorite_row = $favorite->getFavoriteRow($user->id, $book->id);
        // $comments = $comment->getComments($book->id);

        return view('books.show',[
            'user' => $user,
            'book' => $book,
            // 'comments' => $comments,
            // 'twitter_share_param' => $twitter_share_param,
            // 'favorite_id' => $favorite_id,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
