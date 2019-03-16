@extends('layouts.app')

@section('title', $article->title)
@section('header')
	@component('particals.jumbotron')
		@if($article->is_draft)
			<div class='alert alert-danger'>
				<h2>DRAFT<h2>
			</div>
		@endif

		<h4>{{ $article->title }}</h4>

		<h6>{{ $article->subtitle }}</h6>

		<div class="header">
			<i class="fas fa-user"></i>{{ $article->user->name ?? 'null' }}，
			@if(count($article->tags))
				<i class="fas fa-tags"></i>
				@foreach($article->tags as $tag)
					<a href="{{ url('tag', ['tag' => $tag->tag]) }}">{{ $tag->tag }}</a>，
				@endforeach
			@endif
			<i class="fas fa-clock"></i>{{ $article->published_at->diffForHumans() }}
		</div>


	@endcomponent
@endsection
@section('content')


	<div class="article container">
		@if($article->page_image)
			<div class="row">
				<div class="col-12 article-img-wrap">
					<img src="{{$article->page_image}}" alt="Cover Image" id="article-img">
				</div>
			</div>
		@endif

		<div class="row">
			<div class="col-md-10 offset-md-1">
				<parse content="{{ $article->content['raw'] }}"></parse>
				@if(false)
					{{-- @if($article->is_original) --}}
					<div class="publishing alert alert-dismissible alert-info">
						<button type="button" class="close" data-dismiss="alert">×</button>
						{!! config('blog.license') !!}
					</div>
				@endif
				@if(config('blog.social_share.article_share'))
					<div class="footing">
						<div class="social-share"
						data-title="{{ $article->title }}"
						data-description="{{ $article->title }}"
						{{ config('blog.social_share.sites') ? "data-sites=" . config('blog.social_share.sites') : '' }}
						{{ config('blog.social_share.mobile_sites') ? "data-mobile-sites=" . config('blog.social_share.mobile_sites') : '' }}
						initialized></div>
					</div>
				@endif
			</div>
		</div>
	</div>
		<comment title="Comments"
		commentable-type="articles"
		commentable-id="{{ $article->id }}"
		@can('comment',$article)
		username="{{ Auth::user()->name }}"
		user-avatar="{{ Auth::user()->avatar }}"
		can-comment
		@endcan
		></comment>

@endsection

@section('sidebar')
	<?php $author = $article->user; ?>
	<br>
	@include('particals.author-bio')
	@include('particals.searchbar')
	@include('particals.subscribe')
	@include('particals.trending-article')
@endsection

@section('scripts')
	<script>
	hljs.initHighlightingOnLoad();
	</script>
@endsection
