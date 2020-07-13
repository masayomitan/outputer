<h1>一覧画面</h1>
<p><a href="{{ route('books.create') }}">新規追加</a></p>

@if ($message = Session::get('success'))
<p>{{ $message }}</p>
@endif

<table border="1">
    <tr>
        <th>title</th>
        <th>詳細</th>
        <th>編集</th>
        <th>削除</th>
    </tr>
    @foreach ($books as $book)
    <tr>
        <td>{{ $book->title }}</td>
        <td>{{ $book->book_image }}</td>
        <img src="{{ asset('storage/' . $book->book_image) }}" alt="イメージ画像" width="500px" class="w-100">
        <th><a href="{{ route('books.show',$book->id)}}">詳細</a></th>
        <th><a href="{{ route('books.edit',$book->id)}}">編集</a></th>
        <th>
            <form action="{{ route('books.destroy', $book->id)}}" method="POST">
                @csrf
                @method('DELETE')
                <input type="submit" name="" value="削除">
            </form>
        </th>
    </tr>
    @endforeach
</table>
