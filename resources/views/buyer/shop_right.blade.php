<div class="col-sm-4">
    <div class="card p-2">
        <div class="bg-info bg-gradient text-dark text-center mb-2 fw-bold">Elérhetőségek</div>
        @if($shop->address)
            <div><i class="fa-solid fa-map"></i> {{ $shop->address }}</div>
        @endif
        @if($shop->url)
            <div><i class="fa-solid fa-link"></i> <a href="{{ $shop->url }}" target="_blank">{{ $shop->url }}</a></div>
        @endif
        @if($shop->email)
            <div><i class="fa-regular fa-envelope"></i> <a href="mailto: {{ $shop->email }}">{{ $shop->email }}</a></div>
        @endif
        @if($shop->telephone)
            <div><i class="fa-solid fa-phone"></i> <a href="tel: {{ $shop->telephone }}">{{ $shop->telephone }}</a></div>
        @endif
        <div class="bg-info bg-gradient text-dark text-center mb-2 mt-2 fw-bold">Térkép</div>
        <div><i class="fa-solid fa-location-pin"></i> {{ $shop->latitude }} {{ $shop->longitude }}</div>
        <input type="hidden" id="latitude" value="{{ $shop->latitude }}"/>
        <input type="hidden" id="longitude" value="{{ $shop->longitude }}"/>
        <div id="map"></div>
    </div>
</div>