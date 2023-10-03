$(function () {
       
    table = $(".datatable").DataTable({
        responsive: true, // Reszponzív
        language: { 
            url: "/js/own/hu.json"
        }, // Magyar nyelv
        lengthMenu: [10, 20, 30], // Oldalankénti találatok száma
        stateSave: true, // Visszatérés esetén az eredeti állapot megtartása
        stateDuration:-1, // Visszatérés eredeti állapotba új fül megnyitásakor
        order: [], // Betöltéskor még ne legyen sorrend alkalmazva
        initComplete: function(settings, json) {
            datatable = document.querySelectorAll(".datatable");
            for (var i=0; i<datatable.length; i++) {
                datatable[i].classList.remove("d-none");
                datatable[i].classList.add("d-table");
            }
            document.querySelector("#waiting").classList.add("d-none"); // Folyamatban szöveg törlése
        }
    });   
});