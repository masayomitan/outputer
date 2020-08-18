<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Sentence extends Model
{

    protected $filable = [
        'text_1',
        'text_2',
        'text_3',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function book()
    {
        return $this->belongsTo(User::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }


    public function getSentence(Int $book_id)
    {
        return $this->with('user')->where('book_id', $book_id)->orderBy('updated_at', 'DESC')->get();
    }


    //sentencesのstoreメソッドの作成、引数はidとテキストを配列で
    public function sentenceStore(Int $user_id, Array $data)
    {
        $this->user_id = $user_id;
        $this->book_id = $data['book_id'];
        $this->text_1 = $data['text_1'];
        $this->text_2 = $data['text_2'];
        $this->text_3 = $data['text_3'];
        $this->status = $data['status'];
        $this->save();
        return;
    }

    public function getBookEditSentence(Int $user_id, Int $sentence_id)
    {
        return $this
        ->where('user_id', $user_id)->where('sentences.id', $sentence_id)
        ->join('books', 'books.id', '=','book_id')
        ->select('sentences.*', 'books.title', 'books.author', 'books.book_image')
        ->orderBy('sentences.id')->first();
    }

    public function getEditSentence(Int $user_id, Int $sentence_id)
    {
        return $this->where('user_id', $user_id)->where('id', $sentence_id)->first();
    }

    public function sentenceUpdate(Int $user_id, Array $data)
    {
        $this->user_id = $user_id;
        $this->text_1 = $data['text_1'];
        $this->text_2 = $data['text_2'];
        $this->text_3 = $data['text_3'];
        $this->status = 0;
        $this->update();
        return;
    }

    public function sentenceDestroy(Int $user_id, Int $sentence_id)
    {
        return $this->where('user_id',$user_id)->where('id',$sentence_id)->delete();
    }

    public function getUserTimeLine(Int $user_id, $status_id)
    {
        return $this
        ->where('user_id', $user_id)->where('status', $status_id)
        ->join('books', 'books.id', '=','book_id')
        ->select('sentences.*', 'books.title', 'books.author', 'books.book_image')
        ->orderBy('sentences.updated_at', 'DESC')->paginate(6);
    }

    public function getTimeLines(Int $status_id)
    {
        //全ての記事を取得する
        return $this->where('status', $status_id)->orderBy('created_at', 'DESC')->paginate(6);
    }

    public function getFollowedTimeLines(Int $user_id, Array $follow_ids)
    {
        //自身とフォローしているユーザーを結合する
        $follow_ids[] = $user_id;
        return $this->whereIn('user_id', $follow_ids)->orderBy('created_at', 'DESC')->paginate(50);
    }


    public function getPostSentenceStatusTexts() {
        //投稿時の最後のチェック
        $sentence_status_texts = ["投稿準備完了" => 0, "一旦下書きに" => 1];
        return $sentence_status_texts;
    }


    //to  User.php/getTabInfoList
    public function getSentenceCount(Int $user_id)
    {
        return $this->where('user_id', $user_id)->count();
    }

    //to  User.php/getTabInfoList
    public function getFavoriteSentences(Int $user_id)
    {
        //いいねした記事取得、joinでbookstableも取得,whereHasでリクエストしたuserのいいねだけにする
        $favorite_sentences = $this->join('books', 'books.id', '=','book_id')
        ->select('sentences.*', 'books.title', 'books.author', 'books.book_image')
        ->whereHas('favorites', function($query) use ($user_id) {
            $query->where('user_id', $user_id);
        })->where('status', 0)->paginate(6);
        return $favorite_sentences;
    }

    public function sentenceWithCount(Int $book_id){
        return $this->withCount('favorites')->orderBy('favorites_count', 'desc')->get();
    }


}
