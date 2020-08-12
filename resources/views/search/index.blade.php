

<h2 class="text-center"><span class="double-quotation-mark h2">{{$keyword}}</span><span class="ml-2">で検索</span></h2>
<div class="tags-title">
    @foreach ($books as $book)
    {!! nl2br(e(Str::limit($book->title, 25))) !!}</p>
    @endforeach
</div></a>
@foreach ($users as $book)
    {!! nl2br(e(Str::limit($book->name, 25))) !!}</p>
    @endforeach
