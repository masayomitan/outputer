<?php

use App\Models\Favorite;
use App\Models\User;
use App\Models\Sentence;
use Tests\TestCase;


use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserTest extends TestCase
{
    use DatabaseMigrations;
    

    public function testCreateUser()
    {
        $response = $this->get('/');
        $response->assertStatus(302);
    }

    public function testRegisterUserProfile()
    {
        $testPassword = "1234";
        ## アップロードしたプロフィールデータがDBにあるかテスト
        $factory_userA = factory(App\Models\User::class)->create();
        $testUserNameA = $factory_userA->name;
        $testEmailA = $factory_userA->email;

        $this->post('/register', ['name' => $testUserNameA, 'email' => $testEmailA, 'password' => $testPassword, 'password_confirmation' => $testPassword]);
        $this->assertDatabaseHas('users', [
            'name' => $testUserNameA,
            'email' => $testEmailA
        ]);

        $factory_userC = factory(App\Models\User::class)->create();
        $testUserNameC = $factory_userC->name;

        $Bad_testEmail = "testUserばっとてすと@";
        #不正な形式のメールアドレスが登録されないかテスト
        $this->post('/register', ['name' => $testUserNameC, 'email' => $Bad_testEmail, 'password' => $testPassword, 'password_confirmation' => $testPassword]);
        $this->assertDatabaseMissing('users', [
            'name' => $testUserNameC,
            'email' => $Bad_testEmail
        ]);
    }

    public function testUpdateUserProfile()
    {
        #アップロードしたプロフィールデータがDBにあるかテスト
        $factory_user = factory(App\Models\User::class)->create();
        $response = $this->actingAs($factory_user);
        $user_id = $factory_user->id;

        #アップデート用のプロフィールデータを生成する
        $factory_user_update = factory(App\Models\User::class)->make();
        $testUserName = $factory_user_update->name;
        $testEmail = $factory_user_update->email;
        $testSelfIntroduction = $factory_user_update->self_introduction;

        $response->put('/users/'.$user_id, ['name' => $testUserName, 'email' => $testEmail, 'self_introduction' => $testSelfIntroduction]);
        $response->assertDatabaseHas('users', [
            'id' => $user_id,
            'name' => $testUserName,
            'email' => $testEmail,
            'self_introduction' => $testSelfIntroduction
        ]);

        #不正な形式のプロフィールが登録されないかテスト
        $Bad_testEmail = "testUserEmailてすと@testUserEmailてすと@";
        $response->put('/users/'.$user_id, ['name' => $testUserName, 'email' => $Bad_testEmail, 'self_introduction' => $testSelfIntroduction]);
        $response->assertDatabaseMissing('users', [
            'id' => $user_id,
            'name' => $testUserName,
            'email' => $Bad_testEmail,
            'self_introduction' => $testSelfIntroduction,
        ]);
    }

    # 記事を第三者からチェック
    public function testCheckIsSentenceByOutsider()
    {
        $creater_user = factory(App\Models\User::class)->create();
        $outsider_user = factory(App\Models\User::class)->create();

        # 公開記事が確認できるか
        $public_sentence = factory(App\Models\Sentence::class)->create([
            "user_id" => $creater_user->id,
            'text_1' => "text_1",
            'text_2' => "text_2",
            'text_3' => "text_3",
            'status' => 0,
        ]);
        $response = $this->actingAs($outsider_user);
        $response = $this->get('users/'.$public_sentence->user_id);
        $response->assertSee($public_sentence->text_1);

         # 下書き記事が見れないようになっているか
        $dont_see_sentence = factory(App\Models\Sentence::class)->create([
            "user_id" => $creater_user->id,
            'text_1' => "text_1",
            'text_2' => "text_2",
            'text_3' => "text_3",
            'status' => 1,
        ]);
        $response = $this->actingAs($outsider_user);
        $response = $this->get('users/'.$dont_see_sentence->user_id."?status=1");
        $response->assertDontSee($dont_see_sentence->text_1);
    }

}
