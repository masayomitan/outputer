<?php

use App\Models\Sentence;
use App\Models\Favorite;
use App\Models\Tag;
use App\Models\BookTag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;



class BookTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function testCreateBook()
    {
        #アップロードした記事データがDBにあるかテスト
        $factory_user = factory(App\Models\User::class)->create();
        $factory_book = factory(App\Models\Book::class)->create();
        $factory_tag  = factory(App\Models\Tag::class)->create();


        $response = $this->actingAs($factory_user);

        $book_id = $factory_book->id;
        $testTitle = $factory_book->title;
        $testAuthor = $factory_book->author;
        $testTags = $factory_tag->name;

        $response->post('/books', ['title' => $testTitle, 'author' => $testAuthor, 'tags' => $testTags,]);
        $response->assertDatabaseHas('books', [
            "book_image"=> "test_image",
            'title' => $testTitle,
            'author' => $testAuthor,
        ]);

        #登録したタグ名が登録テーブルに登録されているかテスト
        $response->assertDatabaseHas('tags', [
            'name' => $testTags,
        ]);

        #不正な形式の記事が登録されないかテスト
        #タイトル0文字または51文字以上の記事が投稿されないかテスト
        $titleLengths = [0,51];
        foreach($titleLengths as $length) {
            $Bad_testTitle = substr(str_shuffle(str_repeat('01234567890123456789abcdefghijklmnopqrstuvwxyz', $length)), 0, $length);
            $response->post('/books', ['title' => $Bad_testTitle, 'author' => $testAuthor]);
            $response->assertDatabaseMissing('books', [
            'title' => $Bad_testTitle,
            'author' => $testAuthor,
        ]);
        }
        #タイトル0文字または51文字以上の記事が投稿されないかテスト
        $authorLengths = [0,31];
        foreach($authorLengths as $length) {
            $Bad_testAuthor = substr(str_shuffle(str_repeat('0123456789abcdefghijklmnopqrstuvwxyz', $length)), 0, $length);
            $response->post('/books', ['title' => $testTitle, 'author' => $Bad_testAuthor]);
            $response->assertDatabaseMissing('books', [
            'title' => $testTitle,
            'author' => $Bad_testAuthor,
        ]);
        }
    }
}

