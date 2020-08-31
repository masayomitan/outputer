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

    }
}
