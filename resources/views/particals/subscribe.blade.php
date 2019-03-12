<hr>
{{-- @if (auth()->check() && !auth()->user()->isSubscribed)) --}}
<div id="subscribe-wrapper">
	<div id="subscribe-header">
		<p class="oleo text-center">
			<small>Can't wait to read the latest article?</small>
		</p>
	</div>
	<form id="subscribe-form" class="form" method="post" action="/subscribe" onSubmit="return false;">
		<div class="form-group">
			<input type="text" class="form-control" id="subscribe-email" placeholder="Email address">
		</div>
		<div class="form-group">
			<button type="submit" class="form-control btn btn-primary text-center" style="width:100%" id="subscribe-submit">
				Be in the loop!
			</button>
		</div>
	</form>
</div>
{{-- @endif --}}
