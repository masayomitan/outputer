


<!doctype html>
<html lang="ja">

<meta charset="UTF-8">
<title>outputer</title>

<link rel="stylesheet" href="{{ asset('css/header.css') }}">
<link href="{{ asset('css/reset.css') }}" rel="stylesheet">
<head>

    <header class="main-header-wrapper">
        <div class="main-header-title">
            <a href="{{ route('books.index') }}"></a>

                <form action="{{ url('/search') }}" class="search">
                    <span class="search-box"><input type="text" name="keyword" value="{{$keyword}}" placeholder="キーワード検索"></span>
                </form>
        </div>

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
