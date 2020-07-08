<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = "/books";

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        //https://qiita.com/macky4/items/cc6591178e732d3f7b7a,正規表現忘れたらこれ
        return Validator::make($data, [
            'account_name' => ['required', 'regex:/^(\w)+$/', 'max:50', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function create(array $data)
    {

        #base64でエンコードされた画像データを画像ファイルとして保存する
        $img = $data["binary_image"];
        if(!isset($img)) {
            $image_path = "/images/profile_image/etc.png";
        } else {
            $fileData = base64_decode($img);
            $fileName = '/tmp/profile_image.png';
            file_put_contents($fileName, $fileData);

            $image = Storage::disk('s3')->putFile('/profile_images', $fileName, 'public');
            $image_path = Storage::disk('s3')->url($image);
        }


        return User::create([
            'account_name' => $data['account_name'],
            'name' => "",
            'email' => $data['email'],
            'profile_image' => $image_path,
            'password' => Hash::make($data['password']),
        ]);
    }
}
