$(function () {
    
    // URL lekérdezése
    url = $("#url").val();

    // Kis idő után ezen URL betöltése
    setTimeout(function() {
        window.location.href = url;
    }, 3000);
    
});