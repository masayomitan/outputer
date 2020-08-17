<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Sentence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoritesController extends Controller
{

    public function store(Request $request, Favorite $favorite)
    {
        $user = auth()->user();
        $sentence_id = $request->sentence_id;
       //取得した$sentence_idをisFavoriteメソッドに送り込んで既にいいねしてるかの判定を行う
        $is_favorite = $favorite->isFavorite($user->id, $sentence_id);

       //否定されたらfavoriteStore処理
        $favorite->favoriteStore($user->id, $sentence_id);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sentence $sentence)
    {
        $user = auth()->user();
        $sentence = $sentence->id;
        $favorite_id = Favorite::where('sentence_id', $sentence)->where('user_id', $user->id)->first();
        $favorite_id->delete();
        return redirect()->back();
    }
}
