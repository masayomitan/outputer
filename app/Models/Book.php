<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'title',
        'over_view'
    ];

    public function getUrlAttribute()
    {
        return url($this->baseUri, $this->filename());
    }

    public function user()
    {
        //userIdに紐づく
        return $this->belongsTo(User::class);
    }

    public function favorites()
    {
      return $this->hasMany(Favorite::class);
    }

    public function output()
    {
      return $this->hasMany(Output::class);
    }

    public function tags()
    {
        //https://stackoverrun.com/ja/q/9982396,hasManyとbelongsToManyの違い忘れた時用
        return $this->belongsToMany(Tag::class);
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




    public function getBook(Int $book_id)
    {
        //本id取得
        return $this->with('user')->where('id', $book_id)->first();
    }

    public function bookStore(Int $user_id, Array $data)
    {
      //本登録項目をmodelにまとめcontrollerの記述を少なく
      $this->user_id = $user_id;
      $this->book_image = $data['book_image'];
      $this->title = $data['title'];
      $this->over_view = $data['over_view'];
    //   $this->status = $data['book_status_id'];
      $this->save();
      return;
    }

    public function getEditBook(Int $user_id, Int $id)
    {
      return $this->where('user_id', $user_id)->where('id', $id)->first();
    }

    public function bookUpdate(Int $book_id, Array $data)
    {
      $this->id = $book_id;
      $this->title = $data['title'];
      $this->over_view = $data['over_view'];
    //   $this->status = $data['book_status_id'];
      $this->update();
      return;
    }


    public function bookDestroy(Int $user_id, Int $book_id)
    {
        return $this->where('user_id',$user_id)->where('id',$book_id)->delete();
    }




    public function getPostBookStatusTexts() {
        //投稿時の最後のチェック
        $book_status_texts = ["kousatuに投稿する","下書きに保存する"];
        $book_status_texts = json_encode($book_status_texts);
        return $book_status_texts;
    }
}
