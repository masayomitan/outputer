<h1>詳細画面</h1>
<p><a href="{{ route('books.index')}}">一覧画面</a></p>

<table border="1">
    <tr>
        <th>id</th>
        <th>title</th>
        <th>over_view</th>
        <th>画像</th>
    </tr>
    <tr>
        <td>{{ $book->id }}</td>
        <td>{{ $book->title }}</td>
        <td>{{ $book->over_view }}</td>
        <img src="{{ URL::to('storage/book_image/') }}/{{ $book->book_image }}" alt="{{ $book->book_image }}" />


    </tr>
</table>
<th><a href="{{ route('sentences.create', ['id' => $book->id]) }}">コメント</a></th>
<div class="col-xs-8 col-xs-offset-2">

    @foreach($sentences as $sentence)
    <tr>
        <td>{{ $sentence->text }}</td>
    </tr>
    <form method="POST" action="{{ route('favorites.store') }}">
        @csrf

        <input type="hidden" name="sentence_id" value="{{ $sentence->id }}">
        <button>
    </form>

    @endforeach

