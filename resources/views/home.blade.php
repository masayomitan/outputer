@extends('layouts.app')

<!doctype html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>Header Sample</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="{{ asset('css/header.css') }}">
</head>
<body>
  <header>
    <h1 class="title">outputer</h1>
    <nav class="nav">
      <ul class="menu-group">
        <li class="menu-item"><a href="#">本一覧</a></li>
        <li class="menu-item"><a href="#">項目2</a></li>
        <li class="menu-item"><a href="#">項目3</a></li>
        <li class="menu-item"><a  href="{{ route('login') }}">ログイン</a></li>
        <li class="menu-item"><a href="{{ route('register') }}">新規登録</a></li>
      </ul>
    </nav>
  </header>
</body>
</html>
