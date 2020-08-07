@include('layouts.header')
{{-- <img  src="{{ asset('storage/book_image/' . $book->book_image) }}" alt="{{ $book->book_image }}" width="100px" class="w-100"> --}}

<link rel="stylesheet" href="{{ asset('css/users/show.css') }}">




<div class="users">
    <div class="users-box">
        <div class="user-icon">
            <img class="user-image" src="{{ asset('storage/profile_image/' .$user->profile_image) }}" class="user-image" width="100" height="100">

            <div class="user-confirm">
                <div class="user-confirm-edit">
                    @if (isset(auth()->user()->id))
                    @if (auth()->user()->id == $user->id)
                        <a href="{{ url('users/' .$user->id .'/edit') }}" class="user-confirm-edit-button">編集する</a>
                    @else
                </div>
                <div class="user-confirm-result">
                    @if (auth()->user()->isFollowed($user->id))
                    <div>フォローされています</div>
                    @endif
                </div>
                <div class="follow-box">
                    @if (auth()->user()->isFollowing($user->id))
                        <form action="{{ route('users.unfollow', $user->id) }}" method="POST">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                                <button type="submit" class="follow-delete">フォロー解除</button>
                        </form>
                        @else
                            <form action="{{ route('users.follow', $user->id) }}" method="POST">
                                {{ csrf_field() }}
                                <button type="submit" class="follow-store">フォローする</button>
                            </form>
                        @endif
                        @endif
                        @endif
                    </div>
                </div>
            </div>

            <div class="user-info">
                <div class="user-info-name">
                    {{ $user->name }}さんのページ
                </div>
                <div class="user-info-intr">
                    {{ $user->self_introduction }}
                <div>
            </div>
        </div>
    </div>
</div>




    <div class="tab-info-box">
        <div class="tab-info-box-list">
            @foreach($tab_info_list as $tab_text => $tab_info)
            <div class="$tab-info">
                    <a href="{{ $tab_info['link'] }}" class=" @if($tab_info['link'] == '/') active @endif">
                    <div class="tab-info-num">{{$tab_text}}</div>
                </a>
            </div>
            @endforeach
        </div>
                {{-- @include('components.users.timeline_sentence_list') --}}
    </div>



{{-- <div class="user-favorites-count">
    いいね合計{{ $total_favorited_count }}
</div> --}}
