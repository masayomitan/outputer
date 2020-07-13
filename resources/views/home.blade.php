@extends('layouts.app')

<!doctype html>
<html lang="ja">

  <meta charset="UTF-8">
  <title>outputer</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    <header class="main-header wrapper">
      <h1 class="main-header-title"><a href="{{ route('books.index') }}" class="title">Outputer</a></h1>
      <nav>
        <ul class="main-nav">
        <li><a href="{{ route('books.index') }}">本一覧</a></li>
        <li><a href="#">未アウトプット本</a></li>
        <li><a href="#">本を登録</a></li>
        <li><a href="#">人気</a></li>
        <li><a href="#">タグ</a></li>
        <li><a href="{{ route('login') }}">ログイン</a></li>
        <li><a href="{{ route('register') }}">新規登録</a></li>
      </ul>
    </nav>
  </header>

  <form action="{{ url('upload') }}" method="POST" enctype="multipart/form-data">

    <!-- アップロードした画像。なければ表示しない -->
    @isset ($filename)
    <div>
        <img src="{{ asset('storage/' . $filename) }}">
    </div>
    @endisset

    <label for="photo">画像ファイル:</label>
    <input type="file" class="form-control" name="file">
    <br>
    <hr>
    {{ csrf_field() }}
    <button class="btn btn-success"> Upload </button>
</form>
