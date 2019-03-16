<div id="author-bio-wrap">
	<div id="author-bio-head">
		<div id='author-bio-image'>
			<img src="{{$author->avatar}}" alt="{{$author->name}}'s image'">
		</div>
		<h4 class='oleo text-center'>
			{{$author->name}}
		</h4>
	</div>
	<div id="author-bio">
		<p><small>{{$author->description}}</small></p>
	</div>
	<div id="author-bio-foot">
		<div id="author-links" class='text-center'>
			@if($author->github_url)
				<span class="mx-2">
					<a href="{{$author->github_url}}" target="_blank">
						<i class="fab fa-github"></i>
					</a>
				</span>
			@endif
			@if($author->twitter_url)
				<span class="mx-2">
					<a href="{{$author->twitter_url}}" target="_blank">
						<i class="fab fa-twitter"></i>
					</a>
				</span>
			@endif
			@if($author->website)
				<span class="mx-2">
					<a href="{{$author->website}}" target="_blank">
						<i class="fas fa-globe"></i>
					</a>
				</span>
			@endif
		</div>
	</div>
</div>
