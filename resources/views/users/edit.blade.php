@extends('layouts.app')
@include('layouts.header')

{{ Breadcrumbs::render('users.edit', $user) }}


    <div class="user-edit">
        <div class="user-edit-header">
            プロフィールを編集
        </div>
        <div class="user-edit-box">
            <form method="POST" action="{{route('users.update' ,$user->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="user-profile-image">
                    <label for="profile_image" class="">プロフィール画像</label>
                    <input type="file" name="profile_image" accept="image/*" value="{{ $user->profile }}">
                </div>
                <div class="user-name">
                    <label for="name">ユーザー名</label>
                    <input  id="name" type="text" name="name" value="{{ $user->name }}" required autocomplete="name" autofocus>
                </div>
                <div class="user-email">
                    <label for="email">メールアドレス</label>
                    <input id="email" type="email" name="email" value="{{ $user->email }}">
                </div>
                <div class="user-self_introduction">
                    <div class="intro">
                        <label for="self_introduction">自己紹介</label>
                    </div>
                    <textarea name="self_introduction" class="self_introduction">{{ $user->self_introduction }}</textarea>
                </div>
                @if (isset(auth()->user()->id))
                @if (auth()->user()->id == 1)
                    <p>ゲストユーザーは編集できません</p>
                @else
                    <button type="submit" class="edit-button"><p>更新する</p></button>
                </form>
                    <form method="POST" action="{{route('users.destroy' ,$user->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit"  class="delete-button" onclick='return confirm("本当に削除しますか？泣");'>
                        ユーザー削除</button>
                    </form>
                @endif
                @endif



        </div>
    </div>


