<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
{{-- <head> --}}
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ secure_asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/all.css" integrity="sha384-HzLeBuhoNPvSl5KYnjx0BT+WB0QEEqLprO+NBkkk5gbc67FTaL7XIGa2w1L0Xbgc" crossorigin="anonymous">


    <!-- Styles -->

        {{-- <link rel="stylesheet" href="{{ secure_asset('css/header.css') }}">
        <link rel="stylesheet" href="{{ secure_asset('css/reset.css') }}">
        <link rel="stylesheet" href="{{ secure_asset('css/books/index.css') }}">
        <link rel="stylesheet" href="{{ secure_asset('css/books/create.css') }}">
        <link rel="stylesheet" href="{{ secure_asset('css/books/show.css') }}">

        <link rel="stylesheet" href="{{ secure_asset('css/sentences/create.css') }}">
        <link rel="stylesheet" href="{{ secure_asset('css/sentences/create.css') }}">

        <link rel="stylesheet" href="{{ secure_asset('css/tags/show.css') }}">
        <link rel="stylesheet" href="{{ secure_asset('css/popular.css') }}">

        <link rel="stylesheet" href="{{ secure_asset('css/users/show.css') }}">
        <link rel="stylesheet" href="{{ secure_asset('css/users/edit.css') }}">
        <link rel="stylesheet" href="{{ secure_asset('css/users/register.css') }}">
        <link rel="stylesheet" href="{{ secure_asset('css/users/timeline_sentence.css') }}">
        <link rel="stylesheet" href="{{ secure_asset('css/users/follow.css') }}"> --}}

        <link rel="stylesheet" href="{{ asset('css/header.css') }}">
        <link href="{{ asset('css/reset.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/books/index.css') }}">
        <link rel="stylesheet" href="{{ asset('css/books/create.css') }}">
        <link rel="stylesheet" href="{{ asset('css/books/show.css') }}">

        <link rel="stylesheet" href="{{ asset('css/sentences/create.css') }}">
        <link rel="stylesheet" href="{{ asset('css/sentences/create.css') }}">

        <link rel="stylesheet" href="{{ asset('css/tags/show.css') }}">
        <link rel="stylesheet" href="{{ asset('css/popular.css') }}">


        <link rel="stylesheet" href="{{ asset('css/users/show.css') }}">
        <link rel="stylesheet" href="{{ asset('css/users/edit.css') }}">
        <link rel="stylesheet" href="{{ asset('css/users/register.css') }}">
        <link rel="stylesheet" href="{{ asset('css/users/timeline_sentence.css') }}">
        <link rel="stylesheet" href="{{ asset('css/users/follow.css') }}">





            @yield('content')
        </main>
    </div>
</body>
</html>
@yield('script')
