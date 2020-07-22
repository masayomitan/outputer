<?php

namespace App\Models\Entity;


use Illuminate\Database\Eloquent\Model;

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

    public function favorites()
    {
      return $this->hasMany(Favorite::class);
    }

    public function sentences()
    {
      return $this->hasMany(Sentence::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }



    public function getUserTimeLine(Int $user_id, $status_id)
    {
        //ユーザーを取得する
      return $this->where('user_id', $user_id)->where('status', $status_id)->orderBy('created_at', 'DESC')->paginate(6);
    }

    public function getTimeLines(Int $status_id)
    {
      //全ての記事を取得する
      return $this->where('status', $status_id)->orderBy('created_at', 'DESC')->paginate(6);
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

    public function getEditBook(Int $user_id, Int $book_id)
    {
      return $this->where('user_id', $user_id)->where('id', $book_id)->first();
    }

    public function bookUpdate(Int $book_id, Array $data)
    {
      $this->id = $book_id;
      $this->title = $data['title'];
      $this->over_view = $data['over_view'];
    //   $this->status = $data['book_status_id'];
      $this->update();
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
        //syncメソッドは中間テーブルに設置しておくIDの配列を渡します。https://yshrfmru.hatenablog.com/entry/2019/03/24/131219
          $this->tags()->sync($tag_ids);
      }


    public function getPostBookStatusTexts() {
        //投稿時の最後のチェック
        $book_status_texts = ["kousatuに投稿する","下書きに保存する"];
        $book_status_texts = json_encode($book_status_texts);
        return $book_status_texts;
    }
}
