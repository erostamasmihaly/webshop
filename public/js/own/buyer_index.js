$(function () {

    get_products();
    
    // Termékek és kategóriák lekérdezése
    function get_products() {

        // SessionStorage-ba tárolt kategória lekérdezése
        var category_id = sessionStorage.getItem('category_id');
        $.ajax({
            dataType: "json",
            url: "products",
            data: "category_id="+category_id,
            type: "GET",
            cache: false,
            success: function (data) {
                if (data.OK == 1) {
                    show_categories(data.categories, data.grandparent_id, category_id);
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

    // Kategóriák megjelenítése
    function show_categories(categories, grandparent_id) {

        $("#categories").html("");
        categories.forEach(function(category) {
            $("#categories").append('<div class="col-sm-3 categories" category_id="'+category.id+'"><span class="badge bg-primary w-100 p-2">'+category.name+'</span></div>');
        });
        $("#categories").append('<div class="col-sm-3 categories" category_id="'+grandparent_id+'"><span class="badge bg-secondary w-100 p-2">Vissza</span></div>');
    }

    // Kategória kiválasztása
    $("body").on("click", ".categories", function() {
        category_id = $(this).attr("category_id");
        sessionStorage.setItem('prev_id', sessionStorage.getItem('category_id'));
        sessionStorage.setItem('category_id', category_id);
        get_products();
    });

    // Termékek megjelenítése
    function show_products(products) {
        console.log(products);
    }
});