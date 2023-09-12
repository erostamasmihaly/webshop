@if(isset(Auth::user()->name))
<div class="dropdown">
	<button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown">
        <i class="fas fa-user fa-fw"></i>
    	    {{ Auth::user()->name }}
	</button>
	<ul class="dropdown-menu dropdown-menu-end">
		<li>
			@if(has_role('admin'))
				<a class="dropdown-item" href="{{ route('admin_index') }}">Admin felület</a>
			@endif
			<a class="dropdown-item" href="{{ route('home') }}">Áruház felület</a> 
			<a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
			{{ __('Logout') }}
			</a>
			<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
				@csrf
			</form>
		</li>
	</ul>
</div>
@endif
