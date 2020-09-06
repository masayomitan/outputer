@extends('layouts.app')


<div class="home">
    <div class="home-image">
        <img class="home-image-log" src="{{ asset('image/outputer.log2.png')}}">
    </div>
    <div class="home-text">
        頭を少しひねって本を３行でアウトプット
    </div>

        <div class="home-login" >
            @if (!isset(auth()->user()->id))
                <a class="nav-login" href="{{ route('login') }}">{{ __('ログイン画面へ') }}</a>
            @endif
            <a class="nav-index" href="{{ route('books.index')}}">本一覧ページへ</a>
        </div>

        <div class="home-text-2">
            What's about it?
        </div>

    <div class="home-text-box">
        <div class="home-text-2">
            要点短く人に伝えれてますか？
        </div>

        <div class="home-text-3">
            端的に話す、結論から話す。
            練習すれば誰でも出来る！ ここはそんな少し頭をひねれるサービスです。
        </div>
        <div class="home-text-3">
            ルールは簡単!!
            読書済みの本を3行でわかりやすく伝えるだけ
        </div>
        <div class="home-text-3">
            (1行は基本３５〜５０文字が読みやすいと言われています。
            ここでは最小の３５文字までにしました。)
        </div>
        <div class="home-text-3">
            短くまとめて人に伝える為にここでアウトプットの練習をしよう！
        </div>
    </div>
</div>

<div class="home-under">
    <div class="home-usage">
        使い方も簡単♪
    </div>

    <div class="home-usage-1">
        <img class="home-image-log-usage" src="{{ asset('image/book_create.png')}}">
        <div class="home-usage-2">
            <p>読書済みの本を簡単に登録するだけ。  題名、著者、写真のみでok</p>
        </div>
    </div>

    <div class="home-usage-1">
        <img class="home-image-log-usage" src="{{ asset('image/sentence_create.png')}}">
        <div class="home-usage-2">
            <p>後は頑張って悩んで要点短く3行でまとめるのみ！</p>
            <p>参考になるユーザーの投稿も見てどんどん練習していこう！</p>
        </div>
    </div>

    <div class="home-login" >
        @if (!isset(auth()->user()->id))
            <a class="nav-login" href="{{ route('login') }}">{{ __('ログイン画面へ') }}</a>
        @endif
        <a class="nav-index" href="{{ route('books.index')}}">本一覧ページへ</a>
    </div>
</div>

@include('layouts.footer')
