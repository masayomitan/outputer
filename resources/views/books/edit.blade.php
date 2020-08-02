

@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="border p-4">
            <h1 class="h5 mb-4">
                投稿の新規作成
            </h1>
            <form action="{{ route('books.update',$books->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <p>タイトル：<input type="text" name="title" value="{{ $books->title }}"></p>
                <p>概要：<input type="text" name="over_view" value="{{ $books->over_view }}"></p>
                <p>画像：<input type="file" name="book_image" value="{{ $books->book_image }}"></p>

                @foreach($tags as $tag)
                  <div class="d-none parameter_tags">{{$tag->name}}</div>
                @endforeach

                @if (isset($tag))
                <p>タグ：<input type="text" name="tags[]" value="{{ $tag->name }}"></p>
                @else
                <p>タグ：<input type="text" name="tags[]"></p>
                @endif

                <input type="submit" value="編集する">
            </form>


