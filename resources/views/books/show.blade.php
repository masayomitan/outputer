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
        <img src="/storage{{$book->book_image}}">
        <img src="{{ URL::to('public/storage') }}/{{ $book->book_image }}" alt="{{ $book->book_image }}" />
    </tr>
</table>
