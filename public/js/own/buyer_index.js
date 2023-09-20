$(function () {
    
    // Termékek és kategóriák lekérdezése
    function get_products() {

        // SessionStorage-ba tárolt kategória lekérdezése
        var group_id = sessionStorage.getItem('group_id');

        // Új objektum létrehozása
        obj = new Object();

        // Szűrők felvitele ebbe az objektumba
        obj.shops = $("#filter_shop").val();
        obj.sizes = $("#filter_size").val();
        obj.genders = $("#filter_gender").val();
        obj.ages = $("#filter_age").val();

        // JSON létrehozása objektumból
        filter = JSON.stringify(obj);
        console.log(filter);

        // Kérés a szerver felé
        $.ajax({
            dataType: "json",
            url: "products",
            data: "group_id="+group_id+"&filter="+filter,
            type: "GET",
            cache: false,
            success: function (data) {
                if (data.OK == 1) {

                    //// Ha minden rendben volt
                    // Lekérdezett termékcsoportok megjelenítése a Vissza gombbal együtt
                    show_groups(data.groups, data.back_id);

                    // Lekérdezett termékek megjelenítése
                    show_products(data.products);
                } else {
                    console.log(data);
                }
            },
            error: function (error) {
                console.log(error);
            }
        });
    }
    get_products();

    // Termékcsoportok megjelenítése
    function show_groups(groups, back_id) {

        // Termékcsoprotoknak kijelölt terület tisztítása
        $("#groups").html("");

        // Végigmenni minden egyes termékcsoporton és megjeleníteni őket a kijelölt területen
        groups.forEach(function(group) {
            $("#groups").append('<div class="col-lg-3 col-sm-4 col-6 groups mb-1" group_id="'+group.id+'"><span class="badge bg-primary w-100 p-2">'+group.name+'</span></div>');
        });

        // Vissza gomb behelyezése
        $("#groups").append('<div class="col-lg-3 col-sm-4 col-6 groups mb-2" group_id="'+back_id+'"><span class="badge bg-secondary w-100 p-2">Vissza</span></div>');
    }

    // Kategória kiválasztása
    $("body").on("click", ".groups", function() {

        // Kijelölt kategória ID lekérdezése
        group_id = $(this).attr("group_id");

        // Ezen ID elmentése
        sessionStorage.setItem('group_id', group_id);

        // Termékek és kategóriák újbóli lekérdezése
        get_products();
    });

    // Termékek megjelenítése
    function show_products(products) {

        // Termékeknek kijelölt terület tisztítása
        $("#products").html("");

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
            $("#products").append(html);
        });
    }

    // Alapállapot visszaállítása
    $("#filter_default").on("click", function(){

        // Minden szűrő esetén a legleső lehetőség kiválasztása
        $("#filter_shop").val(null).trigger('change');
        $("#filter_size").val(null).trigger('change');
        $("#filter_gender").val(null).trigger('change');
        $("#filter_age").val(null).trigger('change');

        // Termékek lekérdezése
        get_products();

    });

    // Szűrő módosítása után
    $(".filter").on("change", function(){

        // Termékek lekérdezése
        get_products();
    });
});