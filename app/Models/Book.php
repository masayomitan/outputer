<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Intervention\Image\Facades\Image;

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

    public function sentences()
    {
        return $this->hasMany(Sentence::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
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
        return $this->with('user')->with('tags')
        ->where('id', $book_id)->first();
    }

    public function bookStore(Array $data, $file_name)
    {
        $this->book_image =  $file_name;
        $this->title = $data['title'];
        $this->author = $data['author'];
        $this->save();
        return;
    }

    public function bookDestroy(Int $user_id, Int $book_id)
    {
        return $this->where('user_id',$user_id)->where('id',$book_id)->delete();
    }

    //タグ
    public function bookTagStore(Array $tag_ids){
        //attch
        foreach($tag_ids as $tag_id) {
        $this->tags()->attach($tag_id);
        }
    }

    public function bookTagSync(Array $tag_ids){
        //syncメソッドは中間テーブルに設置しておくIDの配列を渡す。https://yshrfmru.hatenablog.com/entry/2019/03/24/131219
        $this->tags()->sync($tag_ids);
    }

    public function getTabInfoList(){
        $tab_info_list = [
        'saisinn' => [
            'param' => '',
            'icon_class' => 'fas fa-stream'
        ],
        '人気' => [
            'param' => '?mode=popular',
            'icon_class' => 'fas fa-fire'
        ],
    ];
    return $tab_info_list;
    }

}
