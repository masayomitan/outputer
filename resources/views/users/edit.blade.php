@extends('layouts.app')
@include('layouts.header')

{{ Breadcrumbs::render('users.show', $user) }}


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
                    <input id="email" type="email" name="email" value="{{ $user->email }}" required autocomplete="email">
                </div>
                <div class="user-self_introduction">
                    <div class="intro">
                        <label for="self_introduction">自己紹介</label>
                    </div>
                    <textarea name="self_introduction" class="self_introduction">{{ $user->self_introduction }}</textarea>
                </div>
                <button type="submit" class="edit-button"><p>更新する</p></button>
            </form>
        </div>
    </div>
