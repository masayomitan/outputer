<?php

use App\Models\Sentence;
use App\Models\Favorite;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;



class TagTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function testCreateTAg()
    {
        #アップロードした記事データがDBにあるかテスト
        $factory_user = factory(App\Models\User::class)->create();
        $factory_book = factory(App\Models\Book::class)->create();
        $factory_tag = factory(App\Models\Tag::class)->create();

        $response = $this->actingAs($factory_user);

        $tag_id = $factory_tag->id;

        $testTags = $factory_tag->name;
        $response->post('/tags', ['tags' => $testTags]);
        $response->assertDatabaseHas('tags', [
            'name' => $testTags
        ]);



        // #登録したタグ名が登録テーブルに登録されているかテスト
        // foreach($testTags as $testTag){
        //     $response->assertDatabaseHas('tags', [
        //         'name' => $testTag,
        //     ]);
        //     $tag_id = Tag::select('id')->where("name",$testTag)->first();
        //     $tag_ids[] = $tag_id->id;
        // }

        // // #登録したカテゴリーが中間テーブルに保存されているかテスト
        // // foreach($tag_ids as $tag_id){
        // //     $response->assertDatabaseHas('article_tag',['tag_id' => $tag_id]);
        // // }

        // // #不正な形式の記事が登録されないかテスト
        // // #タイトル0文字または３1文字以上の記事が投稿されないかテスト
        // // $lengths = [0,31];
        // // foreach($lengths as $length) {
        // //     $Bad_testTitle = substr(str_shuffle(str_repeat('0123456789abcdefghijklmnopqrstuvwxyz', $length)), 0, $length);

        // //     $response->post('/articles', ['title' => $Bad_testTitle, 'body' => $testBody]);
        // //     $response->assertDatabaseMissing('articles', [
        // //         'title' => $Bad_testTitle,
        // //         'body' => $testBody
        // //     ]);
        // // }
    }
}
