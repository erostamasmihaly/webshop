$(function () {

    // Feltöltési hiba szöveg helye
    const upload_error = document.querySelector("#upload-error");

    // Ingatlan azonosító lekérdezése - vagy ha 0, akkor az ideiglenes random azonosító
    const product_id = document.querySelector("#product_id").value;

    // Képek betöltése
    refreshImages();

    // Képek feltöltése
    document.querySelector("#upload").addEventListener("click", function() {
        upload_images();
    });

    // Sorrend mentése
    document.querySelector("#sequence").addEventListener("click", function() {
        
        // Képek frissítése
        saveSequence();
    });

    // Sorbarendezés engedélyezése
    $(".sortable").sortable({
        cursor: "move"
    });

    // Sorrend mentése
    function saveSequence() {

        // Képeket tartalmazó tömb létrehozása
        images_array = [];
            
        // Végigmenni minden egyes képen
        [...document.querySelectorAll(".image")].map(element => {
                
            // Aktuális kép azonosítójának lekérdezése
            image_id = element.getAttribute("image_id");

            // Kép behelyezése a tömbbe
            images_array.push(image_id);
        });

        // JSON létrehozása tömbből
        images = JSON.stringify(images_array);

        // Átküldendő értékek összegyűjtése
		body = JSON.stringify({
			product_id: product_id,
            images: images
		});

        // Kérés küldése a szerver felé
        fetch("/seller/product/image/sequence", {
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

            // Ha nem OK=1 válasz érkezett, akkor hiba volt
            if (data.OK!=1) {

                // Hiba jelzése a felhasználónak
                upload_error.classList.remove("d-none");
                upload_error.innerHTML = "Hiba történt sorrend módosítása során!";

                // Hibaszöveg megjelenítése a consolon
                console.log(data);

            } else {

                alert("Fényképek új sorrendje sikeresen elmentésre került!");
            }
        
        })
        .catch(error => {

            // Hiba jelzése a felhasználónak
            upload_error.classList.remove("d-none");
            upload_error.innerHTML = "Hiba történt kép törlése során!";

            // Hibaszöveg megjelenítése a consolon
            console.log(error);
        });
    }

    // Képek lekérdezésse
    function refreshImages() {

        // Hibaüzenet elrejtése
        upload_error?.classList.add("d-none");

        // Átküldendő értékek összegyűjtése
		body = JSON.stringify({
			product_id: product_id
		});

		// Kérés küldése a szerver felé
		fetch("/seller/product/image/list", {
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

                //// Ha sikeres volt a lekérdezése
                
                // Könyvtár lekérdezése
                dir = data.dir;

                // Előző képek törlése
                document.querySelector("#gallery").innerHTML = null;

                // Végigmenni minden egyes képen
                [...Object.values(data.images)].map(value => {

                    // Megnézni, hogy vezérképről van-e szó
                    main_image = (value.is_main==1) ? "text-success" : "text-secondary";

                    // Kép elhelyezése
                    document.querySelector("#gallery").innerHTML += "<li class='col-sm-3'><div class='image' image_id='"+value.id+"'><image src='"+dir+"/thumb/"+value.filename+"' alt='"+value.filename+"' title='"+value.filename+"' class='mb-3 img-fluid w-90 object-fit-cover h-100'><div class='float-end'><div class='main' image_id='"+value.id+"'><i class='fa-sharp fa-solid fa-thumbtack "+main_image+"'></i></div><div class='delete' image_id='"+value.id+"'><i class='fa-solid fa-trash text-danger'></i></div></div></div></li>";
                });
    
            } else {

                //// Ha nem volt sikeres a lekérdezése
                // Hiba jelzése a felhasználónak
                upload_error.classList.remove("d-none");
                upload_error.innerHTML = "Hiba történt a képek lekérdezése során!";

                // Hibaszöveg megjelenítése a consolon
                console.log(data);
                
            } 

		})
		.catch(error => {

			// Hiba jelzése a felhasználónak
            upload_error.classList.remove("d-none");
            upload_error.innerHTML = "Hiba történt a képek lekérdezése során!";

            // Hibaszöveg megjelenítése a consolon
            console.log(error);
		});

    }

    // Képműveletek
    document.addEventListener("click", function(e){

        // Vezérkép kiválasztása
        const main_click = e.target.closest(".main");
        if(main_click) {
            
            // Felugró ablak megjelenítése
            is_main = confirm("Biztos, hogy ezt a képet szeretné vezérképnek beállítani?");
            
            // Ha módosítani kell a vezérképet
            if (is_main) {

                // Aktuális kép azonosítójának lekérdezése
                image_id = main_click.getAttribute("image_id");

                // Átküldendő értékek összegyűjtése
                body = JSON.stringify({
                    product_id: product_id,
                    image_id: image_id
                });
                
                // Kérés küldése a szerver felé
                fetch("/seller/product/image/main", {
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

                    // Ha nem OK=1 válasz érkezett, akkor hiba volt
                    if (data.OK==1) {

                        // Képek frissítése
                        refreshImages();
                        
                    } else {

                        // Hiba jelzése a felhasználónak
                        upload_error.classList.remove("d-none");
                        upload_error.innerHTML = "Hiba történt a vezérkép módosítása során!";

                        // Hibaszöveg megjelenítése a consolon
                        console.log(data);
                    }
                
                })
                .catch(error => {

                    // Hiba jelzése a felhasználónak
                    upload_error.classList.remove("d-none");
                    upload_error.innerHTML = "Hiba történt a vezérkép módosítása során!";

                    // Hibaszöveg megjelenítése a consolon
                    console.log(error);
                });

            }
        }

        // Kép törlése
        const delete_click = e.target.closest(".delete");
        if(delete_click) {

            // Felugró ablak megjelenítése
            is_delete = confirm("Biztos, hogy törölni szeretné a képet?");
            
            // Ha törölni kell a képet
            if (is_delete) {
                
                // Aktuális kép azonosítójának lekérdezése
                image_id = delete_click.getAttribute("image_id"); 
                
                // Átküldendő értékek összegyűjtése
                body = JSON.stringify({
                    image_id: image_id
                });
                
                // Kérés küldése a szerver felé
                fetch("/seller/product/image/delete", {
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

                    // Ha nem OK=1 válasz érkezett, akkor hiba volt
                    if (data.OK!=1) {

                        // Hiba jelzése a felhasználónak
                        upload_error.classList.remove("d-none");
                        upload_error.innerHTML = "Hiba történt kép törlése során!";

                        // Hibaszöveg megjelenítése a consolon
                        console.log(data);

                    } else {

                        // Kép törlése a felületen
                        delete_click.closest("li").remove();
                    }
                })
                .catch(error => {

                    // Hiba jelzése a felhasználónak
                    upload_error.classList.remove("d-none");
                    upload_error.innerHTML = "Hiba történt kép törlése során!";

                    // Hibaszöveg megjelenítése a consolon
                    console.log(error);
                });

            }
        }

        // Jelenítse meg az értékelést
        const rating_show_click = e.target.closest(".rating_show");
        if(rating_show_click) {

            // Azonosító lekérdezése
            id = rating_show_click.getAttribute("rating_id");

            // Publikálás
            rating_moderation(id, 1);
        }

        // Rejtse el az értékelést
        const rating_hide_click = e.target.closest(".rating_hide");
        if(rating_hide_click) {       
            
            // Azonosító lekérdezése
            id = rating_hide_click.getAttribute("rating_id");

            // Elrejtés
            rating_moderation(id, 0);
        }

    });

    // Fényképek feltöltése
    function upload_images() {

        // Megnézni, hogy van-e fájl feltöltve        
        if(file.files[0] == undefined) {

            // Ha nincs, akkor hibaüzenet megjelenítése
            upload_error.classList.remove("d-none");
            upload_error.innerHTML = "Nincsenek képek megadva!";

        } else {

            // Adatok összegyűjtése
            var body = new FormData();
            body.append('product_id', product_id);                      
            for (i=0; i<file.files.length; i++) {
                body.append('images[]', file.files[i]);
            }
            
            // Kérés küldése a szerver felé
            fetch("/seller/product/image/upload", {
                body: body,
                method: "POST",
                cache: "no-cache",
                headers: {
                    "Accept": "application/json",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": document.querySelector("meta[name='csrf-token']").getAttribute("content")
                }
            }).then(response => response.text()).then(text => {
        
                // Válasz átalakítása JSON-ná
                data = JSON.parse(text);

                // Ha minden rendben volt
                if (data.OK == 1) {

                    // Képek frissítése
                    refreshImages();

                    // Fájl mező alapállapotba állítása
                    document.querySelector("#file").value = null;

                    // Hibaüzenet elrejtése
                    upload_error.classList.add("d-none");

                } else {

                    // Hiba jelzése a felhasználónak
                    upload_error.classList.remove("d-none");
                    upload_error.innerHTML = "Hiba történt a képek feltöltése során!";

                    // Hibaszöveg megjelenítése a consolon
                    console.log(data);

                }
            
            })
            .catch(error => {

                // Hiba jelzése a felhasználónak
                upload_error.classList.remove("d-none");
                upload_error.innerHTML = "Hiba történt a képek feltöltése során!";

                // Hibaszöveg megjelenítése a consolon
                console.log(error);
            });

        }

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
            url: "/seller/product/rating", // Elérhetőség
            data: { 
                "product_id": product_id // Termék azonosító megadása
            },
            type: "POST", // POST típusú kérés
            headers: { // CSRF token átküldése
                "X-CSRF-TOKEN": document.querySelector("meta[name='csrf-token']").getAttribute("content")
            }
        },
        // Oszlopok hozzárendelése
        columns: [
            { data: "user_name" },
            { data: "title" },
            { data: "stars" },
            { data: "body" },
            { data: "updated" },
            {   
                data: "moderated",
                "render": function ( data, type, row, meta ) {
                    if (data == 0) {
                        html = '<button type="button" class="btn btn-secondary m-1 rating_show" title="Publikálás" rating_id="'+row.id+'"><i class="fa-solid fa-eye"></i>';
                    } else {
                        html = '<button type="button" class="btn btn-primary m-1 rating_hide" title="Elrejtés" rating_id="'+row.id+'"><i class="fa-solid fa-eye-slash"></i>';
                    }
                    return html;
                }
            }
        ],
        processing: true,
        serverSide: false // Ez legyen FALSE, hogy az ajax.reload() működjön
    });

    // Értékelés moderálásának módosítása
    function rating_moderation(id, moderated) {
        
        // Adat összeállítás
        data = "id="+id+"&moderated="+moderated;


        // Átküldendő értékek összegyűjtése
        body = JSON.stringify({
            id: id,
            moderated: moderated
        });

        // Kérés küldése a szerver felé
        fetch("/seller/product/rating/moderation", {
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
            if (data.OK == 1) {
                    
                // Táblázat frissítése
                $("#ratings").DataTable().ajax.reload();

            }
        
        })
        .catch(error => {
            console.log(error);
        });
    }

    // Árazás
    $("#prices").DataTable({
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
            url: "/seller/product/price", // Elérhetőség
            data: { 
                "id": product_id // Termék azonosító megadása
            },
            type: "GET", // GET típusú kérés
            headers: { // CSRF token átküldése
                "X-CSRF-TOKEN": document.querySelector("meta[name='csrf-token']").getAttribute("content")
            }
        },
        // Oszlopok hozzárendelése
        columns: [
            { data: "size_name" },
            { data: "quantity" },
            { data: "netto_price" },
            { data: "vat" },
            { data: "brutto_price" },
            { data: "discount" },
            { data: "discount_price" },
        ],
        processing: true,
        serverSide: false // Ez legyen FALSE, hogy az ajax.reload() működjön
    });

    // Új árazás felvitele
    document.querySelector("#insert_price").addEventListener("click", function(){

        // Adatok lekérdezése
        size_id = document.querySelector("#size_id").value;
        price = document.querySelector("#price").value;
        price_check = document.querySelector("#price_check").checked;
        vat = document.querySelector("#vat").value;
        vat_check = document.querySelector("#vat_check").checked;
        discount = document.querySelector("#discount").value;
        discount_check = document.querySelector("#discount_check").checked;
        quantity = document.querySelector("#quantity").value;
        quantity_check = document.querySelector("#quantity_check").checked;

        // Átküldendő értékek összegyűjtése
		body = JSON.stringify({
			product_id: product_id,
            size_id: size_id,
            price: price,
            price_check: (price_check) ? 1 : 0,
            vat: vat,
            vat_check: (vat_check) ? 1 : 0,
            discount: discount,
            discount_check: (discount_check) ? 1 : 0,
            quantity: quantity,
            quantity_check: (quantity_check) ? 1 : 0
		});
		
		// Kérés küldése a szerver felé
        fetch("/seller/product/price/update", {
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

            // Módosítás checkbox-ok visszaállítása
            document.querySelector("#price_check").checked = false;
            document.querySelector("#vat_check").checked = false;
            document.querySelector("#discount_check").checked = false;
            document.querySelector("#quantity_check").checked = false;
    
            // Válasz átalakítása JSON-ná
            data = JSON.parse(text);

            if (data.OK == 1) {
                    
                // Ha minden rendben volt, akkor táblázat frissítése
                $("#prices").DataTable().ajax.reload();

                // Mezők visszaállítása
                document.querySelector("#price").value = 0;
                document.querySelector("#discount").value = 0;
                document.querySelector("#vat").value = 27;
                document.querySelector("#quantity").value = 0;

                // Jelezni, hogy sikeres volt a művelet
                document.querySelector("#success").classList.remove("d-none");
                document.querySelector("#error").classList.add("d-none");
                document.querySelector("#insert_price").classList.add("d-none");
                setTimeout(function(){
                    document.querySelector("#success").classList.add("d-none");
                    document.querySelector("#insert_price").classList.remove("d-none");
                },3000);

            } else {
               
                // Végigmenni minden egyes hibán
                document.querySelector("#error").innerHTML = "";
                [...Object.values(data.errors)].map(value => {
                    document.querySelector("#error").innerHTML += "<p>"+value+"</p>";
                });

                // Jelezni a hibákat 
                document.querySelector("#success").classList.add("d-none");
                document.querySelector("#error").classList.remove("d-none");
                document.querySelector("#insert_price").classList.add("d-none");
                setTimeout(function(){
                    document.querySelector("#error").classList.add("d-none");
                    document.querySelector("#insert_price").classList.remove("d-none");
                },3000);
            }
        
        })
        .catch(error => {
            console.log(error);
        });

    });
});