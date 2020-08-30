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
        $factory_sentence = factory(App\Models\Sentence::class)->create([
            "user_id" => $factory_user->id,
            'text_1' => "text_1",
            'text_2' => "text_2",
            'text_3' => "text_3",
            'status' => 0,
        ]);

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
    }

    
}
