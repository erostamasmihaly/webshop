$(function () {

    // Visszavonás gomb megnyomása
    [...document.querySelectorAll(".undo")].map(element => element.addEventListener("click", function() {

        // Termék azonosítójának lekérdezése
        product_id = this.closest(".fav").getAttribute("product_id");
    
        // Aktuális termék elmentése
        this_fav = this;
    
        // Adatok átküldése
        $.ajax({
            dataType: "json",
            url: "/buyer/favourite/change",                
            data: "product_id="+product_id+"&state=0",
            type: "POST",
            cache: false,
            success: function (data) {
    
                // Ha minden rendben volt
                if (data.OK==1) {
    
                    // Aktuális termék eltávolítása
                    $(this_fav).closest(".fav").remove();
    
                    // Megszámolni, hogy mennyi kedvenc van még hátra
                    count = document.querySelectorAll(".fav").length;
    
                    // Ha már nincs kedvenc
                    if (count==0) {
    
                        // Kedvencek blokk elrejtése
                        [...document.querySelectorAll(".favs")].map(element => element.classList.add("d-none"));
    
                        // Ürességet jelző blokk mutatása
                        [...document.querySelectorAll(".empty")].map(element => element.classList.remove("d-none"));
                    }
                }
            },
            error: function(error) {
                console.log(error);
            }
         });
    }));
});