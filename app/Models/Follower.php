<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Follower extends Model
{
    public $timestamps = false;
    public $incrementing = false;

    // https://qiita.com/ayayo/items/ba38853bca0c2cc2acb7
    // IDリクワイアドと言うアンチパターンあり
    protected $primaryKey = [
        'following_id',
        'followed_id'
    ];

    protected $fillable = [
    'following_id',
    'followed_id'
    ];

    //to getTabInfoList
    public function getFollowCount(Int $user_id)
    {
      //user_idをfollowing_idでカウント
        return $this->where('following_id', $user_id)->count();
    }

    // //to getTabInfoList
    public function getFollowerCount(Int $user_id)
    {
      //user_idをfollowed_idでカウント
        return $this->where('followed_id', $user_id)->count();
    }

    public function followingIds(Int $user_id)
    {
      //user_idをfollowing_idとし、紐づいたfollowed_idを取得
        return $this->where('following_id', $user_id)->get('followed_id');
    }
}
