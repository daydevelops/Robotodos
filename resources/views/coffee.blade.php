@extends('layouts.app')

@section('header')
@component('particals.jumbotron')
<h2 class="text-center oleo">Support this blog by buying me a coffee</h2>
@endcomponent
@endsection

@section('content')
<p class="text-center">Blogging isn't always easy. I try to write about my experiences on a regular basis but sometimes an 
    extra dose of caffiene is needed to get the job done. As a reader, you can help me produce a higher quantity and 
    quality of work with just a couple dollars for a cup of coffee. 
</p>
@endsection

@include('particals.defaultSidebar')