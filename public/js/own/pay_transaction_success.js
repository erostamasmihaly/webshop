// URL lekérdezése
url = document.querySelector("#url").value;

// Kis idő után ezen URL betöltése
setTimeout(function() {
    window.location.href = url;
}, 3000);