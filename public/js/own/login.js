// TOKEN lekérdezése
document.querySelector("button[type='submit']").addEventListener("click", async(event) => {

    // Eredetileg definiált működés blokkolása
    event.preventDefault()

    // Adatok lekérdezése
    data = {
        email: document.querySelector("#email").value,
        password: document.querySelector("#password").value
    };

    try {
        // Adatok átküldése a szervernek
        const result = await axios.post('token', data)

        // Ha minden rendben van
        if (result.status === 200 && result.data && result.data.token) {

            // Megkapott TOKEN elmentése
            localStorage.setItem('USER_TOKEN', result.data.token);

            // Főoldal megnyitása
            window.location.href = "/";
        }
    } catch (error) {
        console.log(error);
    }
});