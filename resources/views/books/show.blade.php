

@include('layouts.header')

<link rel="stylesheet" href="{{ asset('css/books/show.css') }}">

<body>
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

                            <a href="{{ route('books.show',$book->id)}}">タグ追加</a>

                        <div class="book-share"></div>
                        <div class="twitter-image"></div>
                    </div>
                </div>
            </div>



            <div class="book-show-below">
                <a  class="sentence-box-create" href="{{ route('sentences.create', ['id' => $book->id]) }}">まとめの投稿</a>
                    <div class="sentence-box">
                        @foreach($sentences as $sentence)
                            <div class="sentence-box-each">
                                <a href="{{ route('users.show',$sentence->user->id)}}"></a>
                                <div class="sentence-box-name">
                                    <div class="sentence-box-name-each"> {{ $sentence->user->name}}さんのまとめ</div>
                                        <div class="line"></div>
                                    <div class="sentence-box-text-each">
                                        <p>{{ $sentence->text_1 }}</p>
                                        <p>{{ $sentence->text_2 }}</p>
                                        <p>{{ $sentence->text_3 }}</p>
                                    </div>
                                </div>

                                <div class="sentence-box-user">
                                    <img class="profile_image" src="{{ asset('storage/profile_image/' .$sentence->user->profile_image)}}">
                                </div>
                            </div>
                        @endforeach
                    </div>
            </div>
</body>
