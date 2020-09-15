@extends('layouts.app')
@include('layouts.header')


    @foreach ($all_users as $user)
        {{ $user->name }}
    @endforeach

