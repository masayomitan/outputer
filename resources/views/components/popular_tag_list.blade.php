
 <div class="card">

    <div class="card-header-tag-mark"><i class="fas fa-hashtag"></i>話題のタグ</div>
    <div class="card-body">
    @foreach ($popular_tags as $tag)
        <a href="{{ route('tags.show', ['tag'=>$tag->id]) }}">
        <p>{{$tag->name}}({{$tag->books_count}}冊)</p>
        </a>
    @endforeach
    </div>
</div>
