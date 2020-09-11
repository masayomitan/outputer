
@extends('layouts.app')
@include('layouts.top_header')
{{ Breadcrumbs::render('books.index') }}



<div class="home-body">

    <div class="home-body-left">
        @include('components.popular_tag_list')
        @include('components.popular_user_list')
    </div>

    <div class="home-book-box">

        <div class="home-list-name">
            新着本
        </div>
        <div class="home-book-list">
            @foreach ($books["all"] as $book)
                <div class="book_box-list-each">
                    <img class="book_image-new" src="{{ asset('image/new.png')}}">
                    <div>
                        <a href="{{ route('books.show',$book->id)}}">
                            <img  class="book_image-index" src="{{ $book->book_image }}" alt="">
                        </a>
                    </div>
                    <div class="book-title">
                        <a href="{{ route('books.show',$book->id)}}">
                            {{$book->title}}
                        </a>
                    </div>
                    <div class="book-author">
                        {{$book->author}}
                    </div>
                </div>
            @endforeach
        </div>

        <div class="home-list-name">
            新しくまとめられた本
        </div>
        <div class="home-book-list">
            @foreach ($books["new"] as $book)
                <div class="book_box-list-each">
                    <a href="{{ route('books.show',$book->id)}}">
                        <img  class="book_image-index" src="{{ $book->book_image }}" alt="">
                    </a>
                    <div class="book-title">
                        <a href="{{ route('books.show',$book->id)}}">
                            {{$book->title}}
                        </a>
                    </div>
                    <div class="book-author">
                        {{$book->author}}
                    </div>
                </div>
            @endforeach
        </div>
        <div class="home-view-sentence">
            <a class="home-view-sentence" href="{{ route('books.put_new_sentence') }}">一覧を見る</a>
        </div>

        <div class="home-list-name">
            まとめが多い順
        </div>
        <div class="home-book-list">
            @foreach ($books["pop"] as $book)
                <div class="book_box-list-each">
                    <a href="{{ route('books.show',$book->id)}}">
                        <img  class="book_image-index" src="{{ $book->book_image }}" alt="">
                    </a>
                    <div class="book-title">
                        <a href="{{ route('books.show',$book->id)}}">
                            {{$book->title}}
                        </a>
                    </div>
                    <div class="book-author">
                        {{$book->author}}
                    </div>
                </div>
            @endforeach
        </div>
        <div class="home-view-sentence">
            <a class="home-view-sentence" href="{{ route('books.put_popular_sentence') }}">一覧を見る</a>
        </div>

    </div>
</div>

@include('layouts.footer')
