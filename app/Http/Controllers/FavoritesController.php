<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;

class Favorites extends Controller
{
    
    public function index(){

    }

    public function create(){

    }

    public function store(Request $request, Favorite $favorite){
        $user = auth()->user();
        $book_id = $request->book_id;
        $is_favorite = $favorite->isFavorite($user->id, $book_id);

        if(!$is_favorite){
            $favorite->storeFavorite($user->id, $book_id);
            return back();
        }
        return back();
    }

    public function show($id){

    }

    public function edit($id){

    }

    public function update(Request $request, $id){

    }

    public function destroy(Favorite $favorite){
        $user_id = $favorite->user_id;
        $book_id = $favorite->book_id;
        $favorite_id = $favorite->id;
        $is_favorite = $favorite->isFavorite($user_id, $book_id);

        if($is_favorite) {
            $favorite->destroyFavorite($favorite_id);
            return back();
        }
        return back();
    }
}
