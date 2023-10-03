$(function () {
    
    // Koordináták lekérdezése
    latitude = document.querySelector("#latitude").value;
    longitude = document.querySelector("#longitude").value;
    
    // Leaflet pont létrehozása ezen két koordinátából
    var point = L.latLng(latitude, longitude);

    // Térkép létrehozása, aminek ezen pont lesz a középpontja
    var map = L.map('map').setView(point, 15);

    // OpenStreetMap réteg létrehozása
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Jelölő létrehozása
    var marker = L.marker(point).addTo(map);
});