
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

{{-- <div>
    @if ($timelines->count())
    @foreach ($books as $book)
    @php var_dump($book); @endphp
            {{-- {{$book["title"]}} --}}
    {{-- <img src="{{ asset('storage/book_image/' . $book->book_image) }}"> --}}
    {{-- @endforeach
    @endif
</div>  --}}

<div class="timeline">
          <div class="">
            @if ($timelines->count())
              @foreach ($timelines as $timeline)
              {{-- @php var_dump($timelines); @endphp --}}
                <div class="">
                  <div class="">
                    {{-- <a href="{{ route('sentences.show', ['sentence'=>$timeline->id]) }}"> --}}
                      <div class="">
                        {{ $timeline->book_id }}
                        {{-- {{ URL::to('storage/book_image/') }}/{{ $timeline->user->profile_image }} --}}
                        {{-- <img src="{{ asset('storage/book_image/' . $timeline->book->book_image) }}"> --}}
                        {{-- <img src="{{ asset('storage/book_image/' . $timeline->book_image) }}"> --}}
                        {{-- <img src="{{ asset('storage/profile_image/' .$timeline->user->profile_image)}}"> --}}

                      </div>
                    </a>
                    <div class="">
                      <div class="">
                        <div class="">
                          {{-- <a href="{{ url('users/' .$timeline->user->id) }}" class="">
                            <img src="{{ asset('storage/profile_image/') }}" class=""> --}}
                          </a>
                          <a href="{{ route('sentences.show', ['sentence'=>$timeline->id]) }}">
                            <p class="">{{ $timeline->title }}</p>
                          </a>
                        </div>
                        <p class="">
                          @foreach((array)$timeline->tags as $tag)
                            <a class="" href="/tags/{{ $tag->id }}">
                              <span class="">{{$tag->name}}</span>
                            </a>
                          @endforeach
                        </p>
                        <div class="">
                          <div class="">
                            <span>by &#064;{{$timeline->user->screen_name}}</span>
                            <span>{{ $timeline->created_at->format('Y-m-d H:i') }}</span>
                            <span><i class=""></i>{{ count($timeline->favorites) }}</span>
                          </div>
                          @if (isset(auth()->user()->id))
                            @if (auth()->user()->id == $user->id)

                                <div class="">
                                  <form method="POST" book="{{ url('books/' .$timeline->id) }}" class="mb-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="dropdown-item del-btn">削除</button>
                                  </form>
                                </div>
                              </div>
                            @endif
                          @endif
                            @endforeach
              @else
                <div class="mx-auto p-5">対象の記事がありません。</div>
              @endif
            </div>
          <div class="my-4 d-flex justify-content-center">
            {{ $timelines->links() }}
          </div>
</div>
