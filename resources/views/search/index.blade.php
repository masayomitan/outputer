
@extends('layouts.app')
@include('layouts.top_header')

<h2 class="search-result">{{$keyword}}<span class="ml-2">で検索</span></h2>


<div class="search-index">

        <div class="search-book">
            <div class="search-book-ex">
                書籍名で検索結果
            </div>

            @if ($search_books_title->count())
            <div class="search-book-result">
                @foreach ($search_books_title as $book)
                    <div class="search-book-result-box">
                        <a href="{{ route('books.show',$book->id)}}">
                            <img class="search-book-result-image" src="{{ asset('storage/book_image/' .$book->book_image)}}">
                        </a>
                        <div class="search-book-result-title">
                            <a href="{{ route('books.show',$book->id)}}">
                            <p>{{$book->title}}</p></a>
                        </div>
                        <div class="search-book-result-author">
                            <p>{{$book->author}}</p>
                        </div>
                    </div>
                @endforeach
            </div>
            @else
                <div class="search-result-null">該当する書籍はありません</div>
            @endif
        </div>


        <div class="search-book">
            <div class="search-book-ex">
                著者名で検索結果
            </div>
            @if ($search_books_author->count())
            <div class="search-book-result">
                @foreach ($search_books_author as $book)
                    <div class="search-book-result-box">
                        <a href="{{ route('books.show',$book->id)}}">
                            <img class="search-book-result-image" src="{{ asset('storage/book_image/' .$book->book_image)}}"></a>
                        <div class="search-book-result-title">
                            <a href="{{ route('books.show',$book->id)}}">
                            <p>{{$book->title}}</p></a>
                        </div>
                        <div class="search-book-result-author">
                            <p>{{$book->author}}</p>
                        </div>
                    </div>
                @endforeach
            </div>
            @else
            <div class="search-result-null">該当する著者はありません</div>
            @endif
        </div>


        <div class="search-tags">
            <div class="search-book-ex">
                タグで検索結果
            </div>
            @if ($search_tags->count())
            <div class="search-tags-result">
                    @foreach ($search_tags as $tag)
                    <div class="search-tags-each" >
                        <a class="book-tags-result-each" href="{{ route('tags.show', ['tag'=>$tag->id]) }}">
                            <div class="book-tags-result-each-name">
                                #{{ $tag->name }}
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
            @else
            <div class="search-result-null">該当するタグはありません</div>
            @endif
        </div>

</div>
