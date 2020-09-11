
@extends('layouts.app')
@include('layouts.header')


{{ Breadcrumbs::render('books.show', $book, $user) }}
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
                            <div class="book-tags">
                                <div class="book-tags-box">
                                    @foreach($book->tags as $tag)
                                    <a class="book-tags-each" href="{{ route('tags.show', ['tag'=>$tag->id]) }}">
                                        <div class="book-tag-show"> #{{ $tag->name }}</div>
                                    </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                            {{-- <a href="{{ route('tags.create',$book->id)}}">タグ追加</a> --}}
                        <div class="book-share"></div>
                        <div class="twitter-image"></div>
                    </div>
                </div>
            </div>

            <a  class="sentence-box-create" href="{{ route('sentences.create', ['id' => $book->id]) }}">3行投稿</a>

            <div class="book-show-below">
                <div class="sentence-box">

                    <div class="sentence-show-select">
                        <form method="PUT">
                            @csrf
                            <select  class="sentence-select" id="select" name="data_id" onchange="this.form.submit()">
                                @foreach ( $data_list as $id => $text)
                                    <option @if($request->data_id == $id) selected @endif value="{{ $id }}" >{{ $text }}</option>
                                @endforeach
                            </select>
                        </form>
                    </div>

                    @if ($sentences->count())
                        @foreach($sentences as $sentence)
                            @if ($sentence->status == 0)

                                @if(isset($user))
                                    @if (!in_array(Auth::user()->id, array_column($sentence->favorites->toArray(), 'user_id'), TRUE))

                                        <form action="{{ route('favorites', $sentence) }}" method="POST" class="book-show-favorites">
                                            @csrf
                                            <input type="hidden" name="sentence_id" value="{{ $sentence->id }}">
                                            <button type="submit" class="btn"><i class="far fa-heart"></i></button>
                                        </form>
                                        <div class="book-show-favorites-count">
                                            {{$sentence->favorites->count()}}
                                        </div>
                                    @else
                                        <form action="{{ route('unfavorites', $sentence) }}" method="POST" class="book-show-favorites">
                                            @csrf
                                            <input type="hidden" name="sentence_id" value="{{ $sentence->id }}">
                                            <button type="submit" class="btn"><i class="fas fa-heart"></i></button>
                                        </form>
                                        <div class="book-show-favorites-count">
                                            {{$sentence->favorites->count()}}
                                        </div>

                                    @endif
                                @endif


                                <div class="sentence-box-each">

                                    <div class="sentence-box-name">

                                        @if (isset($sentence->user->id))
                                            <a href="{{ route('users.show', $sentence->user->id)}}"></a>
                                            <div class="sentence-box-name-each">
                                                {{ $sentence->user->name}}さんのまとめ
                                            </div>
                                        @else
                                            <div class="sentence-box-name-each">
                                                退会済みユーザーです
                                            </div>
                                        @endif

                                        <div class="line"></div>
                                        <div class="sentence-box-text-each">
                                            <p>{{ $sentence->text_1 }}</p>
                                            <p>{{ $sentence->text_2 }}</p>
                                            <p>{{ $sentence->text_3 }}</p>
                                        </div>

                                    </div>
                                    <div class="sentence-box-user">

                                        @if (isset($sentence->user->profile_image))
                                            <img class="profile_image" src="{{ $sentence->user->profile_image }}">
                                            <p class="timeline-date">{{ $sentence->updated_at->format('Y-m-d') }}</p>
                                        @else
                                            <img class="profile_image" src="{{ asset('image/noname.jpg')}}">
                                            <p class="timeline-date">{{ $sentence->updated_at->format('Y-m-d') }}</p>
                                        @endif

                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @else
                    <div class="timeline-null">
                        まだ投稿がありません。
                    </div>
                    @endif
                </div>
            </div>
</body>

