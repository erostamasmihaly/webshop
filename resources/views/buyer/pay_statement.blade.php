@extends('buyer.layouts.app')
@section('content')
<div class="container">
<div class="card">
		<div class="card-body">
			<div class="bg-info bg-gradient text-dark text-center mb-2 fw-bold">Adattovábbítási nyilatkozat</div>
			<p>Tudomásul veszem, hogy az ETM Webshop (Miskolc) adatkezelő által a(z) <a href="{{ route('home') }}" target="_blank"><i class="fa-solid fa-arrow-up-right-from-square"></i> {{ route('home') }}</a> felhasználói adatbázisában tárolt alábbi személyes adataim átadásra kerülnek az OTP Mobil Kft., mint adatfeldolgozó részére.</p> 
			<p>Az adatkezelő által továbbított adatok köre az alábbi:</p>
			<ul>
				<li>Név</li>
				<li>E-mail cím</li>
				<li>Ország</li>
				<li>Területi egység</li>
				<li>Irányítószám</li>
				<li>Település</li>
				<li>Utca, házszám...</li>
			</ul> 
			<p>Az adatfeldolgozó által végzett adatfeldolgozási tevékenység jellege és célja a SimplePay Adatkezelési tájékoztatóban, az alábbi linken tekinthető meg:</p>
			<p>
				<a href="https://simplepay.hu/vasarlo-aff/" target="_blank"><i class="fa-solid fa-arrow-up-right-from-square"></i> Vásárlói általános felhasználási feltételek</a>
			</p>
		</div>
	</div>
</div>
@endsection