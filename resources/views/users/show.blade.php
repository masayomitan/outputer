@extends('layouts.app')
@include('layouts.header')


{{ Breadcrumbs::render('users.show', $user) }}

@include('components.users.user_profile')
@include('components.users.user_tab_list')
@include('components.users.timeline_sentence_list')


