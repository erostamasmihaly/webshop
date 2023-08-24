$(function () {

    // Képek feltöltése
    $("#upload").on("click", function() {
        upload_images();
    });

    // Ingatlan azonosító lekérdezése - vagy ha 0, akkor az ideiglenes random azonosító
    product_id = ($("#product_id").val() == 0) ? $("#temporary_id").val() : $("#product_id").val();

    // Felugró ablak meghívása
    /*$("#imageModalButton").on("click", function() {

        // Képek frissítése
        refreshImages();
    });

    // Sorrend mentése
    $("#sequence").on("click", function() {
        
        // Képek frissítése
        refreshImages();
    });

    // Sorbarendezés engedélyezése
    $(".galeria_sortable").sortable({
        cursor: "move",
        stop: function() {
            saveSequence();
        }
    });

    // Sorrend mentése
    function saveSequence() {

        // Képeket tartalmazó tömb létrehozása
        images_array = [];
            
        // Végigmenni minden egyes képen
        $(".kep").each(function(e) {
                
            // Aktuális kép azonosítójának lekérdezése
            image_id = $(this).attr("image_id");

            // Kép behelyezése a tömbbe
            images_array.push(image_id);
        });

        // JSON létrehozása tömbből
        images = JSON.stringify(images_array);

        // Új sorrend átküldése a szervernek
        $.ajax({
            dataType: "json",
            url: "/admin/property/image/sequence",
            data: "images="+images+"&property_id="+property_id,
            type: "POST",
            cache: false,
            success: function (data) {

                // Ha nem OK=1 válasz érkezett, akkor hiba volt
                if (data.OK!=1) {

                    // Hiba jelzése a felhasználónak
                    $("#gallery-error").removeClass("d-none").html("Hiba történt sorrend módosítása során!");

                    // Hibaszöveg megjelenítése a consolon
                    console.log(data);
                }
            },
            error: function (error) {
                
                // Hiba jelzése a felhasználónak
                $("#gallery-error").removeClass("d-none").html("Hiba történt kép törlése során!");

                // Hibaszöveg megjelenítése a consolon
                console.log(error);
            }

        });
    }


    // Képek lekérdezésse
    function refreshImages() {

        // Hibaüzenet elrejtése
        $("#gallery-error").addClass("d-none");

        // Képek lekérdezése
        $.ajax({
            dataType: "json",
            url: "/admin/property/image/list",
            data: "property_id="+property_id,
            type: "POST",
            cache: false,
            success: function (data) {

                if (data.OK==1) {

                    //// Ha sikeres volt a lekérdezése
                    
                    // Könyvtár lekérdezése
                    dir = data.dir;

                    // Előző képek törlése
                    $("#gallery").html(null);

                    // Végigmenni minden egyes képen
                    $.each(data.images, function (key, val) {

                        // Megnézni, hogy vezérképről van-e szó
                        main_image = (val.main==1) ? "text-success" : "text-secondary";

                        // Kép elhelyezése
                        $("#gallery").append("<li class='col-sm-2'><div class='kep' image_id='"+val.id+"'><image src='"+dir+"/thumb/"+val.name+"' alt='"+val.name+"' title='"+val.name+"' class='mb-3 img-fluid w-90 object-fit-cover h-100'><div class='float-end'><div class='main' image_id='"+val.id+"'><i class='fa-sharp fa-solid fa-thumbtack "+main_image+"'></i></div><div class='delete' image_id='"+val.id+"'><i class='fa-solid fa-trash text-danger'></i></div></div></div></li>");
                    });
        
                } else {

                    //// Ha nem volt sikeres a lekérdezése
                    // Hiba jelzése a felhasználónak
                    $("#gallery-error").removeClass("d-none").html("Hiba történt a képek lekérdezése során!");

                    // Hibaszöveg megjelenítése a consolon
                    console.log(data);
                    
                }                    
            },
            error: function (error) {
                
                // Hiba jelzése a felhasználónak
                $("#gallery-error").removeClass("d-none").html("Hiba történt a képek lekérdezése során!");

                // Hibaszöveg megjelenítése a consolon
                console.log(error);
            }
        });

    }

    // Vezérkép kiválasztása
    $("body").on("click", ".main", function(){

        // Felugró ablak megjelenítése
        is_main = confirm("Biztos, hogy ezt a képet szeretné vezérképnek beállítani?");
        
        // Ha módosítani kell a vezérképet
        if (is_main) {

            // Aktuális kép azonosítójának lekérdezése
            image_id = $(this).attr("image_id");

            // Új vezérkép átküldése a szervernek
            $.ajax({
                dataType: "json",
                url: "/admin/property/image/main",
                data: "image_id="+image_id+"&property_id="+property_id,
                type: "POST",
                cache: false,
                success: function (data) {

                    // Ha nem OK=1 válasz érkezett, akkor hiba volt
                    if (data.OK==1) {

                        // Képek frissítése
                        refreshImages();
                        
                    } else {

                        // Hiba jelzése a felhasználónak
                        $("#gallery-error").removeClass("d-none").html("Hiba történt a vezérkép módosítása során!");

                        // Hibaszöveg megjelenítése a consolon
                        console.log(data);
                    }
                },
                error: function(error) {
                    
                    // Hiba jelzése a felhasználónak
                    $("#gallery-error").removeClass("d-none").html("Hiba történt a vezérkép módosítása során!");

                    // Hibaszöveg megjelenítése a consolon
                    console.log(error);
                }
		    });
        }
    });

    // Kép törlése
    $("body").on("click", ".delete", function(){

        // Felugró ablak megjelenítése
        is_delete = confirm("Biztos, hogy törölni szeretné a képet?");
        
        // Ha törölni kell a képet
        if (is_delete) {
            
            // Aktuális kép azonosítójának lekérdezése
            image_id = $(this).attr("image_id");            

            // Törlendő kép átküldése
            $.ajax({
                dataType: "json",
                url: "/admin/property/image/delete",
                data: "image_id="+image_id,
                type: "POST",
                cache: false,
                success: function (data) {

                    // Ha nem OK=1 válasz érkezett, akkor hiba volt
                    if (data.OK!=1) {

                        // Hiba jelzése a felhasználónak
                        $("#gallery-error").removeClass("d-none").html("Hiba történt kép törlése során!");

                        // Hibaszöveg megjelenítése a consolon
                        console.log(data);

                    } else {

                        // Kép törlése a felületen
                        $(".kep[image_id="+image_id+"]").parent("li").remove();
                    }
                    
                },
                error: function (error) {

                    // Hiba jelzése a felhasználónak
                    $("#gallery-error").removeClass("d-none").html("Hiba történt kép törlése során!");

                    // Hibaszöveg megjelenítése a consolon
                    console.log(error);

                }
            });
        }
        
    });

    // Fájl feltöltése gomb megnyomásakor
    $("#file").on("click", function() {
        
        // Hiba üzenet elrejtése
        $("#upload-error").addClass("d-none");

    });

    */


    // Fényképek feltöltése
    function upload_images() {

        // Megnézni, hogy van-e fájl feltöltve        
        if(file.files[0] == undefined) {

            // Ha nincs, akkor hibaüzenet megjelenítése
            $("#upload-error").removeClass("d-none").html("Nincsenek képek megadva!");

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
                    console.log(data);
                    /*if (data.OK == 1) {

                        // Képek frissítése
                        //refreshImages();

                        // Fájl mező alapállapotba állítása
                        $("#file").val(null);

                        // Hibaüzenet elrejtése
                        $("#upload-error").addClass("d-none");

                    } else {

                        // Hiba jelzése a felhasználónak
                        $("#upload-error").removeClass("d-none").html("Hiba történt a képek feltöltése során!");

                        // Hibaszöveg megjelenítése a consolon
                        console.log(data);

                    }*/
                },
                error: function (error) {
                    
                    // Hiba jelzése a felhasználónak
                    $("#upload-error").removeClass("d-none").html("Hiba történt a képek feltöltése során!");

                    // Hibaszöveg megjelenítése a consolon
                    console.log(error);

                }
            });
        }

    } 
});