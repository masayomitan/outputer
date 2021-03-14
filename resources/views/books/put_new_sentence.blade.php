@extends('layouts.app')
@include('layouts.header')

{{ Breadcrumbs::render('books.put_new_sentence') }}

<div class="home-body">

    <div class="home-body-left">
        @include('components.popular_tag_list')
        @include('components.popular_user_list')
    </div>
    <div class="home-book-box">
        <div class="home-list-name">
            新しくまとめられた本
        </div>
        <div class="home-book-list">
            @foreach ($books as $book)
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
                        {{$book->author}}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
