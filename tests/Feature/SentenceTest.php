<?php

use App\Models\Sentence;
use App\Models\Favorite;
use App\Models\Tag;
use App\Models\User;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;



class SentenceTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function testCreateSentence()
    {
        #アップロードした記事データがDBにあるかテスト
        $factory_user = factory(App\Models\User::class)->create();
        $factory_book = factory(App\Models\Book::class)->create();
        $factory_sentence = factory(App\Models\Sentence::class)->create();

        $response = $this->actingAs($factory_user);
        $testText_1 = $factory_sentence->text_1;
        $testText_2 = $factory_sentence->text_2;
        $testText_3 = $factory_sentence->text_3;

        $response->post('/sentences', ['text_1' => $testText_1, 'text_2' => $testText_2,'text_3' => $testText_3]);
        $response->assertDatabaseHas('sentences', [
            'text_1' => $testText_1,
            'text_2' => $testText_2,
            'text_3' => $testText_3,
            'status' => 0,
        ]);

        #文章0文字または35文字以上の記事が投稿されないかテスト
        $textLengths = [0,36];
        foreach($textLengths as $length) {
            $Bad_testText = substr(str_shuffle(str_repeat('01234567890123456789abcdefghijklmnopqrstuvwxyz', $length)), 0, $length);
            $response->post('/sentences', ['text_1' => $Bad_testText, 'text_2' => $Bad_testText, 'text_3' => $Bad_testText]);
            $response->assertDatabaseMissing('sentences', [
                'text_1' => $Bad_testText,
                'text_2' => $Bad_testText,
                'text_3' => $Bad_testText,
            ]);
        }
    }

    public function testUpdateSentence()
    {
        #アップロードしたデータがDBにあるかテスト
        $factory_user = factory(App\Models\User::class)->create();
        $factory_sentence = factory(App\Models\Sentence::class)->create();
        $response = $this->actingAs($factory_user);
        $sentence_id = $factory_sentence->id;

        #アップデート用のプロフィールデータを生成する
        $factory_sentence_update = factory(App\Models\Sentence::class)->make();
        $testStatus = $factory_sentence_update->status;
        $testText_1 = $factory_sentence->text_1;
        $testText_2 = $factory_sentence->text_2;
        $testText_3 = $factory_sentence->text_3;

        $response->post('/sentences/'.$sentence_id, ['text_1' => $testText_1, 'text_2' => $testText_2,'text_3' => $testText_3, 'status' => $testStatus]);
        $response->assertDatabaseHas('sentences', [
            'text_1' => $testText_1,
            'text_2' => $testText_2,
            'text_3' => $testText_3,
            'status' => $testStatus,
        ]);
    }
}
