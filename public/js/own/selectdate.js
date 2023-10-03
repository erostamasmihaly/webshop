$(function () {
    document.getElementsByClassName("datepicker").datepicker({
        changeMonth: true, // Hónap kiválasztása naptár fejlécben
   		changeYear: true, // Év kiválasztása a naptár fejlécben
		dateFormat: 'yy-mm-dd', // Dátum formátum
		firstDay: 1, // A hét első napja Hétfő
		dayNamesMin: ['V', 'H', 'K', 'Sze', 'Cs', 'P', 'Szo'], // Napok rövidítése
		monthNamesShort: ['Jan', 'Feb', 'Már', 'Ápr', 'Máj', 'Jún', 'Júl', 'Aug', 'Szep', 'Okt', 'Nov', 'Dec'] // Hóanpok rövidítése
    });
});