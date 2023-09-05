<div class="dropdown">
	<button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown">
        <i class="fas fa-user fa-fw"></i>
			@guest
				Vendég
			@else
    	    	{{ Auth::user()->name }}
			@endguest
	</button>
	<ul class="dropdown-menu dropdown-menu-end">
		<li>
			@guest
				@if (Route::has('login'))
					<a class="dropdown-item" href="{{ route('login') }}">Belépés</a>
				@endif
				@if (Route::has('register'))
					<a class="dropdown-item" href="{{ route('register') }}">Regisztráció</a>
				@endif
			@else
				@if(has_role('admin'))
					<a class="dropdown-item" href="{{ route('admin_index') }}">Admin felület</a>
				@endif
				@if(has_role('seller'))
					<a class="dropdown-item" href="{{ route('seller_index') }}">Eladói felület</a> 
				@endif
				@if(has_role('buyer'))
					<a class="dropdown-item" href="{{ route('buyer_user') }}">Profil adatok</a>
					<a class="dropdown-item" href="{{ route('buyer_cart') }}">Kosár megtekintése</a> 
					<a class="dropdown-item" href="{{ route('pay_history') }}">Vásárlási előzmények</a>
				@endif
				<a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
				{{ __('Logout') }}
				</a>
				<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
					@csrf
				</form>
			@endguest
		</li>
	</ul>
</div>
