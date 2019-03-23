@if ($trending_article)
<hr>
<div id='trending-article'>
	<h3 class="oleo text-center">
		{{$trending_article->isPartOfSeries() ? "Next " : "Popular "}} Article
	</h3>
	@if($trending_article->page_image)
		<div>
			<a href="{{ url($trending_article->slug) }}">
				<img id="trending-article-img" alt="{{ $trending_article->slug }}" src="{{ $trending_article->page_image }}" data-holder-rendered="true">
			</a>
		</div>
	@endif
	<div class="media-body">
		<p class="oleo text-center">
			<a href="{{ url($trending_article->slug) }}">
				{{ $trending_article->title }}
			</a>
		</p>
		<div class="meta text-center">
			<small>{{ $trending_article->subtitle }}</small>
		</div>
		{{-- <div class="description">
		{{ $trending_article->meta_description }} --}}
	</div>
	<div class="extra">
		<div class="info text-center">
			<i class="fas fa-clock"></i>{{ $trending_article->published_at->diffForHumans() }}&nbsp;,&nbsp;
			<i class="fas fa-eye"></i>{{ $trending_article->view_count }}
		</div>
	</div>
</div>
@endif
