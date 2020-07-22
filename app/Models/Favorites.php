<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorites extends Model
{
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

     //いいねしてるかの判定処理
     public function isFavorite(Int $user_id, Int $sentence_id)
     {
         return (boolean) $this->where('user_id', $user_id)->where('sentence_id', $sentence_id)->first();
     }

     public function favoriteStore(Int $user_id, Int $sentence_id)
     {
        $this->user_id = $user_id;
        $this->sentence_id = $sentence_id;
        $this->save();
        return;
     }

     public function favoriteDestroy(Int $favorite_id)
    {
        return $this->where('id', $favorite_id)->delete();
    }


}
