<div id="author-bio-wrap">
	<div id="author-bio-head">
		<h4 class='oleo text-center'>
			{{$author->name}}
		</h4>
	</div>
	<div id='author-bio-image'>
	</div>
	<div id="author-bio">
		<p><small>
			That's the way I look when I get home late; black and blue.
			If you've been in Alaska less than a year you're a Cheechako.
			Let's give him a friend too. Everybody needs a friend. Tree trunks grow however makes them happy.
			La- da- da- da- dah. Just be happy. Decide where your cloud lives. Maybe he lives right in here.
		</small></p>
	</div>
	<div id="author-bio-foot">
		<ul>
			@if ($author->github_url)
				<li><a href="{{$author->github_url}}">github</a></li>
			@endif
		</ul>
	</div>
</div>
