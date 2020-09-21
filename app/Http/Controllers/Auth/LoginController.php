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
            $user = Socialite::with("twitter")->user();
        }
        catch (\Exception $e) {
            return redirect('/login')->with('oauth_error', 'ログインに失敗しました');
        }

        $file_name = $user->getAvatar('profile_image');
            $profile_image = Storage::disk('s3')->putFile('profile_image', $file_name, 'public');
            $image = Storage::disk('s3')->url($profile_image);

        $myinfo = User::firstOrCreate(['twitter_id' => $user->token ],
            [   'name' => $user->name,
                'email' => $user->getEmail(),
                'profile_image' => $image
            ]);
            Auth::login($myinfo);
            return redirect()->to('/books');
    }
}
