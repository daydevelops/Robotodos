@extends('layouts.app')
@section('header')
    @component('particals.jumbotron')
        <h1 class='oleo'>{{ $category->name }}</h1>
    @endcomponent
@endsection
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <ul class="list-group">
                    @forelse($articles as $article)
                        <li class="list-group-item">
                            <span class="badge badge-secondary float-right">{{ $article->comments->count() }}</span>
                            <a href="{{ url($article->slug) }}">{{ $article->title }}</a>
                        </li>
                    @empty
                        <li class="list-group-item">{{ lang('Nothing') }}</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
@endsection
@include('particals.defaultSidebar')
