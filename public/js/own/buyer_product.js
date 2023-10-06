// Termék azonosító lekérdezése
product_id = document.querySelector("#product_id").value;

// ColorBox beállítása
$(".colorbox").colorbox({
	maxHeight: "80%", // Max 80 % magasság
	opacity: 0.4, // 40%-os átlátszóság
	fixed: true // Fix elhelyezkedés
});

// Kosárba helyezés
var cart_add = document.querySelector("#cart_add");
if (cart_add!=null) {
	cart_add.addEventListener("click", function() {

		// Adatok lekérdezése
		quantity = document.querySelector("#quantity").value;
		size_id = document.querySelector("#size").value;
		size_element = document.querySelector("#size");
		max = size_element.options[size_element.selectedIndex].getAttribute("max");

		// Megnézni, hogy van-e mennyiség megadva
		if (quantity > 0) {

			response = true;

			if (quantity > max) {
				response = confirm("A jelenleg elérhető mennyiségnél több lett megadva. Fizetéskor csak azon mennyiség lesz kifizetve, amennyi épp a fizetés során volt elérhető! Folytatja tovább a kosárba helyezést?")
			}

			if (response) {

				// Átküldendő értékek összegyűjtése
				body = JSON.stringify({
					product_id: product_id,
					quantity: quantity,
					size_id: size_id
				});

				// Kérés küldése a szerver felé
				fetch("/buyer/cart/add", {
					body: body,
					method: "POST",
					cache: "no-cache",
					headers: {
						"Content-Type": "application/json",
						"Accept": "application/json",
						"X-Requested-With": "XMLHttpRequest",
						"X-CSRF-TOKEN": document.querySelector("meta[name='csrf-token']").getAttribute("content")
					}
				}).then(response => response.text()).then(text => {
			
					// Válasz átalakítása JSON-ná
					data = JSON.parse(text);
			
					if (data.OK==1) {

						// Ha sikeres volt, akkor a hozzá tartozó üzenet megjelenítése
						document.querySelector("#cart_success").classList.remove("d-none");
						document.querySelector("#cart_success").innerHTML = "Sikeres művelet!";

						// Visszaállítani 0-ra a mező értékét
						document.querySelector("#quantity").value = 0;

					} else {

						// Ha nem sikerült, akkor a hibaüzenet megjelenítése
						document.querySelector("#cart_error").classList.remove("d-none");
						document.querySelector("#cart_error").innerHTML = "Sikertelen művelet!";

					}

					// Kosárba rakás gomb elrejtése
					cart_add_hide();
				})
				.catch(error => {

					// Ha hiba volt, akkor a hibaüzenet megjelenítése
					document.querySelector("#cart_error").classList.remove("d-none");document.querySelector("#cart_error").innerHTML = "Sikertelen művelet!";

					// Kosárba rakás gomb elrejtése
					cart_add_hide();
				});

			}
		} else {

			// Ha hiba volt, akkor a hibaüzenet megjelenítése
			document.querySelector("#cart_error").classList.remove("d-none");
			document.querySelector("#cart_error").innerHTML = "Nincs mennyiség megadva!";

			// Kosárba rakás gomb elrejtése
			cart_add_hide();

		}

	});
} 

// Kosárba rakás gomb elrejtése
function cart_add_hide() {

	// Kosárba rakás gomb elrejtése
	document.querySelector("#cart_add").classList.add("d-none");

	// 5 másodperc után
	setTimeout(function() {

		// Kosárral kapcsolatos üzenetek elrejtése
		document.querySelector("#cart_success").classList.add("d-none");
		document.querySelector("#cart_error").classList.add("d-none");

		// Kosárba rakás gomb visszahozása
		document.querySelector("#cart_add").classList.remove("d-none");

	}, 5000);
}

// Kedvelés
document.querySelector("#fav")?.addEventListener("click", function() {
	send_favourites(0);
});

// Kedvelés visszavonása
document.querySelector("#unfav")?.addEventListener("click", function() {
	send_favourites(1);
});

// Változás elküldése a kedveléssel kapcsolatban
function send_favourites(state) {

	// Átküldendő értékek összegyűjtése
	body = JSON.stringify({
		product_id: product_id,
		state: state
	});

	// Kérés küldése a szerver felé
	fetch("/buyer/favourite/change", {
		body: body,
		method: "POST",
		cache: "no-cache",
		headers: {
			"Content-Type": "application/json",
			"Accept": "application/json",
			"X-Requested-With": "XMLHttpRequest",
			"X-CSRF-TOKEN": document.querySelector("meta[name='csrf-token']").getAttribute("content")
		}
	}).then(response => response.text()).then(text => {

		// Válasz átalakítása JSON-ná
		data = JSON.parse(text);

		// Ha minden rendben volt
		if (data.OK==1) {

			if (state==0) {
				
				//// Ha kedvelés volt
				// Kedvelés gomb elrejtése
				document.querySelector("#fav").classList.add("d-none");

				// Kedvelés visszavonása gomb megjelenítése
				document.querySelector("#unfav").classList.remove("d-none");

			} else {

				//// Ha kedvelés visszavonása volt
				// Kedvelés visszavonása gomb elrejtése
				document.querySelector("#unfav").classList.add("d-none");

				// Kedvelés gomb megjelenítése
				document.querySelector("#fav").classList.remove("d-none");

			}

			// Kedvelések számának módosítása
			document.querySelector("#fav_total").innerHTML = data.total;
		}
	})
	.catch(error => {
		console.log(error);
	});
}

// Értékelések
$("#ratings").DataTable({
	responsive: true, // Reszponzív
	language: { 
		url: "/js/own/hu.json"
	}, // Magyar nyelv
	lengthMenu: [10, 20, 30], // Oldalankénti találatok száma
	stateSave: true, // Visszatérés esetén az eredeti állapot megtartása
	stateDuration:-1, // Visszatérés eredeti állapotba új fül megnyitásakor
	order:[],
	// AJAX forrás megadása
	ajax: {
		url: "/rating", // Elérhetőség
		data: { 
			"product_id": product_id // Termék azonosító megadása
		},
		type: "POST", // POST típusú kérés
		error: function(error) {
			console.log(error);
		},
		headers: { // CSRF token átküldése
			"X-CSRF-TOKEN": document.querySelector("meta[name='csrf-token']").getAttribute("content")
		}
	},
	initComplete: function(settings, json) {
		document.querySelector("#title_fa_stars").innerHTML = json.others.fa_stars;
		document.querySelector("#title_total").innerHTML = json.others.total;
	},
	// Oszlopok hozzárendelése
	columns: [
		{ data: "user_name" },
		{ data: "title" },
		{ data: "fa_stars" },
		{ data: "body" },
		{ data: "updated" },
	],
	processing: true,
	serverSide: false // Ez legyen FALSE, hogy az ajax.reload() működjön
});

// Értékelés elküldése
var send_rating = document.querySelector("#send_rating");
if (send_rating != null) {
	send_rating.addEventListener("click", function() {

		user_id = document.querySelector("#user_id").value;
		title = document.querySelector("#title").value;
		body = tinymce.get("body").getContent();
		stars = document.querySelector("#stars").value;

		// Átküldendő értékek összegyűjtése
		body = JSON.stringify({
			product_id: product_id,
			user_id: user_id,
			title: title,
			body: body,
			stars: stars
		});

		// Kérés küldése a szerver felé
		fetch("/buyer/rating/change", {
			body: body,
			method: "POST",
			cache: "no-cache",
			headers: {
				"Content-Type": "application/json",
				"Accept": "application/json",
				"X-Requested-With": "XMLHttpRequest",
				"X-CSRF-TOKEN": document.querySelector("meta[name='csrf-token']").getAttribute("content")
			}
		}).then(response => response.text()).then(text => {
	
			// Válasz átalakítása JSON-ná
			data = JSON.parse(text);

			if (data.OK==1) {
					
				//// Ha minden rendben volt
				// Értékelések frissítése
				$("#ratings").DataTable().ajax.reload();

				// Mezők értékeinek törlése
				document.querySelector("#title").value = "";
				document.querySelector("#body").value = "";

				// Sikeresség üzenet megjelenítése
				document.querySelector("#rating_success").classList.remove("d-none");

			} else {

				// Sikertelenség üzenet megjelenítése
				document.querySelector("#rating_error").classList.remove("d-none");                    

			}

			// Értékelés gomb elrejtése
			send_rating_hide();

		})
		.catch(error => {

			// Sikertelenség üzenet megjelenítése
			document.querySelector("#error").classList.remove("d-none");

			// Értékelés gomb elrejtése
			send_rating_hide();
		});

	});
}
	

// Értékelés gomb elrejtése
function send_rating_hide() {

	// Értékelés gomb elrejtése
	document.querySelector("#send_rating").classList.add("d-none");

	// 5 másodperc után
	setTimeout(function() {

		// Értékeléssek kapcsolatos üzenetek elrejtése
		document.querySelector("#rating_success").classList.add("d-none");
		document.querySelector("#rating_error").classList.add("d-none");

		// Értékelés gomb visszahozása
		document.querySelector("#send_rating").classList.remove("d-none");

	}, 5000);
}