<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sentence extends Model
{

    protected $filable = [
        'text'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getSentences(Int $book_id)
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

}
