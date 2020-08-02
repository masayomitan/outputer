
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
                        <label for="author">
                            本文
                        </label>

                        <input
                            id="author"
                            name="author"
                            class="form-control {{ $errors->has('author') ? 'is-invalid' : '' }}"
                            value="{{ old('author') }}"
                            type="text"
                        >
                        @if ($errors->has('author'))
                            <div class="invalid-feedback">
                                {{ $errors->first('author') }}
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
