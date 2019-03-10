@extends('layouts.app')

@section('content')
    @component('particals.jumbotron')
		<hr>
        <h1 class='oleo'>{{ config('blog.article.title') }}</h1>

        <h3>{{ config('blog.article.description') }}</h3>
		<hr>
    @endcomponent

    @include('widgets.article')

    {{ $articles->links('pagination.default') }}

@endsection
