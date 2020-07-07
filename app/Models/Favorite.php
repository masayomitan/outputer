<?php

namespace App\Models;

use App\Book;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
  public $timestamps = false;

  public function book()
  {
      return $this->belomgsTo(Book::class);
  }

   //いいねしているかどうかの判定処理
   public function isFavorite(Int $user_id, Int $book_id)
   {
       return (boolean) $this->where('user_id', $user_id)->where('book_id', $book_id)->first();
   }

   public function storeFavorite(Int $user_id, Int $book_id){
     $this->user_id = $user_id;
     $this->book_id = $book_id;
     $this->save();
     return;
   }

   public function destroyFavorite(Int $favorite_id){
     return $this->where('id', $favorite_id)->delete();
   }

   public function getTotalFavoritedCount(Int $user_id){
       $book = new Book();
       $book_ids = $book::all()->where('user_id', $user_id)->pluck('id');
       //pluck == array_column

       $total_favorited_count = count($this->whereIn('book_id', $book_ids)->get());
       return $total_favorited_count;
   }
}
