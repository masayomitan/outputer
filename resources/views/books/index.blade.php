@extends('layouts.app')


<div id="menu-box" class="big-bg">

    <div class="header-null"></div>
    <div class="header">
        @include('layouts.top_header')
    </div>
    {{ Breadcrumbs::render('books.index') }}

</div>

<div class="body-content">

    <div class="body-content-popular">
        @include('components.popular_tag_list')
        @include('components.popular_user_list')
    </div>


    <div class="wrapper-item">
        <div class="wrapper-item-box">
            @foreach ($books as $book)
                <div class="book_box">
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
                    <div class="most-favorite"></div>
                </div>
            @endforeach
        </div>
    </div>

</div>


