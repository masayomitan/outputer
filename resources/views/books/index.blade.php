@extends('layouts.app')

@include('layouts/header')
<link rel="stylesheet" href="{{ asset('css/header.css') }}">

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Admin Index</div>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        </div>
                    @endif
                    <div class="table-resopnsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>{{__('ID')}}</th>
                                    <th>{{__('title')}}</th>
                                    <th>{{__('over_view')}}</th>
                                    <th>{{__('book_image')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($books))  // $bookデータ存在チェック
                                    @foreach ($books as $book)  // テーブル作成
                                        <tr>
                                            <td>{{ $book->id }}</td>
                                            <td>{{ $book->title }}</td>
                                            <td>{{ $book->over_view }}</td>
                                            @if($book->book_image == null)
                                            <img src="/storage/noimage.png">
                                            @else
                                            <img src="/storage/{{$book->book_image}}">
                                            @endif
                                            <td>{{ $book->book_image }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                        <button type="button" class="btn btn-primary" onclick="location.href='{{ route('books.create') }}'">
                            {{ __('追加') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
