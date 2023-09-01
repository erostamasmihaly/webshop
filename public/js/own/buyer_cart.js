$(function () {

    // Plusz gomb megnyomása
    $(".plus").on("click", function() {
        
        // Termék azonosító lekérdezése
        product_id = $(this).closest(".product").attr("product_id");

        // Módosítás elküldése
        send_change(product_id, 1);
   
    });

    // Plusz gomb megnyomása
    $(".minus").on("click", function() {
        
        // Termék azonosító lekérdezése
        product_id = $(this).closest(".product").attr("product_id");

        // Mennyiség lekérdezése
        quantity = $(this).closest(".product").find(".quantity").html();

        // Ha még nem 0
        if (quantity > 0) {

            // Módosítás elküldése
            send_change(product_id, -1);
        }
   
    });

    // Törlés gomb megnyomása
    $(".delete").on("click", function() {
        
        // Termék azonosító lekérdezése
        product_id = $(this).closest(".product").attr("product_id");

        // Mennyiség lekérdezése
        quantity = $(this).closest(".product").find(".quantity").html();

        // Módosítás elküldése
        send_change(product_id, -1*quantity);
   
    });



    // Módosítás elküldése
    function send_change(product_id, quantity) {

        // Mennyiség lekérdezése
        quantity_old = $(".product[product_id="+product_id+"] .quantity").html();
        
        // Adatok átküldése
        $.ajax({
            dataType: "json",
            url: "/buyer/cart/change",
            data: "product_id="+product_id+"&quantity="+quantity,
            type: "POST",
            cache: false,
            success: function (data) {

                if (data.OK==1) {

                    new_quantity = parseInt(quantity) + parseInt(quantity_old);

                    if (new_quantity > 0) {

                        // Ha még mindig van belőle, akkor mennyiség módosítása
                        $(".product[product_id="+product_id+"] .quantity").html(new_quantity);

                    } else {

                        // Adott sor törlése és a táblázat frissítése
                        $(".datatable").DataTable().rows(".product[product_id="+product_id+"]").remove().draw();

                    }

                    // Fizetendő összeg frissítése
                    $("#total").html(data.total);
                } else {
                    console.log(data);
                }
            },
            error: function(error) {
                console.log(error);
            }
        });
    }


});