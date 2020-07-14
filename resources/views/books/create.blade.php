{{-- @extends('layouts.app')
@section('content')
<form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data">
@csrf
<input type="text" name="title" placeholder="タイトル" class="form-control form-control-lg">
<textarea  rows="8" cols="40" type="textarea" name="over_view" placeholder="概要" class="form-control form-control-lg"></textarea>
<input type="file" id="book_image" name="book_image" >
<div class="form-group">
    <label for="tags">
        タグ
    </label>
    <input
        id="tags"
        name="name"
        class="form-control {{ $errors->has('tags') ? 'is-invalid' : '' }}"
        value="{{ old('tags') }}"
        type="text">
<input type="submit"  value="Submit"></button>
</form>
@endsection --}}

@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="border p-4">
            <h1 class="h5 mb-4">
                投稿の新規作成
            </h1>

            <form method="POST" action="{{ route('books.store') }}"  enctype="multipart/form-data">
                @csrf

                <fieldset class="mb-4">
                    <div class="form-group">
                        <label for="title">
                            タイトル
                        </label>
                        <input
                            id="title"
                            name="title"
                            class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}"
                            value="{{ old('title') }}"
                            type="text"
                        >
                        @if ($errors->has('title'))
                            <div class="invalid-feedback">
                                {{ $errors->first('title') }}
                            </div>
                        @endif
                    </div>
                    <input type="file" id="book_image" name="book_image" >

                    <div class="form-group">
                        <label for="tags">
                            タグ
                        </label>
                        <input
                            id="tags"
                            name="tags[]"
                            class="form-control {{ $errors->has('tags') ? 'is-invalid' : '' }}"
                            value="{{ old('tags') }}"
                            type="text"
                        >
                        @if ($errors->has('tags'))
                            <div class="invalid-feedback">
                                {{ $errors->first('tags') }}
                            </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="over_view">
                            本文
                        </label>

                        <textarea
                            id="over_view"
                            name="over_view"
                            class="form-control {{ $errors->has('over_view') ? 'is-invalid' : '' }}"
                            rows="4"
                        >{{ old('over_view') }}</textarea>
                        @if ($errors->has('over_view'))
                            <div class="invalid-feedback">
                                {{ $errors->first('over_view') }}
                            </div>
                        @endif
                    </div>

                            キャンセル
                        </a>
                        <button type="submit" class="btn btn-primary" >
                            投稿する
                        </button>
                    </div>

                </fieldset>
            </form>
        </div>
    </div>
@endsection
