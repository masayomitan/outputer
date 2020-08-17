<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Favorite;
use App\Models\Sentence;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class BooksController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Book $book, Tag $tags, User $user)
    {

        $books = Book::all();

        $popular_tags = $tags->getPopularTags();
        $popular_users = $user->getPopularUsers();
        $tab_info_list = $book->getTabInfoList();
        $keyword = $request->input("keyword");
        return view('books.index',compact('books'), [
            'keyword' => $keyword,
            'popular_tags' => $popular_tags,
            'popular_users' => $popular_users,
            'tab_info_list' => $tab_info_list,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    //ok
    public function create(Request $request)
    {
        $user = auth()->user();
        $keyword = $request->input("keyword");

        return view('books.create',[
            'keyword' => $keyword,
            'user' => $user,

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
        $request->file('book_image')->storeAs('/public/book_image',$file_name);


        $data = $request->all();
        $validator = Validator::make($data,[
            'title' => ['string', 'max:30'],
            'author' => ['string', 'max:30'],
            'book_image' => ['file', 'image', 'mimes:jpeg,png,jpg', 'max:3000']
        ]);
        $validator->validate();

        $book->bookStore($data, $file_name);
        //array_filterで連想配列の空チェック
        $tag_name = array_filter($data["tags"]);
        if(empty($tag_name)) {
            return redirect('/books')->with('success', '投稿が完了しました。');
        } else{
            //タグ挿入
            $tag->tagStore($data["tags"]);
            //$tagテーブルに挿入した値の名前からidを取得し中間テーブルへ
            $tag_ids = $tag->getTagIds($data["tags"]);
            //中間テーブルにidを設置
            $book->bookTagSync($tag_ids);
          }
          return redirect('/books')->with('success', '投稿が完了しました。');

    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book, Sentence $sentence, Favorite $favorite)
    {

        $user = auth()->user();

        $book = $book->getBook($book->id);
        $sentences = $sentence->getSentence($book->id);
        $favorite = $favorite->all();



        return view('books.show', compact('book'),[
            'user' => $user,
            'book' => $book,
            'sentences' => $sentences,
            'favorite' => $favorite,
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

        $user = auth()->user();
        $books = $book->getEditbook($user->id, $book->id);

        if(!isset($books)) {
            return redirect('books');
        }
        $tags = [];
        foreach($book->tags as $tag){
            $tags[] = $tag;
        }

        return view('books.edit', [
            'user' => $user,
            'books' => $books,
            'tags' => $tags,
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

        $file_name = $request->file('book_image')->getClientOriginalName();
        $request->file('book_image')->storeAs('public/book_image',$file_name);

        $data = $request->all();
        $validator = Validator::make($data,[
            'title' => ['string', 'max:30'],
            'author' => ['string', 'max:30'],
            'book_image' => ['file', 'image', 'mimes:jpeg,png,jpg', 'max:20480']
        ]);
        $validator->validate();
        $book->bookUpdate($book->id, $data, $file_name);


        #カテゴリ名の重複登録を防ぐ
        $storedTagNames = $tag->whereIn('name',$data["tags"])->pluck('name');
        $newTagNames = array_diff($data["tags"],$storedTagNames->all());
        //タグ挿入
        $tag->tagStore($newTagNames);
        //$tagテーブルに挿入した値の名前からidを取得し中間テーブルへ
        $tag_ids = $tag->getTagIds($data["tags"]);
        //中間テーブルにidを設置
        $book->bookTagSync($tag_ids);

        return redirect()->route('books.show', $book['id'])->with('success', '編集完了しました');
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
