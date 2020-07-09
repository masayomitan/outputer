@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Admin Index</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{--成功時のメッセージ--}}
                    @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    {{-- エラーメッセージ --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        </div>
                    @endif
                    // この辺から追加
                    <div class="table-resopnsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>{{__('ID')}}</th>
                                    <th>{{__('admin_code')}}</th>
                                    <th>{{__('name')}}</th>
                                    <th>{{__('role')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($admins))  // $adminデータ存在チェック
                                    @foreach ($admins as $admin)  // テーブル作成
                                        <tr>
                                            <td>{{ $admin->id }}</td>
                                            <td>{{ $admin->admin_code }}</td>
                                            <td>{{ $admin->name }}</td>
                                            <td>{{ $admin->role}}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                        <button type="button" class="btn btn-primary" onclick="location.href='{{ route('books.create') }}'">
                            {{ __('追加') }}
                        </button>
                    // この辺まで追加
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


<div class="card-title">
    <h1>{!! nl2br(e($book->book_image)) !!}</h1>
    <div class="mb-2">
        <div class="book-image-wrapper">
            <div class="book-image-content" style="background-image: url( {{ $book->book_image }} );"></div>
        </div>
    </div>
    <hr>
    <div id="preview_marked"></div>
        <!-- {!! nl2br($book->over_view) !!} -->

    </div>
    <textarea id="edit_content" class="editor mt-2 form-control @error('over_view') is-invalid @enderror" required autocomplete="over_view" name="over_view" style="display: none;">{{$book->over_view}}</textarea>

    @if($book->image == null)
    <img src="/storage/noimage.png">
  @else
    <img src="/storage/{{$book->image}}">
  @endif

