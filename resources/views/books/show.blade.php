<h1>詳細画面</h1>
<p><a href="{{ route('books.index')}}">一覧画面</a></p>

<table border="1">
    <tr>
        <th>id</th>
        <th>title</th>
        <th>over_view</th>
        <th>created_at</th>
        <th>updated_at</th>
    </tr>
    <tr>
        <td>{{ $book->id }}</td>
        <td>{{ $book->title }}</td>
        <td>{{ $book->over_view }}</td>
        <td>{{ $book->created_at }}</td>
        <td>{{ $book->updated_at }}</td>
    </tr>
</table>
