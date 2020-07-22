<?php

namespace App\Models\Entity;

use Illuminate\Database\Eloquent\Model;

//中間テーブル
class BookTag extends Model
{
    protected $table = 'book_tag';
    public $timestamps = false;
}
