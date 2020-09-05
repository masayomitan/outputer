@extends('layouts.app')
@include('layouts.header')

{{ Breadcrumbs::render('sentences.create', $book) }}

<div class="book-sentence-show">

    <div class="book-sentence-box">
        <div class="book-sentence-new">
            <h1>まとめの投稿</h1>
        </div>
        <div class="book-info">
            <img class="book-info-image" src="{{ $book->book_image }}">
                <div class="book-info-others">
                    <div class="book-info-title">
                        {{ $book->title }}
                    </div>
                    <div class="book-info-author">
                        {{ $book->author}}
                    </div>
                </div>
        </div>
    </div>



    <div class="sentence-create">
        <div class="sentence-create-box">
            <div class="new">打ち間違い等を確認してください。投稿後の修正はできません。(1行につき35文字までです)</div>
            <form method="POST" action="{{ route('sentences.store') }}">
                @csrf

                <input type="hidden" name="book_id" value="{{ $book->id }}">
                <div class="gyo-1"><h3>1行目</h3></div>
                <input class="sentence-create-box-text" type="text" value="{{ old('text_1') }}" name="text_1" required autofocus>
                @if ($errors->has('text_1'))<div class="text-danger">{{$errors->first('text_1')}}</div>@endif

                <div class="gyo"><h3>2行目</h3></div>
                <input class="sentence-create-box-text" type="text" value="{{ old('text_2') }}" name="text_2" required>
                @if ($errors->has('text_2'))<div class="text-danger">{{$errors->first('text_2')}}</div>@endif

                <div class="gyo"><h3>3行目</h3></div>
                <input class="sentence-create-box-text" type="text" value="{{ old('text_3') }}" name="text_3" required>
                @if ($errors->has('text_3'))<div class="text-danger">{{$errors->first('text_3')}}</div>@endif
        </div>

        <div class="sentence-btn">
                <p><select class="status" name="status" type="select">
                        @foreach($sentence_status_texts as $key => $val)
                            <option value="{{$val}}">{{$key}}</option>
                        @endforeach
                    </select></p>
                <button type="submit" class="sentence-btn-comfirm">
                        投稿する
                </button>
            </form>
        </div>
    </div>
</div>
