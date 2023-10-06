// Plusz gomb megnyomása
[...document.querySelectorAll(".plus")].map(element => element.addEventListener("click", function() {
	
	// Termék azonosító és méret azonosító lekérdezése
	product_id = this.closest(".product").getAttribute("product_id");
	size_id = this.closest(".product").getAttribute("size_id");
	
	// Módosítás elküldése
	send_change(product_id, size_id, 1);
	   
}));

// Minusz gomb megnyomása
[...document.querySelectorAll(".minus")].map(element => element.addEventListener("click", function() {
	
	// Termék azonosító és méret azonosító lekérdezése
	product_id = this.closest(".product").getAttribute("product_id");
	size_id = this.closest(".product").getAttribute("size_id");

	// Mennyiség lekérdezése
	quantity = this.closest(".product").querySelector(".quantity").innerHTML;

	// Ha még nem 0
	if (quantity > 0) {

		// Módosítás elküldése
		send_change(product_id, size_id, -1);
	}
}));

// Törlés gomb megnyomása
[...document.querySelectorAll(".delete")].map(element => element.addEventListener("click", function() {
	
	// Termék azonosító és méret azonosító lekérdezése
	product_id = this.closest(".product").getAttribute("product_id");
	size_id = this.closest(".product").getAttribute("size_id");

	// Mennyiség lekérdezése
	quantity = this.closest(".product").querySelector(".quantity").innerHTML;

	// Módosítás elküldése
	send_change(product_id, size_id, -1*quantity);
			
}));

// Módosítás elküldése
function send_change(product_id, size_id, quantity) {

	// Mennyiség lekérdezése
	quantity_old = document.querySelectorAll(".product[product_id='"+product_id+"'][size_id='"+size_id+"'] .quantity")[0].innerHTML;

	// Átküldendő értékek összegyűjtése
	body = JSON.stringify({
		product_id: product_id,
		size_id: size_id,
		quantity: quantity
	});
	
	// Kérés küldése a szerver felé
	fetch("/buyer/cart/change", {
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

			// Módosult mennyiség megállapítása
			new_quantity = parseInt(quantity) + parseInt(quantity_old);

			// Megnézni, hogy van-e még belőle
			if (new_quantity > 0) {

				// Ha még mindig van belőle, akkor mennyiség módosítása
				document.querySelectorAll(".product[product_id='"+product_id+"'][size_id='"+size_id+"'] .quantity")[0].innerHTML = new_quantity;

			} else {

				// Adott sor törlése és a táblázat frissítése
				$(".datatable").DataTable().rows(".product[product_id='"+product_id+"'][size_id='"+size_id+"']").remove().draw();

			}

			// Megnézni, hogy mekkora a fizetendő összeg 
			if (data.total!="0 Ft") {

				// Fizetendő összeg frissítése, ha nem 0 Ft
				document.querySelector("#total").innerHTML = data.total;
			} else {

				// Felület frissítése, ha 0 Ft
				window.location.href = window.location.href;
			}
			

		} else {

			// Ha rendellenes válasz jött
			console.log(data);
		}
	
	})
	.catch(error => {

		// Ha valami hiba történt
		console.log(error);
	});
	
}