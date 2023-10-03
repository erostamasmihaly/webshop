$(function () {

    // Plusz gomb megnyomása
    plus_buttons = document.querySelectorAll(".plus");
    if (plus_buttons!=null) {
        for (var i=0; i<plus_buttons.length; i++) {
            plus_buttons[i].addEventListener("click", function() {
        
                // Termék azonosító és méret azonosító lekérdezése
                product_id = this.closest(".product").getAttribute("product_id");
                size_id = this.closest(".product").getAttribute("size_id");
        
                // Módosítás elküldése
                send_change(product_id, size_id, 1);
           
            });
        }
    }

    // Minusz gomb megnyomása
    minus_buttons = document.querySelectorAll(".minus");
    if (minus_buttons!=null) {
        for (var i=0; i<minus_buttons.length; i++) {
            minus_buttons[i].addEventListener("click", function() {
        
                // Termék azonosító és méret azonosító lekérdezése
                product_id = this.closest(".product").getAttribute("product_id");
                size_id = this.closest(".product").getAttribute("size_id");

                // Mennyiség lekérdezése
                quantity = $(this).closest(".product").find(".quantity").html();

                // Ha még nem 0
                if (quantity > 0) {

                    // Módosítás elküldése
                    send_change(product_id, size_id, -1);
                }
           
            });
        }
    }

    // Törlés gomb megnyomása
    delete_buttons = document.querySelectorAll(".delete");
    if (delete_buttons!=null) {
        for (var i=0; i<delete_buttons.length; i++) {
            delete_buttons[i].addEventListener("click", function() {
        
                // Termék azonosító és méret azonosító lekérdezése
                product_id = this.closest(".product").getAttribute("product_id");
                size_id = this.closest(".product").getAttribute("size_id");

                // Mennyiség lekérdezése
                quantity = $(this).closest(".product").find(".quantity").html();

                // Módosítás elküldése
                send_change(product_id, size_id, -1*quantity);
                
            });
        }
    }

    // Módosítás elküldése
    function send_change(product_id, size_id, quantity) {

        // Mennyiség lekérdezése
        quantity_old = $(".product[product_id="+product_id+"][size_id="+size_id+"] .quantity").html();
        
        // Adatok átküldése
        $.ajax({
            dataType: "json",
            url: "/buyer/cart/change",
            data: "product_id="+product_id+"&quantity="+quantity+"&size_id="+size_id,
            type: "POST",
            cache: false,
            success: function (data) {

                if (data.OK==1) {

                    //// Ha minden rendben volt

                    // Módosult mennyiség megállapítása
                    new_quantity = parseInt(quantity) + parseInt(quantity_old);

                    // Megnézni, hogy van-e még belőle
                    if (new_quantity > 0) {

                        // Ha még mindig van belőle, akkor mennyiség módosítása
                        $(".product[product_id="+product_id+"][size_id="+size_id+"] .quantity").html(new_quantity);

                    } else {

                        // Adott sor törlése és a táblázat frissítése
                        $(".datatable").DataTable().rows(".product[product_id="+product_id+"][size_id="+size_id+"]").remove().draw();

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
            },
            error: function(error) {

                // Ha valami hiba történt
                console.log(error);
            }
        });
    }


});