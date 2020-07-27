@push('cropper')
  <link href="{{ asset('css/cropper-custom.css') }}" rel="stylesheet">
  <link  href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.min.css" rel="stylesheet">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.min.js"></script>
  <script src="{{ asset('js/cropper-custom.js') }}" defer></script>
@endpush

@push('tui-editor')
  <script src="https://uicdn.toast.com/tui-editor/latest/tui-editor-Editor-full.js"></script>
  <script src="{{ asset('js/tui-editor-custom.js') }}"></script>
@endpush


@extends('layouts.app')

@section('content')


<li class="list-group-item">
    <div class="py-3">
        @if($user)
            <form method="POST" action="{{ route('sentences.store') }}">
            @csrf
                <div class="form-group row mb-s0">
                    <div class="col-md-12 p-3 w-100 d-flex">
                        <a href="{{ url('users/' .$user->id) }}" class="text-secondary">&#064;{{ $user->id }}</a>
                            <a href="{{ url('users/' .$user->id) }}" class="text-secondary">&#064;{{ $user->screen_name }}</a>
                            <a href="{{ url('books/' .$book->id) }}" class="text-secondary">&#064;{{ $book->title }}</a>
                            <a href="{{ url('books/' .$book->id) }}" class="text-secondary">&#064;{{ $book->id }}</a>
                        </div>
                    </div>
            <div class="col-md-12">
                <input type="hidden" name="book_id" value="{{ $book->id }}">
                <textarea class="form-control @error('text') is-invalid @enderror" name="text" required rows="4">{{ old('text')}}</textarea>

                <select class="form-control" name="status" type="select" >
                    @foreach($sentence_status_texts as $key => $val)
                    <option value="{{$val}}">{{$key}}</option>
                    @endforeach
                </select>

                <div class="form-group row mb-0">
                    <div class="col-md-12 text-right">
                        <button type="submit" class="btn btn-primary">
                            コメントする
                        </button>
                    </div>
                </div>
            </form>
        @else
    </div>
</li>
@endif
