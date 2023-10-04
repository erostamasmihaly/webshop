// Elfogadás módosításakor
document.getElementById("accept").on("change", function() {

	// Megnézni, hogy el van-e fogadva
	is_checked = $(this).is(':checked');

	// Ettől függjön, hogy melyik elem legyen megjelenítve
	if (is_checked) {
		document.getElementById("active").classList.remove("d-none");
		document.getElementById("inactive").classList.add("d-none");
	} else {
		document.getElementById("active").classList.add("d-none");
		document.getElementById("inactive").classList.remove("d-none");           
	}
});