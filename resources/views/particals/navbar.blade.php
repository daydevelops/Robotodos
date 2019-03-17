<nav class="navbar navbar-expand-lg navbar-dark">
	<div class="container">
		<a class="navbar-brand oleo" href="{{ url('/') }}">
			|&nbsp;&nbsp;{{ config('app.name') }}&nbsp;&nbsp;|&nbsp;&nbsp;
		</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false" aria-label="Toggle navigation">
			<i class="fas fa-bars"></i>
		</button>


		<div class="collapse navbar-collapse" id="app-navbar-collapse">
			<!-- Left Side Of Navbar -->
			<ul class="navbar-nav mr-auto">
				<li class="nav-item"><a class="nav-link" href="{{ url('/') }}">{{ lang('Articles') }}</a></li>
				<li class="nav-item"><a class="nav-link" href="{{ url('discussion') }}">{{ lang('Discussions') }}</a></li>
				<li class="nav-item"><a class="nav-link" href="https://daydevelops.com">DayDevelops</a></li>
			</ul>

			<!-- Right Side Of Navbar -->
			<ul class="navbar-nav navbar-right">

				<!-- Authentication Links -->
				@if (Auth::guest())
					<li class="nav-item"><a class="nav-link" href="{{ url('login') }}">{{ lang('Login') }}</a></li>
					<li class="nav-item"><a class="nav-link" href="{{ url('register') }}">{{ lang('Register') }}</a></li>
				@else

					{{-- @if (Auth::user()->unreadNotifications->count() > 0) --}}
						<li class="nav-item notification">
							<a class="nav-link" href="{{ url('user/notification') }}">
								<span class="new" style='display: block'>Notifications</span>
							</a>
						</li>
					{{-- @endif --}}
					<li class="nav-item dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<b class="caret"></b>&nbsp;&nbsp;
							<img class="avatar rounded-circle" src="{{ Auth::user()->avatar }}">
						</a>

						<ul class="dropdown-menu" role="menu">
							<li class="dropdown-item"><a href="{{ url('user', ['name' => Auth::user()->name]) }}"><i class="fas fa-user"></i>{{ lang('Personal Center') }}</a></li>
							<li class="dropdown-item"><a href="{{ url('setting') }}"><i class="fas fa-cog"></i>{{ lang('Settings') }}</a></li>
							@if(Auth::user()->is_admin)
								<li class="dropdown-item"><a href="{{ url('dashboard') }}"><i class="fas fa-tachometer-alt"></i>{{ lang('Dashboard') }}</a></li>
							@endif
							<li class="dropdown-divider"></li>
							<li class="dropdown-item">
								<a href="{{ url('logout') }}"
								onclick="event.preventDefault();
								document.getElementById('logout-form').submit();">
								<i class="fas fa-sign-out-alt"></i>{{ lang('Logout') }}
							</a>

							<form id="logout-form" action="{{ url('logout') }}" method="POST" style="display: none;">
								{{ csrf_field() }}
							</form>
						</li>
					</ul>
				</li>
			@endif
		</ul>
	</div>
</div>
</nav>
