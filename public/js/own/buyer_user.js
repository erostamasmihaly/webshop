$(function () {

    // Visszavonás gomb megnyomása
    $(".undo").on("click", function() {

        // Termék azonosítójának lekérdezése
        product_id = $(this).closest(".fav").attr("product_id");

        // Aktuális termék elmentése
        this_fav = $(this);

        // Adatok átküldése
        $.ajax({
            dataType: "json",
            url: "/buyer/favourite/change",
            data: "product_id="+product_id+"&state=0",
            type: "POST",
            cache: false,
            success: function (data) {

                // Ha minsen rendben volt
                if (data.OK==1) {

                    // Aktuális termék eltávolítása
                    $(this_fav).closest(".fav").remove();

                    // Megszámolni, hogy mennyi kedvenc van még hátra
                    count = $(".fav").length;

                    // Ha már nincs kedvenc
                    if (count==0) {

                        // Kedvencek blokk elrejtése
                        $(".favs").addClass("d-none");

                        // Ürességet jelző blokk mutatása
                        $(".empty").removeClass("d-none");
                    }
                }
            },
            error: function(error) {
                console.log(error);
            }
        });

    });
});