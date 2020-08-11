@include('layouts.header')
{{-- <img  src="{{ asset('storage/book_image/' . $book->book_image) }}" alt="{{ $book->book_image }}" width="100px" class="w-100"> --}}

<link rel="stylesheet" href="{{ asset('css/users/show.css') }}">
<link rel="stylesheet" href="{{ asset('css/users/follow.css') }}">



@include('components.users.user_profile')
@include('components.users.user_tab_list')


<div class="follow-users">
    <div class="follow-users-box">
        <div class="follow-user-icon">
            @foreach ($all_users as $user)
                <a href="{{ url('users/' .$user->id) }}">
                  <img src="{{ asset('storage/profile_image/' .$user->profile_image) }}">
                </a>

                    <div class="follow-user-confirm">
                        <div class="follow-user-confirm-edit">
                            @if (isset(auth()->user()->id))
                            @if (auth()->user()->id == $user->id)
                                <a href="{{ url('users/' .$user->id .'/edit') }}" class="user-confirm-edit-button">編集する</a>
                            @else
                        </div>
                        <div class="follow-user-confirm-result">
                            @if (auth()->user()->isFollowed($user->id))
                            <div>フォローされています</div>
                            @endif
                        </div>
                        <div class="follow-follow-box">
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

                    <div class="follow-user-info">
                        <div class="follow-user-info-name">
                            <a href="{{ url('users/' .$user->id) }}">{{ $user->name }}</a></div>
                        </div>
                        <div class="follow-user-info-intr">
                            {{ $user->self_introduction }}
                        <div>
                    </div>
                </div>
            </div>
        </div>
            @endforeach
          {{ $all_users->links() }}
