$(function () {
    
    // Termékek és kategóriák lekérdezése
    function get_products() {

        // SessionStorage-ba tárolt kategória lekérdezése
        var category_id = sessionStorage.getItem('category_id');

        // Kérés a szerver felé
        $.ajax({
            dataType: "json",
            url: "products",
            data: "category_id="+category_id,
            type: "GET",
            cache: false,
            success: function (data) {
                if (data.OK == 1) {

                    //// Ha minden rendben volt
                    // Lekérdezett kategóriák megjelenítése a Vissza gombbal együtt
                    show_categories(data.categories, data.back_id);

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

    // Kategóriák megjelenítése
    function show_categories(categories, back_id) {

        // Kategóriáknak kijelölt terület tisztítása
        $("#categories").html("");

        // Végigmenni minden egyes kategórián és megjeleníteni őket a kijelölt területen
        categories.forEach(function(category) {
            $("#categories").append('<div class="col-sm-3 categories" category_id="'+category.id+'"><span class="badge bg-primary w-100 p-2">'+category.name+'</span></div>');
        });

        // Vissza gomb behelyezése
        $("#categories").append('<div class="col-sm-3 categories" category_id="'+back_id+'"><span class="badge bg-secondary w-100 p-2">Vissza</span></div>');
    }

    // Kategória kiválasztása
    $("body").on("click", ".categories", function() {

        // Kijelölt kategória ID lekérdezése
        category_id = $(this).attr("category_id");

        // Ezen ID elmentése
        sessionStorage.setItem('category_id', category_id);

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
            html='<div class="col-sm-3 text-center"><div class="card p-2"><a href="/product/'+product.id+'" class="fw-bold">'+product.name+'<br><img src="'+product.image+'" class="img-fluid">';

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
});