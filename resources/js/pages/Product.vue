<template>
    <h1>{{ name }}</h1>
    <div class="row">
        <div class="col-sm-6">
            <div class="bg-primary text-light p-2 fw-bold">Leírás</div>
            <div class="fw-bold">{{ summary }}</div>
            <div><span v-html="body"></span></div>
            <div class="bg-primary text-light p-2 fw-bold">Jellemzők</div>
            <table class="table table-hover">
                <tbody v-for="(item, index) in categories">
                    <tr>
                        <td class="fw-bold">{{ index }}</td>
                        <td>{{ item }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-sm-6">
            <div class="bg-primary text-light p-2 fw-bold">Méretek és árak</div>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">Méret</th>
                        <th scope="col">Mennyiség</th>
                        <th scope="col">Egységár</th>
                    </tr>
                </thead>
                <tbody v-for="(item, index) in prices">
                    <tr>
                        <td>{{ index }}</td>
                        <td>{{ item.quantity }} {{ unit }}</td>
                        <td>{{ item.discount_ft }}</td>
                    </tr>
                </tbody>
            </table>
            <div class="bg-primary text-light p-2 fw-bold">Képek</div>
            <div class="row p-2">
                <div class="col-sm-3 col-6" v-for="(item, index) in images">
                    <div @click="openPopup(item.image)">
                        <img :src="item.thumb" class="img-thumbnail"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="popup_background" v-show="popup_show">
        <div id="popup" class="text-center">
            <div id="popup_close" @click="closePopup()">X</div>
            <img :src="popup_image_src" class="img-fluid mh-100"/>
        </div>
    </div>
</template>
<style>
.img-thumbnail {
    cursor: pointer;
}
#popup_background {
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    background-color: rgba(0,0,0,0.5);
}
#popup {
    position: fixed;
    top: 10%;
    bottom: 10%;
    left: 20%;
    right: 20%;
    background: white;
}
#popup_close {
    position: absolute;
    right: 0;
    margin: 4px;
    font-weight: bold;
    width: 30px;
    height: 30px;
    border-radius: 15px;
    background: grey;
    cursor: pointer;
    display: flex;
    justify-content: center;
    align-items: center;
}
</style>
<script>
// Importálás
import {request} from '../helper'
import {ref, onMounted} from 'vue'
import router from '../route'

// Exportálás
export default {
    setup() {

        // Elemekre történő hivatkozások megadása
        let response = ref(null);
        let name = ref(null);
        let summary = ref(null);
        let body = ref(null);
        let prices = ref([]);
        let unit = ref(null);
        let categories = ref([]);
        let images = ref([]);
        let popup_show = ref(null);
        let popup_image_src = ref(null);

        // Amikor betöltődött az oldal
        onMounted(() => {
            getProduct();
        });

        // Termék adatainak lekérdezése
        const getProduct = async () => {

            let id = router.currentRoute.value.params.id;

            try {
                // GET kérés küldése a szervernek
                response = await request('get', '/api/vue/product/'+id);

                // Adatok lekérdezése és megjelenítése
                name.value = response.data.product.name;
                summary.value = response.data.product.summary;
                body.value = response.data.product.body;
                prices.value = response.data.prices;
                unit.value = response.data.product.unit;
                categories.value = {
                    "Termékcsoport": response.data.product.group,
                    "Nem": response.data.product.gender,
                    "Korosztály": response.data.product.age
                };
                images.value = response.data.images;
            } catch (error) {
                console.log(error);
            }
        }

        // Felugró ablak megnyitása
        const openPopup = async (src) => {
            popup_show.value = true;
            popup_image_src.value = src;
        }

        // Felugró ablak bezárása
        const closePopup = async () => {
            popup_show.value = false;
        }

        return {
            getProduct,
            openPopup,
            closePopup,
            name,
            summary,
            body,
            prices,
            unit,
            categories,
            images,
            popup_show,
            popup_image_src
        }
    }
}
</script>