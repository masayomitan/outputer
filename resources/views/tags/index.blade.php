

@extends('layouts.app')
@include('layouts.header')

{{ Breadcrumbs::render('tags.index', $tags) }}

<div class="search-tags">
    <div class="search-book-ex">
        タグ一覧
    </div>
    @if ($tags->count())
    <div class="search-tags-result">
            @foreach ($tags as $tag)
            <div class="search-tags-each" >
                <a class="book-tags-result-each" href="{{ route('tags.show', ['tag'=>$tag->id]) }}">
                    <div class="book-tags-result-each-name">
                        #{{ $tag->name }}
                    </div>
                </a>
            </div>
        @endforeach
    </div>
    @endif
</div>
