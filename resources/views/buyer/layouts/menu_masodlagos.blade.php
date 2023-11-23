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
				@if(has_role('alkalmazott'))
					<a class="dropdown-item" href="{{ route('seller_index') }}">Alkalmazotti felület</a> 
				@endif
				@if(has_role('vásárló'))
					<b class="dropdown-item fw-bold">Laravel oldalak</b>
					<a class="dropdown-item" href="{{ route('buyer_notification') }}">Értesítések
					@if(auth()->user()->unreadNotifications->count()>0)
						<span class="w-100">
							<span class="badge bg-danger float-end">{{ auth()->user()->unreadNotifications->count() }}</span>
						</span>
					@endif
					</a>
					<a class="dropdown-item" href="{{ route('buyer_user') }}">Profil adatok</a>
					<a class="dropdown-item" href="{{ route('buyer_cart') }}">Kosár megtekintése</a> 
					<a class="dropdown-item" href="{{ route('pay_history') }}">Vásárlási előzmények</a>
					<b class="dropdown-item fw-bold">VUE.js oldalak</b>
					<a class="dropdown-item" href="{{ route('vue') }}/list">Termékek listája</a>
					<a class="dropdown-item" href="{{ route('vue') }}/user">Felhasználó adatai</a>
					<a class="dropdown-item" href="{{ route('vue') }}/payed">Eddigi vásárlások</a>
					<a class="dropdown-item" href="{{ route('vue') }}/cart">Kosár tartalma</a>
					<a class="dropdown-item" href="{{ route('vue') }}/notification">Értesítések</a>
					<!--a class="dropdown-item" href="{{ route('react') }}">React oldalak</a-->
				@endif
				<b class="dropdown-item fw-bold">Egyéb</b>
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
