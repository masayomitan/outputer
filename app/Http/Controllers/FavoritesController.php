<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;

class FavoritesController extends Controller
{

    public function index()
    {
        //
    }


    public function create()
    {
        //
    }

   public function store(Request $request, Favorite $favorite)
   {
       $user = auth()->user();
       //$sentence_id取得
       $sentence_id = $request->sentence_id;
       //取得した$sentence_idをisFavoriteメソッドに送り込んで既にいいねしてるかの判定を行う
       $is_favorite = $favorite->isFavorite($user->id, $sentence_id);
       //否定されたらfavoriteStore処理
       if(!$is_favorite)
       {
           $favorite->favoriteStore($user->id, $sentence_id);
       }
        //ここからはview表示の処理
        $favorited_count = $favorite->getFavoritedCount($sentence_id);
        $favorite_row = $favorite->getFavoriteRow($user->id, $sentence_id);

        $favorite_list = [
            "favorited_count" => $favorited_count,
            "favorite_id" => $favorite_row->id,
        ];

        return $favorite_list;
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Favorite $favorite)
    {
        //$favoriteのカラムを新たに代入
        $user_id = $favorite->user_id;
        $sentence_id = $favorite->sentence_id;
        $favorite_id = $favorite->id;

        //あるなし判定
        $is_favorite = $favorite->isFavorite($user_id, $sentence_id);
        if($is_favorite) {
            $favorite->FavoriteDestroy($favorite_id);
        }
        
        $favorited_count = $favorite->getFavoritedCount($sentence_id);
        $favorite_row = $favorite->getFavoriteRow($user_id, $sentence_id);

        if(isset($favorite_row)) {
            $favorite_id = $favorite_row->id;
        } else {
            $favorite_id = NULL;
        }

        $favorite_list = [
            "favorited_count" => $favorited_count,
            "favorite_id" => $favorite_id,
        ];

        return $favorite_list;
    }
}
