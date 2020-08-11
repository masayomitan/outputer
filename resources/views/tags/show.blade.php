



{{-- <h2 class="text-center"><span class="tag-mark h2">{{$bookTag->name}}</span><span class="ml-2">の本一覧</span></h2> --}}
        <hr>
      </div>
    </div>
  </div>

</div>

@foreach($bookTag as $tag)
{{-- @php var_dump($tag); @endphp --}}
    {{-- {{$tag}}
    {{$tag->name}}
    {{$tag->books}} --}}

    @foreach($tag->books as $tags)

    {{$tags->title}}
    {{$tags->author}}
    @endforeach

@endforeach
