@extends('layouts.app')

@include('layouts.header')


    <div class="user-register">
        <div class="user-register-header">
            新規登録
        </div>
        <div class="user-register-box">
            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                @csrf
                @method('POST')
                <div class="user-name">
                    <label for="name">ユーザー名</label>
                    <input  id="name" type="text" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                </div>
                <div class="user-email">
                    <label for="email">メールアドレス</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email">
                </div>
                <div class="user-password">
                    <label for="password">パスワード</label>
                    <input id="password" type="password" class="password @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                    <p><label for="password-confirm">パスワード確認</label>
                    <input id="password-confirm" type="password" name="password_confirmation" required autocomplete="new-password"></p>
                </div>
                <button type="submit" class="register-button"><p>アカウントを作成する</p></button>
                @if (Route::has('password.request'))
                    <a class="btn btn-link" href="{{ route('login') }}">
                        アカウントをお持ちの方
                    </a>
                @endif
            </form>
        </div>
    </div>
