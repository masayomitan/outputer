<?php

namespace App\Http\Controllers;

use App\Book;
use App\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{
    public function index(User $user, Request $request){
      if(auth()->user()){
        //ログインしている場合、自分以外のユーザー情報を取得
        $all_users = $user->getAllUsers(auth()->user()->id);
        return view('users.index', [
            'all_users' => $all_users
        ]);
      } else {
        //ログインしていない場合、全てのユーザー情報を取得
        $all_users = $user->getAllUsers(auth()->user());
        return view('users.index', [
          'all_users' => $all_users
        ]);
      }
    }

    public function create(){

    }

    public function store(Request $request){

    }

    public function show(User $user, Book $book, Request $request){
        if(!isset($request['status'])){
            $request['status'] = 0;
        }

      #ログインユーザーじゃないユーザーが下書きページに遷移した際、リダイレクトして閲覧を防ぐ
        if($request['status'] == 1){
          $is_self_book = $user->isSelfBook($request, $user);
          if(!$is_self_book){
              return redirect($request->path());
          }
        }

        $timelines = $book->getUserTimeLine($user->id, $request['status']);
        $user_info_list= $user->getUserInfoList();
        $user_info_list["timelines"] = $timelines;
        $user_info_list["book_status_list"] = ['公開中','下書き'];
        $user_info_list["request_status_id"] = $request["status"];
        return view('users.show', $user_info_list);
    }

    public function edit(User $user){
        return view('users.edit', ['user'=>$user]);
    }

    public function update(Request $request, User $user){
        $user = auth()->user();
        $data = $request->all();
        $validator = Validator::make($data, [
        #0-9,英数字,記号の_のみだけ登録できるよう設定
        'screen_name' => ['required', 'regex:/^(\w)+$/', 'max:50', Rule::unique('users')->ignore($user->id)],
        'name' => ['required', 'string', 'max:255'],
        'profile_image' => ['file', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)]
        ]);
        $validator->validate();
        $user->updateProfile($data);
      return redirect('users/'.$user->id);
    }


    public function destroy($id){

    }



    public function follow(User $user){
        $follower = auth()->user();
        //フォローしているか
        $is_following = $follower->isFollowing($user->id);
        if($is_following){
          // フォローしていなければフォローする
          $follower->follow($user->id);
          return back();
        }
      }

    public function unfollow(User $user){
        $follower = auth()->user();
        // フォローしているか
        $is_following = $follower->isFollowing($user->id);
        if($is_following){
        // フォローしていればフォローを解除する
        $follower->unfollow($user->id);
        return back();
        }
      }

      public function following(User $user)
    {
      $following_users = $user->getFollowingUsers($user->id);
      $user_info_list = $user->getUserInfoList();
      $user_info_list["all_users"] = $following_users;
      return view('users.follow', $user_info_list);
    }

    public function followers(User $user)
    {
      $followers = $user->getFollowers($user->id);
      $user_info_list = $user->getUserInfoList();
      $user_info_list["all_users"] = $followers;
      return view('users.follow', $user_info_list);

    }

    public function favorite(User $user, Book $book)
    {
      $timelines = $book->getFavoriteBooks($user->id);
      $user_info_list = $user->getUserInfoList();
      $user_info_list["timelines"] = $timelines;
      return view('users.favorite', $user_info_list);
    }

}
