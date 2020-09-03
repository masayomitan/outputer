

@extends('layouts.app')
@include('layouts.header')
{{ Breadcrumbs::render('books.create') }}

<div class="book-create">
    <div class="new"><h1>新しい本を登録</h1></div>
        <div class="search-box-create">
            <div class="search-box-book-create">
                <div class="search-exist">STEP1.既に登録されていないか調べる</div>
                <form action="{{ route('search.index') }}" class="search">
                    <span class="search-exist"><input type="text" name="keyword" value="{{$keyword}}" placeholder="キーワード検索" class="prompt"></span>
                </form>
            </div>
        </div>


        <div class="input-box">
            <div class="input-box-store"><form method="POST" action="{{ route('books.store') }}"  enctype="multipart/form-data">
                @csrf
                <div class="input-book">STEP2.本情報の入力</div>
                <div class="new-2">名前の打ち間違い等を確認してください。本の投稿後の修正はできません。</div>

                <p><label class="letter" for="title">タイトル名</label></p>
                <input class="title-input" id="title" name="title" type="text" value="{{ old('title') }}" required autofocus>
                @if ($errors->has('title'))<div class="text-danger">{{$errors->first('title')}}</div>@endif

                <p><label class="letter" for="author">著者</label></p>
                <input class="author-input" id="author" name="author" type="text" value="{{ old('author') }}" required autofocus>
                @if ($errors->has('author'))<div class="text-danger">{{$errors->first('author')}}</div>@endif

                <p><label class="letter" for="tag">タグ （任意・10文字以内 ５個まで付けれます）</label></p>
                <input class="tag-input" id="tag" name="tags[]" type="text" value="{{ old('tags[]') }}"  autofocus>
                <input class="tag-input" id="tag" name="tags[]" type="text" value="{{ old('tags[]') }}"  autofocus>
                <input class="tag-input" id="tag" name="tags[]" type="text" value="{{ old('tags[]') }}"  autofocus>
                <input class="tag-input" id="tag" name="tags[]" type="text" value="{{ old('tags[]') }}"  autofocus>
                <input class="tag-input" id="tag" name="tags[]" type="text" value="{{ old('tags[]') }}"  autofocus>
                @if ($errors->has('tags.*'))<div class="text-danger">{{$errors->first('tags.*')}}</div>@endif

                <p><label class="letter" for="tag">画像ファイル</label></p>
                <label><div class="book_image"></div>
                    <input class="file-input" type="file" id="book_image" name="book_image" value="{{ old('book_image') }}" required>
                </label>
            </div>

                <div class="register-box-book">
                    <div class="container-btn">
                        <div class="push-book">STEP3.間違ってなければボタンを押す</div>
                        <button type="submit" class="book-btn" >新しく登録する</button>
                        </form>
                    </div>
                </div>
        </div>
    </div>
</div>
