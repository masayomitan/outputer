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


    public function getBookTag(Int $tag_id){
        return $this->with('books')->where('id', $tag_id)->get();
    }

    public function tagStore(Array $_tag_names){
        if(!empty($_tag_names)){                      //タグがすでにあるかの判定
            foreach($_tag_names as $tag_name){        //タグがあるかforeachで探す.['name' => $tag_name]
                $tag_names[] = ['name' => $tag_name];
            }
            DB::table('tags')
            ->insertOrIgnore($tag_names);             //insertOrIgnoreであれば無視、なければ挿入
        }
    }

    public function getTagIds($tag_names){
        foreach($tag_names as $tag_name){
            $tag_id = $this::select('id')->where("name",$tag_name)->first();  //tagのidから、名前が一致したタグを$tag_idに代入
            $tag_ids[] = $tag_id->id;                                         //$tag_idのidを配列$tag_ids[]に全て代入しリターン
        }
        return $tag_ids;
    }

    public function getPopularTags() //人気タグ取得
    {
        return $this->withCount('books')->orderBy('books_count', 'desc')->take(5)->get();
    }
}
