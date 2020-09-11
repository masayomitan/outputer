@extends('layouts.app')
@include('layouts.header')


{{ Breadcrumbs::render('users.show', $user) }}

        @include('components.users.user_profile')
        @include('components.users.user_tab_list')

        <div class="timeline">
        @if ($timelines->count())
            @foreach ($timelines as $timeline)
            <div class="timeline-box">

                <div class="timeline-book-box">
                    <a href="{{ route('books.show', ['book'=>$timeline->book_id])}}">
                    <img class="timeline-book-image" src="{{ $timeline->book_image }}"></a>
                    <p class="timeline-book-title">{!! nl2br(e(Str::limit($timeline->title, 18))) !!}</p>
                    <p class="timeline-book-author">{!! nl2br(e(Str::limit($timeline->author, 18))) !!}</p>
                </div>

                <div class="timeline-sentence-box">
                    <p class="timeline-book-text">{{$timeline->text_1}}</p>
                    <p class="timeline-book-text">{{$timeline->text_2}}</p>
                    <p class="timeline-book-text">{{$timeline->text_3}}</p>
                    <div class="timeline-favorite">
                        <img class="timeline-favorite-icon" src="{{ asset('image/heart.png')}}">
                        <div class="timeline-favorite-count">
                            {{ count($timeline->favorites) }}
                        </div>
                    </div>
                </div>

                <div class="timeline-user-box">

                    @if (isset($timeline->user->id))
                    <a href="{{ route('users.show', $timeline->user->id)}}">
                        <img class="timeline-user-image" src="{{ $timeline->user->profile_image }}">
                        <p class="timeline-user-name">{!! nl2br(e(Str::limit($timeline->user->name, 16))) !!}</p>
                    </a>
                        <p class="timeline-date">{{ $timeline->created_at->format('Y-m-d H:i') }}</p>
                    @else
                        <img class="timeline-user-image" src="{{ asset('image/noname.jpg') }}">
                        <p class="timeline-user-name">退会済みユーザーです</p>
                        <p class="timeline-date">{{ $timeline->created_at->format('Y-m-d H:i') }}</p>
                    @endif

                    @if (isset(auth()->user()->id))
                    @if (auth()->user()->id == (isset($timeline->user->id)))
                    <div class="timeline-delete">
                        <form method="post" action="{{ url('sentences/' .$timeline->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick='return confirm("本当に削除する？");'>
                                3行削除</button>
                        </form>
                    </div>
                    @endif
                    @endif

                </div>
            </div>
            @endforeach
            @else
                <div class="user-show-select-box">まだ投稿がありません</div>
            @endif
            {{ $timelines->links() }}
        </div>

