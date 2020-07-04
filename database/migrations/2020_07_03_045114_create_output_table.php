<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOutputTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('output', function (Blueprint $table) {
        $table->increments('id');
        $table->unsignedInteger('user_id')->comment('ユーザーID');
        $table->unsignedInteger('book_id')->comment('コメントID');
        $table->text('text')->comment('本文');
        $table->timestamps();

        $table->index('id');
        $table->index('user_id');
        $table->index('book_id');

        $table->foreign('user_id')
          ->references('id')
          ->on('users')
          ->onDelete('cascade')
          ->onUpdate('cascade');

        $table->foreign('book_id')
          ->references('id')
          ->on('books')
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
        Schema::dropIfExists('output');
    }
}
