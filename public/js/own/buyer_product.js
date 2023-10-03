$(function () {

    // Termék azonosító lekérdezése
    product_id = document.getElementById("product_id").value;
    
    // ColorBox beállítása
    $(".colorbox").colorbox({
        maxHeight: "80%", // Max 80 % magasság
        opacity: 0.4, // 40%-os átlátszóság
        fixed: true // Fix elhelyezkedés
    });

    // Kosárba helyezés
    var cart_add = document.getElementById("cart_add");
    if (cart_add!=null) {
        cart_add.addEventListener("click", function() {

            // Adatok lekérdezése
            quantity = document.getElementById("quantity").value;
            size_id = document.getElementById("size").value;
            max = document.getElementById("size :selected").getAttribute("max");

            // Megnézni, hogy van-e mennyiség megadva
            if (quantity > 0) {

                response = true;

                if (quantity > max) {
                    response = confirm("A jelenleg elérhető mennyiségnél több lett megadva. Fizetéskor csak azon mennyiség lesz kifizetve, amennyi épp a fizetés során volt elérhető! Folytatja tovább a kosárba helyezést?")
                }

                if (response) {

                    // Adatok átküldése
                    $.ajax({
                        dataType: "json",
                        url: "/buyer/cart/add",
                        data: "product_id="+product_id+"&quantity="+quantity+"&size_id="+size_id,
                        type: "POST",
                        cache: false,
                        success: function (data) {

                            if (data.OK==1) {

                                // Ha sikeres volt, akkor a hozzá tartozó üzenet megjelenítése
                                document.getElementById("cart_success").removeClass("d-none").innerHTML("Sikeres művelet!");

                                // Visszaállítani 0-ra a mező értékét
                                document.getElementById("quantity").val(0);

                            } else {

                                // Ha nem sikerült, akkor a hibaüzenet megjelenítése
                                document.getElementById("cart_error").removeClass("d-none").innerHTML("Sikertelen művelet!");

                            }

                            // Kosárba rakás gomb elrejtése
                            cart_add_hide();

                        },
                        error: function (error) {

                            // Ha hiba volt, akkor a hibaüzenet megjelenítése
                            document.getElementById("cart_error").removeClass("d-none").innerHTML("Sikertelen művelet!");

                            // Kosárba rakás gomb elrejtése
                            cart_add_hide();
                        }
                    });
                }
            } else {

                // Ha hiba volt, akkor a hibaüzenet megjelenítése
                document.getElementById("cart_error").removeClass("d-none").innerHTML("Nincs mennyiség megadva!");

                // Kosárba rakás gomb elrejtése
                cart_add_hide();

            }

        });
    } 

    // Kosárba rakás gomb elrejtése
    function cart_add_hide() {

        // Kosárba rakás gomb elrejtése
        document.getElementById("cart_add").addClass("d-none");

        // 5 másodperc után
        setTimeout(function() {

            // Kosárral kapcsolatos üzenetek elrejtése
            document.getElementById("cart_success, #cart_error").addClass("d-none");

            // Kosárba rakás gomb visszahozása
            document.getElementById("cart_add").removeClass("d-none");

        }, 5000);
    }

    // Kedvelés
    var favs = document.getElementsByClassName("fav");
    for (var i = 0; i < favs.length; i++) {
        favs[i].addEventListener("click", function() {
            send_favourites(1);
        });
    }

    // Kedvelés visszavonása
    var unfavs = document.getElementsByClassName("unfav");
    for (var i = 0; i < unfavs.length; i++) {
        unfavs[i].addEventListener("click", function() {
            send_favourites(0);
        });
    }

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
                        document.getElementsByClassName("fav").addClass("d-none");

                        // Kedvelés visszavonása gomb megjelenítése
                        document.getElementsByClassName("unfav").removeClass("d-none");

                    } else {

                        //// Ha kedvelés visszavonása volt
                        // Kedvelés visszavonása gomb elrejtése
                        document.getElementsByClassName("unfav").addClass("d-none");

                        // Kedvelés gomb megjelenítése
                        document.getElementsByClassName("fav").removeClass("d-none");

                    }

                    // Kedvelések számának módosítása
                    document.getElementsByClassName("fav_total").html(data.total);
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
    var send_rating = document.getElementById("send_rating");
    if (send_rating != null) {
        send_rating.addEventListener("click", function() {

            user_id = document.getElementById("user_id").value;
            title = document.getElementById("title").value;
            body = tinymce.get("body").getContent();
            stars = document.getElementById("stars").value;

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
                        document.getElementById("ratings").DataTable().ajax.reload();

                        // Mezők értékeinek törlése
                        document.getElementById("title").val("");
                        document.getElementById("body").val("");

                        // Sikeresség üzenet megjelenítése
                        document.getElementById("rating_success").removeClass("d-none");

                    } else {

                        // Sikertelenség üzenet megjelenítése
                        document.getElementById("rating_error").removeClass("d-none");                    

                    }

                    // Értékelés gomb elrejtése
                    send_rating_hide();

                },
                error: function(error) {

                    // Sikertelenség üzenet megjelenítése
                    document.getElementById("error").removeClass("d-none");

                    // Értékelés gomb elrejtése
                    send_rating_hide();

                }
            });
        });
    }

    // Értékelés gomb elrejtése
    function send_rating_hide() {

        // Értékelés gomb elrejtése
        document.getElementById("send_rating").addClass("d-none");

        // 5 másodperc után
        setTimeout(function() {

            // Értékeléssek kapcsolatos üzenetek elrejtése
            document.getElementById("rating_success, #rating_error").addClass("d-none");

            // Értékelés gomb visszahozása
            document.getElementById("send_rating").removeClass("d-none");

        }, 5000);
    }

});