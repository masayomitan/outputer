
 <link rel="stylesheet" href="{{ asset('css/popular.css') }}">
 <link rel="stylesheet" href="{{ asset('css/books/index.css') }}">




<div id="menu" class="big-bg">
  <div class="menu-content wrapper">
    @include('layouts.header')
    <h2 class="page-title">Menu</h2>
    <p>
        テストテストテストテストテストテストテストテストテストテストテストテスト
    </p>
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
                    <img  class="book_image" src="{{ asset('storage/book_image/' . $book->book_image) }}" alt="">
                    <div class="book-title">
                        {{ $book->title }}
                    </div>
                    <div class="book-author">
                        {{ $book->author }}
                    </div>
                    <a href="{{ route('books.show',$book->id)}}">詳細</a>
                <div class="most-favorite"></div>
            </div>
            @endforeach
        </div>
    </div>

</div>
{{-- </body> --}}



        {{-- @foreach ($books as $book)
            <tr>
            <th><img  src="{{ asset('storage/book_image/' . $book->book_image) }}" alt="{{ $book->book_image }}" width="100px" class="w-100"></th>
            <th>{{ $book->title }}</th>
            <th>{{ $book->author }}</th>
            <th><a href="{{ route('books.show',$book->id)}}">詳細</a></th>
            <th><a href="{{ route('books.edit',$book->id)}}">編集</a></th>
            <th>
                <form action="{{ route('books.destroy', $book->id)}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <input type="submit" name="" value="削除">
                </form>
            </th>
        </tr>
        @endforeach
 --}}


