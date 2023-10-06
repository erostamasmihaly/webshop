 // Visszavonás gomb megnyomása
 [...document.querySelectorAll(".undo")].map(element => element.addEventListener("click", function() {

    // Termék azonosítójának lekérdezése
    product_id = this.closest(".fav").getAttribute("product_id");

    // Aktuális termék elmentése
    this_fav = this;

    // Átküldendő értékek összegyűjtése
    body = JSON.stringify({
        product_id: product_id,
        state: 0
    });

    // Kérés küldése a szerver felé
    fetch("/buyer/favourite/change", {
        body: body,
        method: "POST",
        cache: "no-cache",
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json",
            "X-Requested-With": "XMLHttpRequest",
            "X-CSRF-TOKEN": document.querySelector("meta[name='csrf-token']").getAttribute("content")
        }
    }).then(response => response.text()).then(text => {

        // Válasz átalakítása JSON-ná
        data = JSON.parse(text);

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

    })
    .catch(error => {
        console.log(error);
    });
}));