$(function () {

    // Elfogadás módosításakor
    document.getElementById("accept").on("change", function() {

        // Megnézni, hogy el van-e fogadva
        is_checked = $(this).is(':checked');

        // Ettől függjön, hogy melyik elem legyen megjelenítve
        if (is_checked) {
            document.getElementById("active").removeClass("d-none");
            document.getElementById("inactive").addClass("d-none");
        } else {
            document.getElementById("active").addClass("d-none");
            document.getElementById("inactive").removeClass("d-none");           
        }
    });
});