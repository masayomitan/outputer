<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    public $timestamps = false;

    public function sentence()
    {
        return $this->belongsTo(sentence::class);
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



    public function getFavoritedCount(Int $sentence_id) {
        //一個取得
        $favorited_count = count($this->where('sentence_id', $sentence_id)->get());
        return $favorited_count;
    }

    public function getFavoriteRow(Int $user_id, Int $sentence_id) {
        //行取得
        $favorite_row = $this->where([
            ['sentence_id', $sentence_id],
            ["user_id", $user_id],
        ])->first();

        return $favorite_row;
    }

    public function getTotalFavoritedCount(Int $user_id)
    {
        $sentence = new Sentence;
        //all()で全ての値を取得後、->pluckでidをkeyに選択,user_idが含まれているデータだけ抽出
        $sentence_ids = $sentence::all()->where('user_id', $user_id)->pluck('id');
        //whereInでuser_idが入っているsentence_idを取得しcountする。
        $total_favorited_count = count($this->whereIn('sentence_id',$sentence_ids)->get());
        return $total_favorited_count;
    }

}
