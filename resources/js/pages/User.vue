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
    <div>
        <button class="btn btn-primary" @click="saveUser" v-show="result.button">Mentés</button>
        <div class="alert alert-success" role="alert" v-show="result.success">
            Sikeres művelet!
        </div>
        <div class="alert alert-danger" role="alert" v-show="result.error"><span v-html="result.message"></span></div>
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
        let user = ref({});
        let result = ref({
            button: true,
        });

        // Amikor betöltődött az oldal
        onMounted(() => {
            getUser();
        });

        // Felhasználó adatainak lekérdezése
        const getUser = async () => {

            try {

                // GET kérés küldése a szervernek
                response = await request('get', '/api/user');

                // Mezők értékeinek megadása a kérés eredménye alapján
                user.value = response.data;

            } catch (error) {
                console.log(error);
            }
        }

        // Felhasználó adatainak mentése
        const saveUser = async () => {
            try {

                // Kérés küldése a szerver felé
                const response = await request('post', '/api/user', user.value);
                
                // Ha OK = 1 a válasz
                if (response.data.OK == 1) {

                    // Eredmény mutatása
                    result.value = { success: true }

                }
            } catch (error) {

                // Hibák lekérdezése
                let errors = error.response.data.errors;

                // Hibaszöveg létrehozása ezen hibákból
                let errorMessage = Object.values(errors).join("<br>");

                // Hiba mutatása
                result.value = { error: true, message: errorMessage }
                
            }

            // 3 másodperc múlva az eredmény elrejtése
            setTimeout(function() {
                result.value = { button: true }
            }, 3000);
        }

        // Visszatérés
        return {
            user,
            result,
            getUser,
            saveUser
        }
    }
}
</script>