@foreach($bookTag as $tags)


<link rel="stylesheet" href="{{ asset('css/tags/show.css') }}">
@include('layouts.header')

    <div class="tags">

        <div class="side-navi">
            @include('components.side_navi')
        </div>
        <div class="tags-show">
            @foreach($tags->books as $tags)
            <div class="tags-show-each">
                <div class="tags-show-image">
                    <a href="{{ route('books.show',$tags->id)}}">
                    <img  class="tags-image" src="{{ asset('storage/book_image/' .$tags->book_image)}}">
                </div>
                <div class="tags-title">
                    {!! nl2br(e(Str::limit($tags->title, 25))) !!}</p>
                </div></a>
                <div class="tags-author">
                    {!! nl2br(e(Str::limit($tags->author, 18))) !!}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endforeach
