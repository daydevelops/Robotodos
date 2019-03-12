@extends('layouts.app')
@section('header')
    @component('particals.jumbotron')
        <h1 class='oleo'>{{ config('blog.article.title') }}</h1>

        <h3>{{ config('blog.article.description') }}</h3>
    @endcomponent
@endsection
@section('content')

    @include('widgets.article')

    {{ $articles->links('pagination.default') }}

@endsection

@include('particals.defaultSidebar')
