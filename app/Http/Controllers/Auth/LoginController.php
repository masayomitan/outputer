<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Storage;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers {
        logout as performLogout;
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/books';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirectPath()
    {
        return '/books';
    }

    public function authenticate()   //ゲストログイン
    {
        $email = 'test@com';
        $password = '1234';

        if (Auth::attempt(['email' => $email, 'password' => $password])) {

            return redirect(route('books.index'));
        }
        return back();
    }

    protected function loggedOut(Request $request)
    {
        return redirect(route('books.index'));
    }

    /**
     * twitterの認証ページヘユーザーをリダイレクト
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('twitter')->redirect();
    }

    /**
     * twitterからユーザー情報を取得
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        try {
            $user = Socialite::driver('twitter')->user();
            } catch(\Exception $e) {
                return redirect('/login')->with('oauth_error', '予期せぬエラーが発生しました');
        }
        $user = User::where(['email' => $user->getEmail()])->first();

        if($user){
            //email登録がある場合の処理
            //twitter idが変更されている場合、DBアップデード
            if($user->twitter_id  !== $user->getNickname()){
                $user->twitter_id = $user->getNickname();
                $user->save();
            }

            Auth::login($user);
            return redirect('/books');
        }else{
            //メールアドレスがなければユーザ登録
            $newuser = new User;
            $newuser->name = $user->getName();
            $newuser->email = $user->getEmail();
            $newuser->twitter_id = $user->getNickname();

            // 画像の取得
            $img = file_get_contents($user->avatar_original);
            if ($img !== false) {
                $file_name = $user->getAvatar()->file('profile_image');
                $profile_image = Storage::disk('s3')->putFile('profile_image', $file_name, 'public');
                $newuser->avatar = Storage::disk('s3')->url($profile_image);
            }
            //ユーザ作成
            $newuser->save();
            //ログインしてトップページにリダイレクト
            Auth::login($newuser);
            return redirect('/books');
        }
    }
}
