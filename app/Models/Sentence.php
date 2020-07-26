<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sentence extends Model
{

    protected $filable = [
        'text',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
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
      $this->text = $data['text'];
      $this->save();
      return;
    }


    public function getUserTimeLine(Int $user_id, $status_id)
    {
        //ユーザーを取得する
      return $this->where('user_id', $user_id)->where('status', $status_id)->orderBy('created_at', 'DESC')->paginate(6);
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

    public function getSentenceCount(Int $user_id)
    {
      return $this->where('user_id', $user_id)->count();
    }

    public function getPostSentenceStatusTexts() {
        //投稿時の最後のチェック
        $book_status_texts = ["kousatuに投稿する","下書きに保存する"];
        $book_status_texts = json_encode($book_status_texts);
        return $book_status_texts;
    }

    public function getFavoriteSentences(Int $user_id){
        $favorite_sentences = $this->whereHas('favorites', function($query) use ($user_id) {
            $query->where('user_id', $user_id);
            })->where('status', 0)->paginate(6);

        return $favorite_sentences;
      }

}
