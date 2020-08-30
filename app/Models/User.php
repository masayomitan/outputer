<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_image'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function followers()
    {
        return $this->belongsToMany(self::class, 'followers', 'followed_id', 'following_id');
    }
    public function follows()
    {
        return $this->belongsToMany(self::class, 'followers', 'following_id', 'followed_id');
    }


    public function sentences()
    {
        return $this->hasMany(sentence::class);
    }
    public function favorites()
    {
        return $this->belongsToMany(sentence::class)->withTimestamps();
    }



    public function getAllUsers($user_id){
        return $this->where('id', '<>', $user_id)->paginate(6);
    }


    public function userUpdate(Array $params)
    {

        if(isset($params['profile_image'])){
        $this::where('id', $this->id)
        ->update([
            'name' => $params['name'],
            'self_introduction' => $params['self_introduction'],
            'profile_image' => $params['profile_image'],
            'email' => $params['email'],
        ]);
    } else {
        $this::where('id', $this->id)
        ->update([
            'name' => $params['name'],
            'self_introduction' => $params['self_introduction'],
            'email' => $params['email'],
        ]);
    }
    return;
    }

    // フォローする
    public function follow(Int $user_id)
    {
        return $this->follows()->attach($user_id);
    }

    // フォロー解除
    public function unfollow(Int $user_id)
    {
        return $this->follows()->detach($user_id);
    }

    // フォローしているか
    public function isFollowing(Int $user_id)
    {
        return (boolean) $this->follows()->where('followed_id', $user_id)->first(['id']);
    }
    // フォローされているか
    public function isFollowed(Int $user_id)
    {
        return (boolean) $this->followers()->where('following_id', $user_id)->first(['id']);
    }


    public function getFollowingUsers($user_id)
    {
        return $this->follows()->where('following_id', $user_id)->paginate(6);
    }

    public function getFollowerUsers($user_id)
    {
    return $this->followers()->where('followed_id', $user_id)->paginate(6);

    }


    //投稿ユーザーのいいね数ランキング
    public function getPopularUsers() {
        $favorite_list = Favorite::all();

        foreach($favorite_list as $favorite_item) {    //Favoriteのsentence_idに紐づいたuser_idを全部取り出し
            $user_id_list[] = $favorite_item->sentence()->value('user_id');
        }

        if(empty($user_id_list)) {    //空ならそのまま
            $popular_users = [];
        } else {

            $rank_list = array_count_values($user_id_list);   //array_count_valuesでid集計
            $rank_keys = array_keys($rank_list);              //array_keysでindex番号振り分け
            $rank_keys = array_slice($rank_keys, 0, 10);      //array_sliceで振り分けた番号を取り出し

            $popular_users = $this->whereIn('id',$rank_keys)
            ->orderBy('id', 'desc')
            ->take(5)
            ->get();
        }
        return $popular_users;
    }


    //to getUserInfoList
    public function getTabInfoList(){
        $sentence = new Sentence();
        $follower = new Follower();

        $user_id = $this->id;
        $sentence_count = $sentence->getSentenceCount($user_id);
        $favorite_count = $sentence->getFavoriteSentences($user_id)->total();
        $follow_count = $follower->getFollowCount($user_id);
        $follower_count = $follower->getFollowerCount($user_id);

        $tab_info_list = [
            $sentence_count." " => [
                "link" => "/users/{$user_id}",
            ],
            $favorite_count."  " => [
                "link" => "/users/{$user_id}/favorites",
            ],
            $follow_count."   " => [
                "link" => "/users/{$user_id}/following",
            ],
            $follower_count."    "=> [
                "link" => "/users/{$user_id}/followers",
            ],];
    return $tab_info_list;
    }

    //to getUserInfoList
    public function getFollowStatuses($login_user) {
        if(isset($login_user)) {
        $follow_statuses["is_following"] = $login_user->isFollowing($this->id);
        $follow_statuses["is_followed"] = $login_user->isFollowed($this->id);
        } else {
        $follow_statuses["is_following"] = false;
        $follow_statuses["is_followed"] = false;
        }
        return $follow_statuses;
    }


    public function getUserInfoList(){
        $favorite = new Favorite;

        $login_user = auth()->user();
        $follow_statuses = $this->getFollowStatuses($login_user);
        $total_favorited_count = $favorite->getTotalFavoritedCount($this->id);

        $user_info_list["user"] = $this;
        $user_info_list["total_favorited_count"] = $total_favorited_count;
        $user_info_list["is_following"] = $follow_statuses["is_following"];
        $user_info_list["is_followed"] = $follow_statuses["is_followed"];
        $user_info_list["tab_info_list"] = $this->getTabInfoList();
    return $user_info_list;
    }

    public function isSelfSentence($request,$user){
        $login_user = auth()->user();
        if(isset($login_user)) {
            if($login_user->id != $user->id) {
                return FALSE;
                redirect($request->path());
            }
        } else {
            return FALSE;
            redirect($request->path());
        }
        return true;
    }

}
