@extends('layouts.app')
@section('header')
    @component('particals.jumbotron')
        <h1 class='oleo'>{{ config('blog.discussion.title') }}</h1>

        <h3>{{ config('blog.discussion.subtitle') }}</h3>

        <a href="{{ url('discussion/create') }}" class="btn btn-info btn-lrg"><i class="fas fa-pencil-alt"></i> Discuss!</a>
    @endcomponent
@endsection
@section('content')

    <div class="discussion container mb-4">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                @forelse($discussions as $discussion)
                <div class="media my-3">
                    <div class="media-left mr-3">
                        <a href="{{ url('discussion', ['id' => $discussion->id]) }}">
                            <img class="media-object rounded-circle" width="50" src="{{ $discussion->user->avatar ?? config('blog.default_avatar') }}">
                        </a>
                    </div>
                    <div class="media-body">
                        <h5 class="media-heading">
                            <a href="{{ url('discussion', ['id' => $discussion->id]) }}">
                                {{ $discussion->title }}
                            </a>
                        </h5>
                        <div class="media-conversation-meta">
                            <div class="media-conversation-replies">
                                <a href="{{ url('discussion', ['id' => $discussion->id]) }}">
                                    {{ $discussion->comments->count() }}
                                </a>
                                {{ lang('Replies') }}
                            </div>
                        </div>
                        {{ $discussion->user->name ?? 'null' }}
                    </div>
                </div>
                @empty
                    <h3 class="text-center">{{ lang('Nothing') }}</h3>
                @endforelse
            </div>
        </div>
    </div>

    {{ $discussions->links('pagination.default') }}

@endsection

@include('particals.defaultSidebar')
