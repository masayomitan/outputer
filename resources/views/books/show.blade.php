
@extends('layouts.app')
@include('layouts.header')



<body>


    <div class="book-show">

        <div class="book-show-header">
            <div class="book-title-show">{{$book->title }}</div>
        </div>

            <div class="book-show-above">
                <div class="book-image-show">
                    <img class="book-image-show-box" src="{{ $book->book_image }}">
                </div>

                    <div class="book-info">

                        <div class="book-author-box">
                            <a class="book-author-show"> {{ $book->author }} </a>
                        </div>

                        <div class="book-tags">
                            <div class="book-tags-box">
                                @foreach($book->tags as $tag)
                                <a class="book-tags-each" href="{{ route('tags.show', ['tag'=>$tag->id]) }}">
                                    <div class="book-tag-show"> #{{ $tag->name }}</div>
                                </a>
                                @endforeach
                            </div>
                        </div>

                            {{-- <a href="{{ route('tags.create',$book->id)}}">タグ追加</a> --}}

                        <div class="book-share"></div>
                        <div class="twitter-image"></div>
                    </div>
                </div>
            </div>

            <a  class="sentence-box-create" href="{{ route('sentences.create', ['id' => $book->id]) }}">まとめの投稿</a>

            <div class="book-show-below">
                <div class="sentence-box">

                    <form method="PUT">
                        @csrf
                        <select  class="sentence-select" id="select" name="data_id" onchange="this.form.submit()">
                            @foreach ( $data_list as $id => $text)
                                <option @if($request->data_id == $id) selected @endif value="{{ $id }}" >{{ $text }}</option>
                            @endforeach
                        </select>
                    </form>

                    @foreach($sentences as $sentence)

                    @if(isset($user))
                        @if (!in_array(Auth::user()->id, array_column($sentence->favorites->toArray(), 'user_id'), TRUE))
                            <form action="{{ route('favorites', $sentence) }}" method="POST" class="favorite-like">
                                @csrf
                                <input type="hidden" name="sentence_id" value="{{ $sentence->id }}">
                                <input type="submit" value="&#xf164;" class="fas btn btn-like">
                            </form>
                            @else
                            <form action="{{ route('unfavorites', $sentence) }}" method="POST" class="favorite-unlike">
                                @csrf
                                <input type="hidden" name="sentence_id" value="{{ $sentence->id }}">
                                <input type="submit" value="&#xf164;取り消す" class="fas btn btn-unlike">
                            </form>
                        @endif
                    @endif

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
                            <img class="profile_image" src="{{ $sentence->user->profile_image)}}">
                            <p class="timeline-date">{{ $sentence->created_at->format('Y-m-d') }}</p>
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>
</body>

