<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
   //指定したカラムに対してのみ、 create()やupdate() 、fill()が可能
   protected $fillable = [
    'title',
    'over_view'
  ];

  public function user()
  {
    //UserClass参照
    return $this->belongsTo(User::class);
  }

  public function favorites()
    {
      return $this->hasMany(Favorite::class);
    }

    public function output()
    {
      return $this->hasMany(Output::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function getUserTimeLine(Int $user_id, $status_id)
    {
      return $this->where('user_id', $user_id)->where('status', $status_id)->orderBy('created_at', 'DESC')->paginate(6);
    }

    public function getBookCount(Int $user_id)
    {
      return $this->where('user_id', $user_id)->count();
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
      return $this->with('user')->where('id', $book_id)->first();
    }

    public function BookStore(Int $user_id, Array $data){
      $this->user_id = $user_id;
      $this->header_image = $data['binary_image'];
      $this->title = $data['title'];
      $this->body = $data['body'];
      $this->status = $data['article_status_id'];
      $this->save();
      return
    }

    public function getEditBook(Int $user_id, Int $book_id){
      return $this->where('user_id', $user_id)->where('id', $book_id)->first();
    }

    public function BookUpdate(Int $book_id, Array $data){
      $this->id = $book_id;
      $this->title = $data['title'];
      $this->body = $data['over_view'];
      $this->status = $data['book_status_id'];
      $this->update();
      return;
    }

    public function bookDestroy(Int $user_id, Int $book_id)
    {
      return $this->where('user_id',$user_id)->where('id',$book_id)->delete();
    }

    public function bookTagStore(Array $tag_ids){
        foreach($tag_ids as $tag_id){
            $this->tags()->attach($tag_id);
        }
    }

    //sync == 同期
    public function bookTagSync(Array $tag_ids){
        $this->tags()->sync($tag_ids);
    }

    public function getPostBookStatusTexts(){
        $book_status_texts = ["kousatuに投稿する","下書きに保存する"];
        $book_status_texts = json_encode($book_status_texts);

        return $book_status_texts;
      }

    public function getTwitterSharaParam($book){
      $hash_tag = "";
      foreach($book->tags as $tag){
        $hash_tag.=$tag->name.",";
      }

      $url = "url=".url()->current();
      $text = "text=".$book->title;
      $via = "via=".config('app.name');
      //','を取り除きhttps://www.php.net/manual/ja/function.rtrim.php
      $hashtags = "hashtags=".rtrim($hash_tag, ',');
      //implode使用,https://www.php.net/manual/ja/function.implode.php
      $param = implode('&',[$url,$text,$via,$hashtags]);
      return $param;
    }

    public function getPopularBooks(){
        $tab_info_list = [
            'タイムライン' => [
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

    public function getFavoriteBooks(Int $user_id){
      $favorite_books = $this->whereHas('favorites', function($query) use ($user_id) {
        $query->where('user_id', $user_id);
      })->where('status', 0)->paginate(6);

      return $favorite_books;
    }



    }

