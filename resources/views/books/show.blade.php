
 <link rel="stylesheet" href="{{ asset('css/books/show.css') }}">

 @include('layouts.header')


<div class="book-show">

    <div class="book-show-header">
        <div class="book-title-show">{{$book->title }}</div>
    </div>

        <div class="book-show-above">
            <div class="book-image-show">
                <img class="book-image-show-box" src="{{ URL::to('storage/book_image/') }}/{{ $book->book_image }}">
            </div>

                <div class="book-info">

                    <div class="book-author-box">
                        <a class="book-author-show"> {{ $book->author }} </a>
                    </div>

                    <div class="bouder-line"></div>

                    <div class="book-tags">
                        <div class="book-tags-box">
                            @foreach($book->tags as $tag)
                                <div class="book-tag-show"> #{{ $tag->name }}</div>
                            @endforeach
                        </div>
                    </div>

                    <th><a href="{{ route('books.show',$book->id)}}">タグ追加</a></th>

                    <div class="book-share"></div>
                    <div class="twitter-image"><div>
                <div>
        </div>

        <div class="book-show-below">
            <div class="">
<a href="{{ route('sentences.create', ['id' => $book->id]) }}">3行でまとめる！</a>
</div>




<div class="col-xs-8 col-xs-offset-2">

    @foreach($sentences as $sentence)
    <tr>
        <td>{{ $sentence->text_1 }}</td>
    </tr>
    <form method="POST" action="{{ route('favorites.store') }}">
        @csrf

        <input type="hidden" name="sentence_id" value="{{ $sentence->id }}">
        <button>
    </form>

    @endforeach

