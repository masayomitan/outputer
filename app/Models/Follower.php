<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Follower extends Model
{
  protected $primaryKey = [
    'following_id',
    'followed_id'
  ];

  protected $fillable = [
    'following_id',
    'followed_id'
  ];

    //https://readouble.com/laravel/5.8/ja/eloquent.html
  public $timestamps = false;
  public $incrementing = false;

  public function getFollowCount($user_id)
  {
    return $this->where('following_id', $user_id)->count();
  }

  public function getFollowerCount($user_id)
  {
    return $this->where('followed_id', $user_id)->count();
  }

  public function followingIds(Int $user_id)
  {
    return $this->where('following_id', $user_id)->get('followed_id');
  }

}
