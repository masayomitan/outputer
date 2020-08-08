@include('layouts.header')
{{-- <img  src="{{ asset('storage/book_image/' . $book->book_image) }}" alt="{{ $book->book_image }}" width="100px" class="w-100"> --}}

<link rel="stylesheet" href="{{ asset('css/users/show.css') }}">

@include('components.users.user_profile')
@include('components.users.user_tab_list')


{{-- @include('components.users.timeline_sentence_list') --}}


{{-- <div class="user-favorites-count">
    いいね合計{{ $total_favorited_count }}
</div> --}}
