<h1>編集画面</h1>
{{-- <p><a href="{{ route('book.index')}}">一覧画面</a></p> --}}

@if ($message = Session::get('success'))
<p>{{ $message }}</p>
@endif

<form action="{{ route('books.update',$books->id)}}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <p>タイトル：<input type="text" name="title" value="{{ $books->title }}"></p>
    <p>著者：<input type="text" name="over_view" value="{{ $books->over_view }}"></p>

    <input type="submit" value="編集する">
</form>

