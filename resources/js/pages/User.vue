<template>
    <h1>Felhasználó adatai</h1>
    <input type="hidden" v-model="id"/>
    <div class="row mb-2">
        <div class="col-sm-3">Felhasználói név</div>
        <div class="col-sm-9">
            <input type="text" class="form-control" v-model="name"/>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-sm-3">Vezetéknév</div>
        <div class="col-sm-9">
            <input type="text" class="form-control" v-model="surname"/>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-sm-3">Keresztnév</div>
        <div class="col-sm-9">
            <input type="text" class="form-control" v-model="forename"/>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-sm-3">Ország</div>
        <div class="col-sm-9">
            <input type="text" class="form-control" v-model="country"/>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-sm-3">Területi egység</div>
        <div class="col-sm-9">
            <input type="text" class="form-control" v-model="state"/>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-sm-3">Irányítószám</div>
        <div class="col-sm-9">
            <input type="text" class="form-control" v-model="zip"/>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-sm-3">Település</div>
        <div class="col-sm-9">
            <input type="text" class="form-control" v-model="city"/>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-sm-3">Utca, házszám...</div>
        <div class="col-sm-9">
            <input type="text" class="form-control" v-model="address"/>
        </div>
    </div>
    <div class="alert alert-success d-none" role="alert" id="success">
        Sikeres művelet!
    </div>
    <div class="alert alert-danger d-none" role="alert" id="error"></div>
    <div class="bg-dark p-2">
        <button class="btn btn-primary" @click="saveUser">Mentés</button>
    </div>
</template>
<script>
// Importálás
import {request} from '../helper'
import {ref, onMounted} from 'vue'

// Exportálás
export default {
    setup() {
        
        // Elemekre történő hivatkozások megadása
        let response = ref(null);
        let id = ref(null);
        let name = ref(null);
        let surname = ref(null);
        let forename = ref(null);
        let country = ref(null);
        let state = ref(null);
        let zip = ref(null);
        let city = ref(null);
        let address = ref(null);

        // Amikor betöltődött az oldal
        onMounted(() => {
            getUser();
        });

        // Felhasználó adatainak lekérdezése
        const getUser = async () => {
            try {
                // GET kérés küldése a szervernek
                response = await request('get', '/api/vue/user');

                // Mezők értékeinek megadása a kérés eredménye alapján
                id.value = response.data.user.id;
                name.value = response.data.user.name;
                surname.value = response.data.user.surname;
                forename.value = response.data.user.forename;
                country.value = response.data.user.country;
                state.value = response.data.user.state;
                zip.value = response.data.user.zip;
                city.value = response.data.user.city;
                address.value = response.data.user.address;
            } catch (error) {
                console.log(error);
            }
        }

        // Felhasználó adatainak mentése
        const saveUser = async () => {
            try {

                // Mezők értékeinek lekérdezése
                const data = {
                    id: id.value,
                    name: name.value,
                    surname: surname.value,
                    forename: forename.value,
                    country: country.value,
                    state: state.value,
                    zip: zip.value,
                    city: city.value,
                    address: address.value
                }

                // Kérés küldése a szerver felé
                const response = await request('post', '/api/vue/user', data);
                
                // Ha OK = 1 a válasz
                if (response.data.OK == 1) {

                    // Mutatni a sikerességet jelző üzenetet
                    document.querySelector("#success").classList.remove("d-none");

                    // Ezen üzenet elrejtése 3 másodperc múlva
                    setTimeout(function() {
                        document.querySelector("#success").classList.add("d-none");
                    }, 3000)
                }
            } catch (error) {

                // Hibák lekérdezése
                let errors = error.response.data.errors;

                // Hibaszöveg létrehozása ezen hibákból
                let errorMessage = Object.values(errors).join("<br>");

                // Hibaszövegek megjelenítése
                document.querySelector("#error").classList.remove("d-none");
                document.querySelector("#error").innerHTML = errorMessage;

                // Ezen hibaszövegek elrejtése 3 másodperc múlva
                setTimeout(function() {
                    document.querySelector("#error").classList.add("d-none");
                }, 3000)
            }
        }

        // Visszatérés
        return {
            id,
            name,
            surname,
            forename,
            country,
            state,
            zip,
            city,
            address,
            getUser,
            saveUser
        }
    }
}
</script>