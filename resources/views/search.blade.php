@extends('layouts.app')

@section('header')
	@component('particals.jumbotron')
		<h2>Search: {{ request()->get('q') }}</h2>

	@endcomponent
@endsection
@section('content')

	@include('widgets.article')

@endsection
