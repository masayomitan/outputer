@extends('layouts.app')
@include('layouts.header')

{{-- foreach二回回し --}}
@foreach($bookTag as $tags)

    {{ Breadcrumbs::render('tags.show', $tags) }}

<div class="tag-body">
    <div class="home-body-left">
        @include('components.popular_tag_list')
        @include('components.popular_user_list')
    </div>

    <div class="tag-book-box">
        
        <div class="tag-list-name">
            {{ $tags->name }}
        </div>

        <div class="tag-book-list">
            @foreach($tags->books as $tags)
            <div class="book_box-list-each">
                <a href="{{ route('books.show',$tags->id)}}">
                <img  class="tags-image" src="{{ $tags->book_image}}">
                <div class="tags-title">
                    {{$tags->title }}</p>
                </div></a>
                <div class="tags-author">
                    {{$tags->author }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
    @endforeach
