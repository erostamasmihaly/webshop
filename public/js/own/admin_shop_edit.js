// LEAFLET miatt DOMContentLoaded megvárása!
document.addEventListener("DOMContentLoaded", function(){

    // GPS szélesség és hosszúság lekérdezése
    var latitude = document.querySelector("#latitude").value;
    var longitude = document.querySelector("#longitude").value;

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
    document.querySelector("#google").addEventListener("click", function() {

        address = document.querySelector("#address").value;

        // Átküldendő értékek összegyűjtése
        data = "address="+address+"&sendor=false&key=AIzaSyDsDnKkPmP5LxA_CL0-d2WiywXjZPiMPKw";
		
		// Kérés küldése a szerver felé
        fetch("https://maps.googleapis.com/maps/api/geocode/json?"+data, {
            method: "GET",
            cache: "no-cache"
        }).then(response => response.text()).then(text => {
    
            // Válasz átalakítása JSON-ná
            data = JSON.parse(text);

            // Koordináták lekérdezése a válaszból
            var latitude = data.results[0].geometry.location.lat;
            var longitude = data.results[0].geometry.location.lng;

            // Térkép és a hozzá kapcsolódó mezők módosítása
            changeMap(latitude, longitude);
        
        })
        .catch(error => {
            console.log(error);
        });

    });

    // Térkép és a hozzá kapcsolódó mezők módosítása
    function changeMap(latitude, longitude) {

        // Kerekítés
        latitude = latitude.toFixed(4);
        longitude = longitude.toFixed(4);

        // Beviteli mezők módosítása
        document.querySelector("#latitude").value = latitude;
        document.querySelector("#longitude").value = longitude;

        // Új pont létrehozása
        var point = L.latLng(latitude, longitude); 

        // Jelölő áthelyezése
        marker.setLatLng(point,{draggable:'true'});

        // Térkép mozgatása erre a pontra
        map.panTo(point);

    }

    // Térképes hiba javítása
    [...document.querySelectorAll(".nav-tabs .nav-link")].map(element => { 
        element.addEventListener("click", function() {
            setTimeout(function() {
                map.invalidateSize();
            }, 500);
        });
    });

});