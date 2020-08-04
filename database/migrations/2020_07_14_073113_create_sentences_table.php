<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSentencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sentences', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->unsigned()->nullable()->comment('ユーザーID');
            $table->unsignedInteger('book_id')->comment('コメントID');
            $table->text('text_1')->comment('本文1');
            $table->text('text_2')->comment('本文2');
            $table->text('text_3')->comment('本文3');
            $table->unsignedSmallInteger('status')->default(0)->comment('0:公開,1:非公開');
            $table->timestamps();

            $table->index('id');
            $table->index('user_id');
            $table->index('book_id');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('book_id')->references('id')->on('books');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sentences');
    }
}
