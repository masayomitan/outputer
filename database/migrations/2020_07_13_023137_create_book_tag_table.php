<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_tag', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('book_id')->comment('本ID');
            $table->unsignedInteger('tag_id')->comment('カテゴリーID');

            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');

            $table->unique([
                'book_id',
                'tag_id'
            ]);
        });
    }
    
    //Laravel7は外部キーを指定する場合下記のような記述もできるっぽい
    // Schema::table('book_tag', function (Blueprint $table) {
    //     $table->bigIncrements('id');
    //     $table->unsignedBigInteger('book_id');
    //     $table->foreign('book_id')->references('id')->on('books');
    // });


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('book_tag');
    }
}
