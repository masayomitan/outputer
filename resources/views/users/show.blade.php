@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12 mb-3">
      <div class="card">
        @include('components.users.user_profile')
        @include('components.users.user_tab_list')
        @include('components.users.timeline_sentence_list')
      </div>
    </div>
  </div>

</div>
@endsection
