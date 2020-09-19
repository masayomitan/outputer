<?php

use App\Models\Sentence;
use App\Models\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class FavoriteTest extends TestCase
{
    use DatabaseMigrations;

        /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testPostFavorites()
    {
        #いいねできているかチェック
        $factory_user = factory(App\Models\User::class)->create();//データ作って
        $favorites = factory(App\Models\Favorite::class)->create();

        $user_id = $favorites->user_id;
        $sentence_id = $favorites->sentence_id;
        $response = $this->actingAs($factory_user);  //認証して

        $response->post('/favorites', ['user_id' => $user_id, 'sentence_id' => $sentence_id]); //第二引数にPOST値の配列を渡して
        $response->assertDatabaseHas('favorites', [  //データあるかテスト
            'user_id' => $user_id,
            'sentence_id' => $sentence_id
        ]);


        #いいねを外せているかチェック
        $favorite = factory(App\Models\Favorite::class)->create();
        $this->assertNotNull($favorite); // データが取得できたかテスト
        $favorite_id =$favorite->id;

        $response->delete('/favorites/'.$favorite_id);
        $response->assertDatabaseMissing('favorites', [
            'id' => $favorite_id,
            'user_id' => $user_id,
            'sentence_id' => $sentence_id
        ]);
    }

    public function testDisplayFavoriteSentenceInUsers()
    {
        $user_id = 1;
        $favorites = factory(App\Models\Favorite::class,5)->create([
            'user_id' => $user_id,
        ]);

        $favoriting_user = User::find($user_id);

        $response = $this->actingAs($favoriting_user);
        $response = $response->get('/users/'.$user_id.'/favorite');

        foreach($favorites as $favorite) {
            $favorite_sentence = Sentence::find($favorite->sentence_id);
            $response->assertSeeText($favorite_sentence->id);
        }
    }

    public function testNotDisplayFavoriteArticleInUsers()
    {
        $user_id = 1;
        $favorites = factory(App\Models\Favorite::class,5)->create([
            'user_id' => 2,
        ]);

        $favoriting_user = User::find($user_id);

        $response = $this->actingAs($favoriting_user);
        $response = $response->get('/users/'.$user_id.'/favorite');

        foreach($favorites as $favorite) {
            $favorite_sentence = Sentence::find($favorite->sentence_id);
            $response->assertDontSeeText($favorite_sentence->text_1);
        }
    }

}
