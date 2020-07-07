<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

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

    
  }
