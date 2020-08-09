<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Sentence extends Model
{

    protected $filable = [
        'text',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
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
        return $this->with('user')->where('book_id', $book_id)->get();
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


    public function getUserTimeLine(Int $user_id, $status_id)
    {
    //innerjoinのクエリビルダを使いbooksテーブルと結合している
    return $this->where('user_id', $user_id)->where('status', $status_id)->join('books', 'book_id', '=', 'books.id')->orderBy('sentences.created_at', 'DESC')->paginate(6);
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
        // $sentence_status_texts = json_encode($sentence_status_texts, JSON_UNESCAPED_UNICODE);
        return $sentence_status_texts;
    }


    //to  User.php/getTabInfoList
    public function getSentenceCount(Int $user_id)
    {
        return $this->where('user_id', $user_id)->count();
    }

    //to  User.php/getTabInfoList
    public function getFavoriteSentences(Int $user_id){
        //いいねした記事取得、
        $favorite_sentences = $this->whereHas('favorites', function($query) use ($user_id) {
            $query->where('user_id', $user_id);
            })->where('status', 0)->paginate(6);
        return $favorite_sentences;
        }


}
