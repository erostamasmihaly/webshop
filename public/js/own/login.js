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
        } else {
            
            // Hibás állapot mutatása 
            document.querySelector("#form").classList.add("was-validated");
            document.querySelector("#email").classList.add("is-invalid");
            document.querySelector("#email_error").classList.remove("d-none");
            document.querySelector("#email_error").innerHTML = result.data.error;
        }
    } catch (error) {

        console.log(error);
    }
});