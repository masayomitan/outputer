


<link rel="stylesheet" href="{{ asset('css/popular.css') }}">
<link rel="stylesheet" href="{{ asset('css/books/index.css') }}">


<div id="menu-box" class="big-bg">

    <div class="header-null"></div>
    <div class="header">
        @include('layouts.top_header')
    </div>

    <div class="menu-content wrapper">
        {{-- <h2 class="page-title">Menu</h2>
        <p>
            テストテストテストテストテストテストテストテストテストテストテストテスト
        </p> --}}
    </div>

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
                    <img  class="book_image" src="{{ asset('storage/book_image/' . $book->book_image) }}" alt="">
                    </a>
                    <div class="book-title">
                        <a href="{{ route('books.show',$book->id)}}">
                        {!! nl2br(e(Str::limit($book->title, 25))) !!}</p></a>
                    </div>
                    <div class="book-author">
                        {!! nl2br(e(Str::limit($book->author, 18))) !!}</p>
                    </div>
                <div class="most-favorite"></div>
            </div>
            @endforeach
        </div>
    </div>

</div>


