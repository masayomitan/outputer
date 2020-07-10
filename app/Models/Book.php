<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'title',
        'over_view'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getBook(Int $book_id)
    {
        return $this->with('user')->where('id', $book_id)->first();
    }

    public function bookStore(Int $user_id, Array $data)
    {
      $this->user_id = $user_id;
      $this->book_image = $data['book_image'];


      $this->title = $data['title'];
      $this->over_view = $data['over_view'];
    //   $this->status = $data['book_status_id'];
      $this->save();
      return;
    }


    public function bookDestroy(Int $user_id, Int $book_id)
    {
        return $this->where('user_id',$user_id)->where('id',$book_id)->delete();
    }

    public function getPostBookStatusTexts() {
        $book_status_texts = ["kousatuに投稿する","下書きに保存する"];
        $book_status_texts = json_encode($book_status_texts);
        return $book_status_texts;
    }
}
