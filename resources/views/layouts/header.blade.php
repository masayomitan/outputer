


<!doctype html>
<html lang="ja">

  <meta charset="UTF-8">
  <title>outputer</title>

  <link rel="stylesheet" href="{{ asset('css/header.css') }}">
  <link href="{{ asset('css/reset.css') }}" rel="stylesheet">
    <header class="main-header wrapper">
      <h1 class="main-header-title"><a href="{{ route('books.index') }}" class="title">Outputer</a></h1>
      <nav>
        <ul class="main-nav">
        <li><a href="{{ route('books.index') }}">本一覧</a></li>
        <li><a href="#">未アウトプット本</a></li>
        <p><a href="{{ route('books.create') }}">新規追加</a></p>
        <li><a href="#">人気</a></li>
        <li><a href="#">タグ</a></li>

            @guest
            <li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}">{{ __('ログイン') }}</a>
            </li>
            @if (Route::has('register'))
            <li class="nav-item">
                <a class="nav-link" href="{{ route('register') }}">{{ __('新規登録') }}</a>
            </li>
            @endif
        @else

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
                        {{ __('ログアウト') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
        @endguest
      </ul>
      </ul>
    </nav>
  </header>
