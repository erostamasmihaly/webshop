<template>
    <h1>Felhasználó adatai</h1>
    <input type="hidden" v-model="user.id"/>
    <div class="row mb-2">
        <div class="col-sm-3">Felhasználói név</div>
        <div class="col-sm-9">
            <input type="text" class="form-control" v-model="user.name"/>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-sm-3">Vezetéknév</div>
        <div class="col-sm-9">
            <input type="text" class="form-control" v-model="user.surname"/>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-sm-3">Keresztnév</div>
        <div class="col-sm-9">
            <input type="text" class="form-control" v-model="user.forename"/>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-sm-3">Ország</div>
        <div class="col-sm-9">
            <input type="text" class="form-control" v-model="user.country"/>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-sm-3">Területi egység</div>
        <div class="col-sm-9">
            <input type="text" class="form-control" v-model="user.state"/>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-sm-3">Irányítószám</div>
        <div class="col-sm-9">
            <input type="text" class="form-control" v-model="user.zip"/>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-sm-3">Település</div>
        <div class="col-sm-9">
            <input type="text" class="form-control" v-model="user.city"/>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-sm-3">Utca, házszám...</div>
        <div class="col-sm-9">
            <input type="text" class="form-control" v-model="user.address"/>
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
        let user = ref({
            id:  null,
            name:  null,
            surname:  null,
            forename:  null,
            country:  null,
            state:  null,
            zip:  null,
            city:  null,
            address:  null
        });

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
                user.value = response.data;
            } catch (error) {
                console.log(error);
            }
        }

        // Felhasználó adatainak mentése
        const saveUser = async () => {
            try {

                // Mezők értékeinek lekérdezése
                const data = {
                    id: user.value.id,
                    name: user.value.name,
                    surname: user.value.surname,
                    forename: user.value.forename,
                    country: user.value.country,
                    state: user.value.state,
                    zip: user.value.zip,
                    city: user.value.city,
                    address: user.value.address
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
            user,
            getUser,
            saveUser
        }
    }
}
</script>