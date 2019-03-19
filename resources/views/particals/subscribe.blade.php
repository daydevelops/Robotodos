{{-- {{dd(auth()->user()->isSubscribed)}} --}}
{{-- Only show the form if the user is a guest, or they are signed in but have not yet subscribed --}}
@if (!auth()->check() || !auth()->user()->subscription)
	<hr>
	<div id="subscribe-wrapper">
		<div id="subscribe-header">
			<p class="oleo text-center">
				<small>Can't wait to read the latest article?</small>
			</p>
		</div>
		<form id="subscribe-form" class="form" method="post" action="/subscribe">
			@csrf
			<div class="form-group">
				@if (auth()->check() && !auth()->user()->isSubscribed)
					<input type="email" name="email" class="form-control" id="subscribe-email" value="{{auth()->user()->email}}" placeholder="Email address">
				@elseif (!auth()->check()) {{-- not proud of these conditionals --}}
					<input type="email" name="email" class="form-control" id="subscribe-email" placeholder="Email address">
				@endif
			</div>
			<div class="form-group">
				<button type="submit" class="form-control btn btn-primary text-center" style="width:100%" id="subscribe-submit">
					Be in the loop!
				</button>
			</div>
		</form>
	</div>
@endif
