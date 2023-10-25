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
    <div class="bg-dark p-2">
        <button class="btn btn-primary" @click="saveUser">Mentés</button>
    </div>
</template>
<script>
import {request} from '../helper'
import {ref, onMounted} from 'vue'
export default {
    setup() {
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
        onMounted(() => {
            getUser();
        });
        const getUser = async () => {
            try {
                response = await request('get', '/api/vue/user');
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

        const saveUser = async () => {
            try {
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
                const response = await request('post', '/api/vue/user', data);
                console.log(response);
            } catch (error) {
                console.log(error);
            }
        }

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