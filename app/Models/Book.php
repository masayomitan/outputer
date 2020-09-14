<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;

class Book extends Model
{
    protected $fillable = [
        'title',
        'author'
    ];

    public function getUrlAttribute()
    {
        return url($this->baseUri, $this->filename());
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sentences()
    {
        return $this->hasMany(Sentence::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }


    public function getBook(Int $book_id) //一冊取得
    {
        //本id取得
        return $this->with('user')->with('tags')
        ->where('id', $book_id)->first();
    }

    public function getBooksWithNewSentences($book)
    {
        return $this->where('books.id', '<>', $book)
                    ->where('status', 0)
                    ->join('sentences', 'book_id', '=','books.id')
                    ->select('books.*')
                    ->groupBy('book_id')
                    ->orderBy(DB::raw('MAX(sentences.updated_at)'), 'DESC')->paginate(8);
    }

    public function getAllBooksWithNewSentences($book)
    {
        return $this->where('books.id','<>',  $book)
                    ->where('status', 0)
                    ->join('sentences', 'book_id', '=','books.id')
                    ->select('books.*')
                    ->groupBy('book_id')
                    ->orderBy(DB::raw('MAX(sentences.updated_at)'), 'DESC')->get();
    }

    public function getBooksWithPopularSentences($book)
    {
        return $this->withCount('sentences')->where('books.id', '<>', $book)
                    ->having('sentences_count' , '>=', 1)
                    ->orderBy('sentences_count', 'desc')
                    ->orderBY('updated_at', 'DESC' )->paginate(8);
    }
    public function getAllBooksWithPopularSentences($book)
    {
        return $this->withCount('sentences')->where('books.id', '<>', $book)
                    ->having('sentences_count' , '>=', 1)
                    ->orderBy('sentences_count', 'desc')
                    ->orderBY('updated_at', 'DESC' )->get();
    }



    public function getFollowedTimeLines(Int $user_id, Array $follow_ids)
    {
        $follow_ids[] = $user_id;
        return $this->whereIn('user_id', $follow_ids)->orderBy('created_at', 'DESC')->paginate(50);
    }


    public function bookStore(Array $data)
    {
        $this->book_image =  $data["book_image"];
        $this->title = $data['title'];
        $this->author = $data['author'];
        $this->save();
        return;
    }


    public function bookTagSync(Array $tag_ids){
        //syncメソッドは中間テーブルに設置しておくIDの配列を渡す。https://yshrfmru.hatenablog.com/entry/2019/03/24/131219
        //配列で見てるのでsync
        $this->tags()->sync($tag_ids);
    }

}
