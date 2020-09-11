@extends('layouts.app')
@include('layouts.header')


{{ Breadcrumbs::render('users.show', $user) }}


@include('components.users.user_profile')
@include('components.users.user_tab_list')


    <div class="follow-users">
    @if ($all_users->count())
        @foreach ($all_users as $user)
        <div class="follow-users-box">
            <div class="follow-user-icon">
                <div class="follow-user-pics">
                    <a href="{{ url('users/' .$user->id) }}">
                        @if (isset($user->profile_image))
                            <img class="follow-user-image" src="{{ $user->profile_image }}">
                        @else
                            <img class="follow-user-image" src="{{ asset('image/noname.jpg')}}"></a>
                        @endif
                    </a>
                </div>
                
                <div class="follow-user-confirm">
                    <div class="follow-user-confirm-edit">
                        @if (isset(auth()->user()->id))
                        @if (auth()->user()->id == $user->id)
                            <a href="{{ url('users/' .$user->id .'/edit') }}" class="user-confirm-edit-button">編集する</a>
                        @else
                    </div>

                    <div class="follow-user-confirm-result">
                        @if (auth()->user()->isFollowed($user->id))
                            フォローされています
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
                    <a href="{{ url('users/' .$user->id) }}">{{ $user->name }}</a>
                </div>
                <div class="follow-user-info-intr">
                    {{ $user->self_introduction }}
                </div>
            </div>
        </div>
        @endforeach
        @else
                <div class="timeline-null">繋がっているユーザーはいません。</div>
            @endif
    </div>


    {{ $all_users->links() }}
