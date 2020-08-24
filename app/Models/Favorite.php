<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    public $timestamps = false;

    public function sentence()
    {
        return $this->belongsTo(Sentence::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
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


    public function getFavoritedCount(Int $sentence_id)
    {
        $favorited_count = count($this->where('sentence_id', $sentence_id)->get());
        return $favorited_count;
    }

    public function getTotalFavoritedCount(Int $user_id)
    {
        $sentence = new Sentence;    //引数がオブジェクトでは無いのでインスタンス新規作成
        $sentence_ids = $sentence::all()->where('user_id', $user_id)->pluck('id');   //all()で全ての値を取得後、->pluckでidをkeyに選択,user_idが含まれているデータだけ抽出
        $total_favorited_count = count($this->whereIn('sentence_id',$sentence_ids)->get());   //whereInで上で取得したuser_idが入っているsentence_idを取得しcountする。
        return $total_favorited_count;
    }

}
