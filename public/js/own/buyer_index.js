// Termékek és kategóriák lekérdezése
function get_products() {

	// SessionStorage-ba tárolt kategória lekérdezése
	var group_id = sessionStorage.getItem("group_id");

	// Új objektum létrehozása
	obj = new Object();

	// Szűrők felvitele ebbe az objektumba
	// !!! Select2 miatt jQuery alkalmazása !!!
	obj.shops = $("#filter_shop").val();
	obj.sizes = $("#filter_size").val();
	obj.genders = $("#filter_gender").val();
	obj.ages = $("#filter_age").val();

	// JSON létrehozása objektumból
	filter = JSON.stringify(obj);
	page = sessionStorage.getItem('page');
	if (page==undefined) {
		page = 0;
	}

	// Aktuális oldalszám mutatása
	document.querySelector("#current").innerHTML = parseInt(page)+1;

	// Kérés a szerver felé
	fetch("products?group_id="+group_id+"&filter="+filter+"&page="+page+"&limit=4", {
		method: "GET",
		cache: "no-cache"
	}).then(response => response.text()).then(text => {

		// Válasz átalakítása JSON-ná
		data = JSON.parse(text);
		
		// Megnézni, hogy minden rendben volt
		if (data.OK == 1) {

			//// Ha minden rendben volt
			// Lekérdezett termékcsoportok megjelenítése a Vissza gombbal együtt
			show_groups(data.groups, data.back_id);

			// Lekérdezett termékek megjelenítése
			show_products(data.products);
		} else {
			console.log(data);
		}
	})
	.catch(error => {
		console.log(error);
	});

}

// Ezen lekérdezés gyors lefuttatása
get_products();

// Termékcsoportok megjelenítése
function show_groups(groups, back_id) {

	// Termékcsoprotoknak kijelölt terület tisztítása
	document.querySelector("#groups").innerHTML = "";

	// Végigmenni minden egyes termékcsoporton és megjeleníteni őket a kijelölt területen
	groups.forEach(function(group) {
		document.querySelector("#groups").innerHTML += '<div class="col-lg-3 col-sm-4 col-6 groups mb-1" group_id="'+group.id+'"><button class="badge bg-primary w-100 p-2">'+group.name+'</button></div>';
	});

	// Vissza gomb behelyezése
	document.querySelector("#groups").innerHTML +='<div class="col-lg-3 col-sm-4 col-6 groups mb-2" group_id="'+back_id+'"><button class="badge bg-secondary w-100 p-2">Vissza</button></div>';
}

// Kategória kiválasztása
document.addEventListener("click", function(e){

	// Ha kategóriára lett kattitnva
	const groups = e.target.closest(".groups");
	if(groups){

		// Kijelölt kategória ID lekérdezése
		group_id = groups.getAttribute("group_id");

		// Ezen ID elmentése
		sessionStorage.setItem('group_id', group_id);

		// Visszatérés az első oldalra
		sessionStorage.setItem('page',0);

		// Termékek és kategóriák újbóli lekérdezése
		get_products();
	}
});

// Termékek megjelenítése
function show_products(products) {

	// Termékeknek kijelölt terület tisztítása
	document.querySelector("#products").innerHTML = "";

	// Végigmenni minden egyes terméken
	products.forEach(function(product) {

		// HTML elem létrehozása
		html='<div class="col-lg-3 col-sm-4 col-6 text-center" group_id="'+product.group_id+'" age_id="'+product.age_id+'" gender_id="'+product.gender_id+'" shop_id="'+product.shop_id+'"><div class="card p-2 mb-2"><a href="/product/'+product.id+'" class="fw-bold">'+product.name+'<br><img src="'+product.image+'" class="img-fluid">';

		if (product.discount>0) {
			// Ha leárazott, akkor kiemelt árcédulával és a leárazás nagyságának feltűntetésével
			html+='<span class="badge bg-success p-2">'+product.discount_price+' <span class="badge bg-danger">+'+product.discount+' %</span></span>';
		} else {
			// Ha nem leárazott, akkor normál megjelenítés
			html+='<span class="badge bg-primary p-2">'+product.discount_price+'</span>';
		}

		// HTML elem lezárása
		html+='</a></div></div>';

		// HTML elem megjelenítése a termékeknek kijelölt helyen
		document.querySelector("#products").innerHTML += html;
	});
}

// Alapállapot visszaállítása
document.querySelector("#filter_default").addEventListener("click", function(){

	// Minden szűrő esetén a legleső lehetőség kiválasztása
	document.querySelector("#filter_shop").value = null;
	document.querySelector("#filter_shop").trigger('change');
	document.querySelector("#filter_size").value = null;
	document.querySelector("#filter_size").trigger('change');
	document.querySelector("#filter_gender").value = null;
	document.querySelector("#filter_gender").trigger('change');
	document.querySelector("#filter_age").value = null;
	document.querySelector("#filter_age").trigger('change');

	// Visszatérés az első oldalra
	sessionStorage.setItem('page',0);

	// Termékek lekérdezése
	get_products();

});

// Szűrő módosítása után - Mivel Select2-s mező, így az addEventListener nem működik!
$(".filter").on("change", function(){

	// Visszatérés az első oldalra
	sessionStorage.setItem('page',0);

	// Termékek lekérdezése
	get_products();
});

// Vissza
document.querySelector("#back").addEventListener("click", function(){

	// Aktuális oldalszám lekérdezése
	page = sessionStorage.getItem(page);
	
	// Ezen érték csökkentése 1-el
	page--; 

	// Ha kisebb, mint 0, akkor 0 lesz
	if (page<0) {
		page=0;
	}

	// Ezen érték elmentése
	sessionStorage.setItem("page", page);

	// Termékek lekérdezése
	get_products();
});

// Előre
document.querySelector("#next").addEventListener("click", function(){

	// Aktuális oldalszám lekérdezése
	page = sessionStorage.getItem(page);
	
	// Ezen érték csökkentése 1-el
	page++; 

	// Ezen érték elmentése
	sessionStorage.setItem("page", page);

	// Termékek lekérdezése
	get_products();
});
