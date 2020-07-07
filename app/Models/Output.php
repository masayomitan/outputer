<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Output extends Model
{
    protected $fillable =[
        'text'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getOutput(Int $book_id)
    {
        return $this->with('user')->where('book_id', $book_id)->get();
    }

    public function commentStore(Int $user_id, Array $data)
    {
      $this->user_id = $user_id;
      $this->book_id = $data['book_id'];
      $this->text = $data['text'];
      $this->save();
      return;
    }
}
