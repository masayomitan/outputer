


<!doctype html>
<html lang="ja">

<meta charset="UTF-8">
<title>outputer</title>

<link rel="stylesheet" href="{{ asset('css/header.css') }}">
<link href="{{ asset('css/reset.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/all.css" integrity="sha384-HzLeBuhoNPvSl5KYnjx0BT+WB0QEEqLprO+NBkkk5gbc67FTaL7XIGa2w1L0Xbgc" crossorigin="anonymous">
<head>

    <header class="main-header-wrapper">

            <a class="main-header-title" href="{{ route('books.index') }}"></a>
                <form action="{{ url('/search') }}" class="search">
                    <a class="search-box"><input class="search-input" type="text" name="keyword" value="{{$keyword}}" placeholder="キーワード検索">
                    <button  class="search-icon"></button></a>
                </form>


        <div class="user-box">
            @if (isset(auth()->user()->id))
                <a href="{{ route('users.show',auth()->user()->id)}}"src="{{ asset('storage/profile_image/' .auth()->user()->profile_image)}}">
                <img class="user-header-image" src="{{ asset('storage/profile_image/' .auth()->user()->profile_image)}}"></a>
            @endif

        <ul id="menu">
            <li><a href="#">Menu</a>
                <ul>
                    @if (isset(auth()->user()->id))
                    <li><a href="{{ route('users.show',auth()->user()->id)}}">mypage</a></li>@endif
                    <li><a href="{{ route('books.create') }}">本の新規追加</a></li>
                    @guest
                    <li>
                        <a class="nav-link" href="{{ route('login') }}">{{ __('ログイン') }}</a></li>
                        @if (Route::has('register'))
                    <li>
                        <a class="nav-link" href="{{ route('register') }}">{{ __('新規登録') }}</a></li>@endif
                        @else
                    <li><a  href="{{ route('logout') }}"
                            onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                            {{ __('ログアウト') }}</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form></li>
                    @endguest
                </ul>
            </li>
        </ul>
    </div>
    </header>
</head>
