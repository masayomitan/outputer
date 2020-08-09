

<link rel="stylesheet" href="{{ asset('css/users/timeline_sentence.css') }}">

<div class="select-box">
    @if (isset(auth()->user()->id))
        @if ((auth()->user()->id) == $user->id)
            <select class="select" name="select" onChange="location.href=value;">
                @foreach ($sentence_status_list as $status_id => $status_text)
                    <option @if($request_status_id == $status_id) selected @endif value="{{ url()->current() }}?status={{ $status_id }}">
                        {{ $status_text }}
                    </option>
                @endforeach
            </select>
        @endif
    @endif
</div>


<div class="timeline">

    @if ($timelines->count())
    @foreach ($timelines as $timeline)
    <div class="timeline-box">
        <div class="timeline-book-box">
            <a href="{{ route('books.show', ['book'=>$timeline->book_id])}}">
            <img class="timeline-book-image" src="{{ asset('storage/book_image/' . $timeline->book_image) }}"></a>
            <p class="timeline-book-title">{!! nl2br(e(Str::limit($timeline->title, 18))) !!}</p>
            <p class="timeline-book-author">{!! nl2br(e(Str::limit($timeline->author, 18))) !!}</p>
        </div>

        <div class="timeline-sentence-box">
            <p class="timeline-book-text">{{$timeline->text_1}}</p>
            <p class="timeline-book-text">{{$timeline->text_2}}</p>
            <p class="timeline-book-text">{{$timeline->text_3}}</p>

            <div class="timeline-favorite">
            <div class="timeline-favorite-icon"></div>
            <div class="timeline-favorite-count">{{ count($timeline->favorites) }}</div>
        </div>


            <span class="timeline-date">{{ $timeline->created_at->format('Y-m-d H:i') }}</span>
                <div class="timeline-dlete">
                    @if (isset(auth()->user()->id))
                        @if (auth()->user()->id == $user->id)
                            <form method="POST" action="{{ url('sentences/' .$timeline->id) }}" class="mb-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="dropdown-item del-btn">削除</button>
                            </form>
                        @endif
                    @endif
                </div>
        </div>
    </div>
    @endforeach

        @else
            <div class="timeline-null">対象の記事がありません。</div>
        @endif
        {{ $timelines->links() }}
</div>


{{-- <img src="{{ asset('storage/profile_image/' .$timeline->user->profile_image)}}"> --}}
