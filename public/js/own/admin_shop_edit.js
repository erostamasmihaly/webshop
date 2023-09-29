$(function () {

    // GPS szélesség és hosszúság lekérdezése
    var latitude = $("input[name='latitude']").val();
    var longitude = $("input[name='longitude']").val();

    // Leaflet pont létrehozása ezen két koordinátából
    var point = L.latLng(latitude, longitude);

    // Térkép létrehozása, aminek ezen pont lesz a középpontja
    var map = L.map('map').setView(point, 13);

    // OpenStreetMap réteg létrehozása
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Jelölő létrehozása
    var marker = L.marker(point, {draggable:'true'}).addTo(map);

    // Jelölő mozgatása után
    marker.on('dragend', function(event){

        // Térképjelölő lekérdezése
        var marker = event.target;

        // Új pozíció lekérdezése
        var position = marker.getLatLng();

        // Szélesség és hosszúság lekérdezése és kerekítése
        var latitude = position.lat;
        var longitude = position.lng;

        // Térkép és a hozzá kapcsolódó mezők módosítása
		changeMap(latitude, longitude);
        
      });

      // Koordináta keresése cím alapján
      $("#google").on("click", function() {

        address = $("input[name='address']").val();
    
        // Google Térképnek a cím elküldése
		var googleAPI = "https://maps.googleapis.com/maps/api/geocode/json?";
		$.ajax(googleAPI, {
            data: {
                address: address,
                sensor: "false",
                key: "AIzaSyDsDnKkPmP5LxA_CL0-d2WiywXjZPiMPKw"
            },
            headers: null,
            dataType: "json",
		    success: function(data) {

                // Koordináták lekérdezése a válaszból
                var latitude = data.results[0].geometry.location.lat;
                var longitude = data.results[0].geometry.location.lng;

                // Térkép és a hozzá kapcsolódó mezők módosítása
                changeMap(latitude, longitude);
            }
		});
    });

    // Térkép és a hozzá kapcsolódó mezők módosítása
    function changeMap(latitude, longitude) {

        // Kerekítés
        latitude = latitude.toFixed(4);
        longitude = longitude.toFixed(4);

        // Beviteli mezők módosítása
        $("input[name='latitude']").val(latitude);
        $("input[name='longitude']").val(longitude);

        // Új pont létrehozása
        var point = L.latLng(latitude, longitude); 

        // Jelölő áthelyezése
        marker.setLatLng(point,{draggable:'true'});

        // Térkép mozgatása erre a pontra
        map.panTo(point);

    }

    // Térképes hiba javítása
    $(".nav-tabs .nav-link").on("click", function() {
        setTimeout(function() {
            map.invalidateSize();
        }, 500);
    });

});