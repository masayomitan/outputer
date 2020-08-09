@include('layouts.header')


<link rel="stylesheet" href="{{ asset('css/users/show.css') }}">
<link rel="stylesheet" href="{{ asset('css/users/timeline_sentence.css') }}">

@include('components.users.user_profile')
@include('components.users.user_tab_list')
@include('components.users.timeline_sentence_list')


