
<div class="card">
    <div class="card-header-user-mark">
        <div class="user-mark">いいねののユーザー</div>
    </div>
    <div class="card-body">
    @foreach ($popular_users as $user)
        <a href="{{ route('users.show', ['user'=>$user->id]) }}">
            <p>{{$user->name}}({{$user->favorites_count}})</p>
        </a>
    @endforeach
    </div>
</div>
