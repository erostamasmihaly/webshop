// TOKEN lekérdezése
const token = localStorage.getItem('USER_TOKEN')

// Adatok lekérdezése
const getFetch = (url, func) => {

    // Fejléc beállítása
    const headers = {
        headers: {
            Authorization: 'Bearer ' + token
        }
    }

    // Kérés elküldése
    fetch(url, headers)
            .then(response => response.json())
            .then(data => {
                func(data)
            })
            .catch((err) => {
                console.log(err.message);
            });
}

// Adatok felvitele
const setFetch = (url, body, func) => {
    
    // Fejléc beállítása
    const headers = {
        method: 'POST',
        headers: { 
            'Content-Type': 'application/json',
            Authorization: 'Bearer ' + token
        },
        body: JSON.stringify(body)
    };

    // Kérés elküldése
    fetch(url, headers)
        .then(response => response.json())
        .then(data => func(data))
        .catch((err) => {
            console.log(err.message);
        });
}

export { getFetch, setFetch };