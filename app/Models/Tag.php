<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Tags extends Model
{
  public $timestamps = false;

  public function books(){
    return $this->belongsToMany(Book::class);
  }

  public function tagStore(Array $_tag_names){
    #すでにタグ名が登録されている場合、登録しない
    if(empty($_tag_names)){
      foreach($_tag_names as $tag_name){
        $tag_names[] = ['name' => $tag_name];
    }
    //insertOrIgnoreはデータが存在すれば挿入しない、あれば挿入
    DB::table('tags')->insertOrIgnore($tag_names);
    }
  }

  public function getTagIds($tag_names){
    foreach($tag_names as $tag_name){
        $tag_id = $this::select('id')->where('name', $tag_name)->first();
        $tag_ids[] = $tag_id->id;
    }
    return $tag_ids;
  }

  public function getPopularTags(){
      $popular_tags = $this::withCount(['books' => function($query){
          $query->where('status',0);
      }])
      ->orderBy('books_count', 'desc')
      ->take(5)
      ->get();
      return $popular_tags;
  }
}
