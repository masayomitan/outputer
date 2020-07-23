<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Tag extends Model
{
    protected $fillable = [
          'name'
    ];
    public $timestamps = false;

    public function books()
    {
        return $this->belongsToMany(Book::class);
    }


    public function tagStore(Array $_tag_names){
        //タグがすでにあるかの判定
        if(!empty($_tag_names)){
            //タグがあるかforeachで探す.['name' => $tag_name]
            foreach($_tag_names as $tag_name){
                $tag_names[] = ['name' => $tag_name];
            }
            //insertOrIgnoreであれば無視、なければ挿入
            DB::table('tags')
            ->insertOrIgnore($tag_names);
        }
      }

    public function getTagIds($tag_names){
    foreach($tag_names as $tag_name){
        //idから名前を1から取り出して$tag_idに代入
        $tag_id = $this::select('id')->where("name",$tag_name)->first();
        //配列$tag_ids[]を作成して$tag_idのidを全て代入
        $tag_ids[] = $tag_id->id;
    }
    return $tag_ids;
    }


    public function getPopularTags(){
        //withCountでレコード数をとる
        //0で公開しているbooksのデータを呼び出し
        $popular_tags = $this::withCount([ 'books' => function($query) {
            $query->where('status',0);
        }])
        ->orderBy('books_count', 'desc')
        ->take(5)
        ->get();
        return $popular_tags;
    }

}