<template>
    <h1>Felhasználó adatai</h1>
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
</template>
<script>
import {request} from '../helper'
import {ref} from 'vue'
export default {
    setup() {
        let response = ref(null);
        let surname = ref(null);
        let forename = ref(null);
        let country = ref(null);
        let state = ref(null);
        let zip = ref(null);
        let city = ref(null);
        let address = ref(null);
        const getUser = async () => {
            try {
                response = await request('get', '/api/vue/user');
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
        let get_user = getUser();
        return {
            get_user,
            surname,
            forename,
            country,
            state,
            zip,
            city,
            address
        }
    }
}
</script>