<!DOCTYPE html>
<html lang="en">

<head>
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id={{ config('blog.google.id') }}"></script>
	<script>
		window.dataLayer = window.dataLayer || [];

		function gtag() {
			dataLayer.push(arguments);
		}
		gtag('js', new Date());

		gtag('config', '{{ config("blog.google.id") }}');
	</script>


	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="keywords" content="{{ config('blog.meta.keywords') }}">
	<meta name="description" content="{{ config('blog.meta.description') }}">

	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">



	<link rel="apple-touch-icon" sizes="152x152" href="images/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="images/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="images/favicon-16x16.png">
	<link rel="manifest" href="images/site.webmanifest">
	<link rel="mask-icon" href="images/safari-pinned-tab.svg" color="#5bbad5">
	<link rel="shortcut icon" href="images/favicon.ico">
	<meta name="msapplication-TileColor" content="#da532c">
	<meta name="msapplication-config" content="images/browserconfig.xml">
	<meta name="theme-color" content="#ffffff">


	{{-- <link rel="shortcut icon" href="{{ config('blog.default_icon') }}"> --}}

	<title>@yield('title', config('app.name'))</title>

	<link rel="stylesheet" href="{{ mix('css/home.css') }}">
	<link rel="stylesheet" href="{{ mix('css/themes/' . config('blog.color_theme') . '.css') }}">

	<!-- Scripts -->
	<script>
	window.Language = '{{ config('app.locale') }}';

	window.Laravel = <?php echo json_encode([
		'csrfToken' => csrf_token(),
	]); ?>
	</script>

	@yield('styles')
</head>
<body>
	<div id="app">
		@include('particals.navbar')

		<div class="main container-fluid">
			<div class="row">
				<div class="col-12">
					@yield('header')
				</div>
			</div>
			<div class="row">
				<div class="col-lg-9">
					@yield('content')
				</div>
				<div class="col-lg-3">
					<div id="sidebar">
						@yield('sidebar')
					</div> <!-- sidebar -->
				</div>
			</div>
		</div>

		@include('particals.footer')
	</div>

	<!-- Scripts -->
	<script src="{{ mix('js/home.js') }}"></script>

	@yield('scripts')

	<script>
	$(function () {
		$("[data-toggle='tooltip']").tooltip();
	});
</script>
</body>

</html>