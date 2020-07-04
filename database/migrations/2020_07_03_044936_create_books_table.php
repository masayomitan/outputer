<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
        $table->increments('id');
        $table->unsignedInteger('user_id')->comment('ユーザーID');
        $table->string('book_image')->comment('ヘッダー画像');
        $table->string('title');
        $table->text('over_view')->comment('概要');
        $table->unsignedInteger('pages')->comment('ページ数');
        $table->unsignedInteger('release_date')->comment('販売日');

        $table->timestamps();

        $table->foreign('user_id')
            ->references('id')
            ->on('users')
            ->onDelete('cascade')
            ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books');
    }
}
