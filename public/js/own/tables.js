table = $("#datatable").DataTable({
	responsive: true, // Reszponzív
	language: { 
		url: "/js/own/hu.json"
	}, // Magyar nyelv
	lengthMenu: [10, 20, 30], // Oldalankénti találatok száma
	stateSave: true, // Visszatérés esetén az eredeti állapot megtartása
	stateDuration:-1, // Visszatérés eredeti állapotba új fül megnyitásakor
	order: [], // Betöltéskor még ne legyen sorrend alkalmazva
	initComplete: function(settings, json) {
		// Tábla megjelenítése
		document.querySelector("#datatable").classList.remove("d-none");
		document.querySelector("#datatable").classList.add("d-table");

		// Folyamatban szöveg törlése
		document.querySelector("#waiting").classList.add("d-none"); 
	}
});   