$(function () {

    // Ingatlan azonosító lekérdezése - vagy ha 0, akkor az ideiglenes random azonosító
    product_id = (document.querySelector("#product_id").val() == 0) ? document.querySelector("#temporary_id").val() : document.querySelector("#product_id").value;

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
    document.querySelectorAll("."sortable").sortable({
        cursor: "move"
    });

    // Sorrend mentése
    function saveSequence() {

        // Képeket tartalmazó tömb létrehozása
        images_array = [];
            
        // Végigmenni minden egyes képen
        document.querySelectorAll("."image").each(function(e) {
                
            // Aktuális kép azonosítójának lekérdezése
            image_id = this.getAttribute("image_id");

            // Kép behelyezése a tömbbe
            images_array.push(image_id);
        });

        // JSON létrehozása tömbből
        images = JSON.stringify(images_array);

        // Új sorrend átküldése a szervernek
        $.ajax({
            dataType: "json",
            url: "/seller/product/image/sequence",
            data: "images="+images+"&product_id="+product_id,
            type: "POST",
            cache: false,
            success: function (data) {

                // Ha nem OK=1 válasz érkezett, akkor hiba volt
                if (data.OK!=1) {

                    // Hiba jelzése a felhasználónak
                    document.querySelector("#gallery-error").classList.remove("d-none").innerHTML("Hiba történt sorrend módosítása során!");

                    // Hibaszöveg megjelenítése a consolon
                    console.log(data);

                } else {

                    alert("Fényképek új sorrendje sikeresen elmentésre került!");
                }
            },
            error: function (error) {
                
                // Hiba jelzése a felhasználónak
                document.querySelector("#gallery-error").classList.remove("d-none").innerHTML("Hiba történt kép törlése során!");

                // Hibaszöveg megjelenítése a consolon
                console.log(error);
            }

        });
    }


    // Képek lekérdezésse
    function refreshImages() {

        // Hibaüzenet elrejtése
        document.querySelector("#gallery-error").classList.add("d-none");

        // Képek lekérdezése
        $.ajax({
            dataType: "json",
            url: "/seller/product/image/list",
            data: "product_id="+product_id,
            type: "POST",
            cache: false,
            success: function (data) {

                if (data.OK==1) {

                    //// Ha sikeres volt a lekérdezése
                    
                    // Könyvtár lekérdezése
                    dir = data.dir;

                    // Előző képek törlése
                    document.querySelector("#gallery").html(null);

                    // Végigmenni minden egyes képen
                    $.each(data.images, function (key, val) {

                        // Megnézni, hogy vezérképről van-e szó
                        main_image = (val.is_main==1) ? "text-success" : "text-secondary";

                        // Kép elhelyezése
                        document.querySelector("#gallery").append("<li class='col-sm-3'><div class='image' image_id='"+val.id+"'><image src='"+dir+"/thumb/"+val.filename+"' alt='"+val.filename+"' title='"+val.filename+"' class='mb-3 img-fluid w-90 object-fit-cover h-100'><div class='float-end'><div class='main' image_id='"+val.id+"'><i class='fa-sharp fa-solid fa-thumbtack "+main_image+"'></i></div><div class='delete' image_id='"+val.id+"'><i class='fa-solid fa-trash text-danger'></i></div></div></div></li>");
                    });
        
                } else {

                    //// Ha nem volt sikeres a lekérdezése
                    // Hiba jelzése a felhasználónak
                    document.querySelector("#gallery-error").classList.remove("d-none").innerHTML("Hiba történt a képek lekérdezése során!");

                    // Hibaszöveg megjelenítése a consolon
                    console.log(data);
                    
                }                    
            },
            error: function (error) {
                
                // Hiba jelzése a felhasználónak
                document.querySelector("#gallery-error").classList.remove("d-none").innerHTML("Hiba történt a képek lekérdezése során!");

                // Hibaszöveg megjelenítése a consolon
                console.log(error);
            }
        });

    }

    // Vezérkép kiválasztása
    $("body").addEventListener("click", ".main", function(){

        // Felugró ablak megjelenítése
        is_main = confirm("Biztos, hogy ezt a képet szeretné vezérképnek beállítani?");
        
        // Ha módosítani kell a vezérképet
        if (is_main) {

            // Aktuális kép azonosítójának lekérdezése
            image_id = this.getAttribute("image_id");

            // Új vezérkép átküldése a szervernek
            $.ajax({
                dataType: "json",
                url: "/seller/product/image/main",
                data: "image_id="+image_id+"&product_id="+product_id,
                type: "POST",
                cache: false,
                success: function (data) {

                    // Ha nem OK=1 válasz érkezett, akkor hiba volt
                    if (data.OK==1) {

                        // Képek frissítése
                        refreshImages();
                        
                    } else {

                        // Hiba jelzése a felhasználónak
                        document.querySelector("#gallery-error").classList.remove("d-none").innerHTML("Hiba történt a vezérkép módosítása során!");

                        // Hibaszöveg megjelenítése a consolon
                        console.log(data);
                    }
                },
                error: function(error) {
                    
                    // Hiba jelzése a felhasználónak
                    document.querySelector("#gallery-error").classList.remove("d-none").innerHTML("Hiba történt a vezérkép módosítása során!");

                    // Hibaszöveg megjelenítése a consolon
                    console.log(error);
                }
		    });
        }
    });

    // Kép törlése
    $("body").addEventListener("click", ".delete", function(){

        // Felugró ablak megjelenítése
        is_delete = confirm("Biztos, hogy törölni szeretné a képet?");
        
        // Ha törölni kell a képet
        if (is_delete) {
            
            // Aktuális kép azonosítójának lekérdezése
            image_id = this.getAttribute("image_id");            

            // Törlendő kép átküldése
            $.ajax({
                dataType: "json",
                url: "/seller/product/image/delete",
                data: "image_id="+image_id,
                type: "POST",
                cache: false,
                success: function (data) {

                    // Ha nem OK=1 válasz érkezett, akkor hiba volt
                    if (data.OK!=1) {

                        // Hiba jelzése a felhasználónak
                        document.querySelector("#gallery-error").classList.remove("d-none").innerHTML("Hiba történt kép törlése során!");

                        // Hibaszöveg megjelenítése a consolon
                        console.log(data);

                    } else {

                        // Kép törlése a felületen
                        document.querySelectorAll("."image[image_id="+image_id+"]").parent("li").remove();
                    }
                    
                },
                error: function (error) {

                    // Hiba jelzése a felhasználónak
                    document.querySelector("#gallery-error").classList.remove("d-none").innerHTML("Hiba történt kép törlése során!");

                    // Hibaszöveg megjelenítése a consolon
                    console.log(error);

                }
            });
        }
        
    });

    // Fényképek feltöltése
    function upload_images() {

        // Megnézni, hogy van-e fájl feltöltve        
        if(file.files[0] == undefined) {

            // Ha nincs, akkor hibaüzenet megjelenítése
            document.querySelector("#upload-error").classList.remove("d-none").innerHTML("Nincsenek képek megadva!");

        } else {

            // Adatok összegyűjtése
            var data = new FormData();
            data.append('product_id', product_id);                        
            for (i=0; i<file.files.length; i++) {
                data.append('images[]', file.files[i]);
            }

            // Adatok elküldése a szervernek
            $.ajax({
                dataType: "json",
                url: "/seller/product/image/upload",
                type: "POST",
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {

                    if (data.OK == 1) {

                        // Képek frissítése
                        refreshImages();

                        // Fájl mező alapállapotba állítása
                        document.querySelector("#file").val(null);

                        // Hibaüzenet elrejtése
                        document.querySelector("#upload-error").classList.add("d-none");

                    } else {

                        // Hiba jelzése a felhasználónak
                        document.querySelector("#upload-error").classList.remove("d-none").innerHTML("Hiba történt a képek feltöltése során!");

                        // Hibaszöveg megjelenítése a consolon
                        console.log(data);

                    }
                },
                error: function (error) {
                    
                    // Hiba jelzése a felhasználónak
                    document.querySelector("#upload-error").classList.remove("d-none").innerHTML("Hiba történt a képek feltöltése során!");

                    // Hibaszöveg megjelenítése a consolon
                    console.log(error);

                }
            });
        }

    } 

    // Értékelések
    document.querySelector("#ratings").DataTable({
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
            type: "POST" // POST típusú kérés
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

    // Jelenítse meg az értékelést
    $("body").addEventListener("click", ".rating_show", function() {

        // Azonosító lekérdezése
        id = this.getAttribute("rating_id");

        // Publikálás
        rating_moderation(id, 1);
    });

    // Rejtse el az értékelést
    $("body").addEventListener("click", ".rating_hide", function() {
        
        // Azonosító lekérdezése
        id = this.getAttribute("rating_id");

        // Elrejtés
        rating_moderation(id, 0);
    });

    // Értékelés moderálásának módosítása
    function rating_moderation(id, moderated) {
        
        // Adat összeállítás
        data = "id="+id+"&moderated="+moderated;

        // Adatok elküldése a szervernek
        $.ajax({
            dataType: "json",
            url: "/seller/product/rating/moderation",
            type: "POST",
            data: data,
            cache: false,
            success: function (data) {

                if (data.OK == 1) {
                    
                    // Ha minden rendben volt, akkor táblázat frissítése
                    document.querySelector("#ratings").DataTable().ajax.reload();

                }
            },
            error: function(error) {
                console.log(error);
            }
        });
    }

    // Árazás
    document.querySelector("#prices").DataTable({
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
            type: "GET" // GET típusú kérés
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
        vat = document.querySelector("#vat").value;
        discount = document.querySelector("#discount").value;
        quantity = document.querySelector("#quantity").value;

        // Adat összeállítás
        data = "product_id="+product_id+"&size_id="+size_id+"&price="+price+"&vat="+vat+"&discount="+discount+"&quantity="+quantity;

        // Adatok elküldése a szervernek
        $.ajax({
            dataType: "json",
            url: "/seller/product/price",
            type: "POST",
            data: data,
            cache: false,
            success: function (data) {

                if (data.OK == 1) {
                    
                    // Ha minden rendben volt, akkor táblázat frissítése
                    document.querySelector("#prices").DataTable().ajax.reload();

                    // Mezők visszaállítása
                    document.querySelector("#price").val(0);
                    document.querySelector("#discount").val(0);
                    document.querySelector("#vat").val(27);
                    document.querySelector("#quantity").val(0);

                    // Jelezni, hogy sikeres volt a művelet
                    document.querySelector("#success").classList.remove("d-none");
                    document.querySelector("#error").classList.add("d-none");
                    document.querySelector("#insert_price").classList.add("d-none");
                    setTimeout(function(){
                        document.querySelector("#success").classList.add("d-none");
                        document.querySelector("#insert_price").classList.remove("d-none");
                    },3000);

                }
            },
            error: function(error) {

                // Hibaüzenetek lekérdezése
                errors = error.responseJSON.errors;

                // Hibaüzenet helyének ürítése
                document.querySelector("#error").innerHTML("");

                // Végigmenni minden egyes hibán és berakni erre a helyre
                $.each(errors, function(key, value) {
                    document.querySelector("#error").append("<p>"+value+"</p>");
                });

                // Jelezni a hibát 
                document.querySelector("#success").classList.add("d-none");
                document.querySelector("#error").classList.remove("d-none");
                document.querySelector("#insert_price").classList.add("d-none");
                setTimeout(function(){
                    document.querySelector("#error").classList.add("d-none");
                    document.querySelector("#insert_price").classList.remove("d-none");
                },3000);
            }
        });
    });
});