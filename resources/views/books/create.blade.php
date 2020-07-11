
@extends('layouts.app')

@section('content')

<form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data">
@csrf
<input type="text" name="title" placeholder="タイトル" class="form-control form-control-lg">
<textarea  rows="8" cols="40" type="textarea" name="over_view" placeholder="概要" class="form-control form-control-lg"></textarea>
<input type="file" id="book_image" name="book_image" >
<input type="submit"  value="Submit"></button>

</form>


@endsection
