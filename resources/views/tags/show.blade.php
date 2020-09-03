@extends('layouts.app')
@include('layouts.header')

{{-- foreach二回回し --}}
@foreach($bookTag as $tags)

    {{ Breadcrumbs::render('tags.show', $tags) }}
    <div class="tags">
        <div class="side-navi">
            @include('components.popular_tag_list')
            @include('components.popular_user_list')
        </div>

        <div class="tags-show">
            @foreach($tags->books as $tags)
            <div class="tags-show-each">
                <div class="tags-show-image">
                    <a href="{{ route('books.show',$tags->id)}}">
                    <img  class="tags-image" src="{{ $tags->book_image}}">
                </div>
                <div class="tags-title">
                    {!! nl2br(e(Str::limit($tags->title, 25))) !!}</p>
                </div></a>
                <div class="tags-author">
                    {!! nl2br(e(Str::limit($tags->author, 18))) !!}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endforeach
