<?php

use App\Models\Favorite;
use App\Models\User;

use Tests\TestCase;

use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *
     * @return void
     */
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
        $testName = $factory_user_update->name;
        $testEmail = $factory_user_update->email;
        $testSelfIntroduction = $factory_user_update->self_introduction;

        $response->put('/users/'.$user_id, ['name' => $testUserName, 'email' => $testEmail, 'self_introduction' => $testSelfIntroduction]);
        $response->assertDatabaseHas('users', [
            'id' => $user_id,
            'name' => $testUserName,
            'email' => $testEmail,
            'self_introduction' => $testSelfIntroduction
        ]);

        $Bad_testUserName = "testUserばっとてすと@";

        #不正な形式のプロフィールが登録されないかテスト
        $response->put('/users/'.$user_id, ['name' => $Bad_testUserName, 'email' => $testEmail, 'self_introduction' => $testSelfIntroduction]);
        $response->assertDatabaseMissing('users', [
            'id' => $user_id,
            'name' => $Bad_testUserName,
            'email' => $testEmail,
            'self_introduction' => $testSelfIntroduction
        ]);
    }
}
