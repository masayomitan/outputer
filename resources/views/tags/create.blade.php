

<div class="input-box">
    <div class="input-box-store"><form method="POST" action="{{ route('tags.store') }}">
        @csrf
        <input type="hidden" name="book_id" value="{{ $book->id }}">
        <p><label class="letter" for="tag">タグ （任意・10文字以内）</label></p>
        <input class="tag-input" id="tag" name="tags[]" type="text" value="{{ old('tags[]')}}"  autofocus>

    </div>
    <button type="submit" class="book-btn" >新しく登録する</button>
                </form>
</div>
