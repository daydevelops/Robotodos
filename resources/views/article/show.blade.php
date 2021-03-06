@extends('layouts.app')

@section('title', $article->title)
@section('header')
	@component('particals.jumbotron')
		@if($article->is_draft)
			<div class='alert alert-danger'>
				<h2>DRAFT<h2>
			</div>
		@endif

		<h2>{{ $article->title }}</h2>

		<h4>{{ $article->subtitle }}</h4>

		<div class="header">
			<i class="fas fa-user"></i>{{ $article->user->name ?? 'null' }}，
			<i class="fas fa-clock"></i>{{ $article->published_at->diffForHumans() }},
			<i class="fas fa-eye"></i>{{ $article->view_count }}
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

		@if ($article->needs_account && !auth()->check())
			<div class="row">
				<div class="col-md-10 offset-md-1">
				<h3> Sorry, but this article has been restricted to user access only.</h3>
				<p> Don't worry though, registration will only take you a second!</p>
				<p><a href='/register'>Register</a> or <a href='/login'>Login</a></p>
				</div>
			</div>
		@else
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
		@endif
		</div>
		@if (!$article->needs_account || auth()->check())
			<comment title="Comments"
			commentable-type="articles"
			commentable-id="{{ $article->id }}"
			@can('comment',$article)
			username="{{ Auth::user()->name }}"
			user-avatar="{{ Auth::user()->avatar }}"
			can-comment
			@endcan
			></comment>
		@endif

@endsection

@section('sidebar')
	<?php $author = $article->user; ?>
	<br>
	@include('particals.author-bio')
	@include('particals.searchbar')
	@include('particals.subscribe')
	@include('particals.trending-article')
	<br>
@endsection

@section('scripts')
	<script>
	hljs.initHighlightingOnLoad();
	</script>
@endsection
