
                <div class="card-title">
                <h1>{!! nl2br(e($book->book_image)) !!}</h1>
                <div class="mb-2">
                    <div class="book-image-wrapper">
                        <div class="book-image-content" style="background-image: url( {{ $book->book_image }} );"></div>
                    </div>
                </div>
                <hr>
                <div id="preview_marked"></div>
                    <!-- {!! nl2br($book->over_view) !!} -->

                </div>
                <textarea id="edit_content" class="editor mt-2 form-control @error('over_view') is-invalid @enderror" required autocomplete="over_view" name="over_view" style="display: none;">{{$book->over_view}}</textarea>

                @if($book->image == null)
                <img src="/storage/noimage.png">
              @else
                <img src="/storage/{{$book->image}}">
              @endif
