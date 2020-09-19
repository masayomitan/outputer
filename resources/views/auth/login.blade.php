
@extends('layouts.app')

@include('layouts.header')


    <div class="user-register">
        <div class="user-register-header">
            ログイン
        </div>
        <div class="user-register-box">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                @method('POST')

                <div class="user-email">
                    <label for="email">メールアドレス</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                </div>
                <div class="user-password">
                    <label for="password">パスワード</label>
                    <input id="password" type="password" class="password @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                </div>
                <button type="submit" class="login-button"><p>ログインする</p></button>
            </form>
            <form method="POST" action="{{ route('login.test') }}">
                @csrf
                @method('GET')
                <div class="form-group">
                    <button type="submit" class="easy-login-button">簡単ログイン</button>
                </div>
            </form>
            <a class="btn btn-link" href="{{ route('register') }}">
                アカウント新規登録
            </a>
        </div>
    </div>

    <a href="/login/twitter">twitterでログイン</a>
