$(function () {

    // Elfogadás módosításakor
    $("#accept").on("change", function() {

        // Megnézni, hogy el van-e fogadva
        is_checked = $(this).is(':checked');

        // Ettől függjön, hogy melyik elem legyen megjelenítve
        if (is_checked) {
            $("#active").removeClass("d-none");
            $("#inactive").addClass("d-none");
        } else {
            $("#active").addClass("d-none");
            $("#inactive").removeClass("d-none");           
        }
    });
});