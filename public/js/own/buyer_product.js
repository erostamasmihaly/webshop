$(function () {

    // Termék azonosító lekérdezése
    product_id = $("#product_id").val();
    
    // ColorBox beállítása
    $(".colorbox").colorbox({
        maxHeight: "80%", // Max 80 % magasság
        opacity: 0.4, // 40%-os átlátszóság
        fixed: true // Fix elhelyezkedés
    });

    // Kosárba helyezés
    $("#cart_add").on("click", function() {

        // Mennyiség lekérdezése
        quantity = $("#quantity").val();

        // Megnézni, hogy van-e mennyiség megadva
        if (quantity > 0) {

            // Adatok átküldése
            $.ajax({
                dataType: "json",
                url: "/buyer/cart/add",
                data: "product_id="+product_id+"&quantity="+quantity,
                type: "POST",
                cache: false,
                success: function (data) {

                    if (data.OK==1) {

                        // Ha sikeres volt, akkor a hozzá tartozó üzenet megjelenítése
                        $("#cart_success").removeClass("d-none").html("Sikeres művelet!");

                        // Visszaállítani 0-ra a mező értékét
                        $("#quantity").val(0);

                    } else {

                        // Ha nem sikerült, akkor a hibaüzenet megjelenítése
                        $("#cart_error").removeClass("d-none").html("Sikertelen művelet!");

                    }

                    // Kosárba rakás gomb elrejtése
                    cart_add_hide();

                },
                error: function (error) {

                    // Ha hiba volt, akkor a hibaüzenet megjelenítése
                    $("#cart_error").removeClass("d-none").html("Sikertelen művelet!");

                    // Kosárba rakás gomb elrejtése
                    cart_add_hide();
                }
            });
        } else {

            // Ha hiba volt, akkor a hibaüzenet megjelenítése
            $("#cart_error").removeClass("d-none").html("Nincs mennyiség megadva!");

            // Kosárba rakás gomb elrejtése
            cart_add_hide();

        }

    }); 

    // Kosárba rakás gomb elrejtése
    function cart_add_hide() {

        // Kosárba rakás gomb elrejtése
        $("#cart_add").addClass("d-none");

        // 5 másodperc után
        setTimeout(function() {

            // Kosárral kapcsolatos üzenetek elrejtése
            $("#cart_success, #cart_error").addClass("d-none");

            // Kosárba rakás gomb visszahozása
            $("#cart_add").removeClass("d-none");

        }, 5000);
    }

    // Kedvelés
    $(".fav").on("click", function() {
        send_favourites(1);
    });

    // Kedvelés visszavonása
    $(".unfav").on("click", function() {
        send_favourites(0);
    });

    // Változás elküldése a kedveléssel kapcsolatban
    function send_favourites(state) {

        // Adatok átküldése
        $.ajax({
            dataType: "json",
            url: "/buyer/favourite/change",
            data: "product_id="+product_id+"&state="+state,
            type: "POST",
            cache: false,
            success: function (data) {

                // Ha minsen rendben volt
                if (data.OK==1) {

                    if (state==1) {
                        
                        //// Ha kedvelés volt
                        // Kedvelés gomb elrejtése
                        $(".fav").addClass("d-none");

                        // Kedvelés visszavonása gomb megjelenítése
                        $(".unfav").removeClass("d-none");

                    } else {

                        //// Ha kedvelés visszavonása volt
                        // Kedvelés visszavonása gomb elrejtése
                        $(".unfav").addClass("d-none");

                        // Kedvelés gomb megjelenítése
                        $(".fav").removeClass("d-none");

                    }

                    // Kedvelések számának módosítása
                    $(".fav_total").html(data.total);
                }
            },
            error: function(error) {
                console.log(error);
            }
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
            }
        },
        initComplete: function(settings, json) {
            $("#title_fa_stars").html(json.others.fa_stars);
            $("#title_total").html(json.others.total);
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
    $("#send_rating").on("click", function() {

        user_id = $("#user_id").val();
        title = $("#title").val();
        body = tinymce.get("body").getContent();
        stars = $("#stars").val();

        // Adatok átküldése
        $.ajax({
            dataType: "json",
            url: "/buyer/rating/change",
            data: "product_id="+product_id+"&user_id="+user_id+"&title="+title+"&body="+body+"&stars="+stars,
            type: "POST",
            cache: false,
            success: function (data) {

                if (data.OK==1) {
                    
                    //// Ha minden rendben volt
                    // Értékelések frissítése
                    $("#ratings").DataTable().ajax.reload();

                    // Mezők értékeinek törlése
                    $("#title").val("");
                    $("#body").val("");

                    // Sikeresség üzenet megjelenítése
                    $("#rating_success").removeClass("d-none");

                } else {

                    // Sikertelenség üzenet megjelenítése
                    $("#rating_error").removeClass("d-none");                    

                }

                // Értékelés gomb elrejtése
                send_rating_hide();

            },
            error: function(error) {

                // Sikertelenség üzenet megjelenítése
                $("#error").removeClass("d-none");

                // Értékelés gomb elrejtése
                send_rating_hide();

            }
        });
    });

    // Értékelés gomb elrejtése
    function send_rating_hide() {

        // Értékelés gomb elrejtése
        $("#send_rating").addClass("d-none");

        // 5 másodperc után
        setTimeout(function() {

            // Értékeléssek kapcsolatos üzenetek elrejtése
            $("#rating_success, #rating_error").addClass("d-none");

            // Értékelés gomb visszahozása
            $("#send_rating").removeClass("d-none");

        }, 5000);
    }

});