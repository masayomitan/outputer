<!doctype html>
<html lang="ja">

  <meta charset="UTF-8">
  <title>outputer</title>


  <header class="main-header wrapper">
    <h1 class="main-header-title"><a href="{{ route('books.index') }}" class="title">Outputer</a></h1>
    <nav>
      <ul class="main-nav">
        <li><a href="{{ route('books.index') }}">本一覧</a></li>
        <li><a href="#">未アウトプット本</a></li>
        <li><a href="#">本を登録</a></li>
        <li><a  href="#">人気</a></li>
        <li><a href="#">タグ</a></li>
        <li><a href="{{ route('logout') }}"onclick="event.preventDefault();
            document.getElementById('logout-form').submit();">ログアウト</a></li>
      </ul>
    </nav>
  </header>
