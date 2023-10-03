$(function () {

    // Elfogadás módosításakor
    document.querySelector("#accept").on("change", function() {

        // Megnézni, hogy el van-e fogadva
        is_checked = this.is(':checked');

        // Ettől függjön, hogy melyik elem legyen megjelenítve
        if (is_checked) {
            document.querySelector("#active").classList.remove("d-none");
            document.querySelector("#inactive").classList.add("d-none");
        } else {
            document.querySelector("#active").classList.add("d-none");
            document.querySelector("#inactive").classList.remove("d-none");           
        }
    });
});