<template>
    <h1>{{ product.name }}</h1>
    <div class="row">
        <div class="col-sm-6">
            <div class="bg-primary text-light p-2 fw-bold">Leírás</div>
            <div class="fw-bold">{{ product.summary }}</div>
            <div><span v-html="product.body"></span></div>
            <div class="bg-primary text-light p-2 fw-bold">Jellemzők</div>
            <table class="table table-hover">
                <tbody>
                    <tr v-for="item in product.categories">
                        <td class="fw-bold w-50">{{ item.key }}</td>
                        <td>{{ item.value }}</td>
                    </tr>
                </tbody>
            </table>
            <div class="bg-primary text-light p-2 fw-bold">
                Értékelések ({{  ratings.total }} db)
                <span v-if="ratings.items.length>0" class="float-end fw-bold">
                    <span v-for="star in ratings.stars">&#9733;</span>
                    <span v-for="star in 5-(ratings.stars)">&#9734;</span>
                </span>
            </div>
            <div v-if="ratings.items.length == 0" class="alert alert-warning mt-2" role="alert">
                Még senki nem értékelte a terméket!
            </div>    
            <table v-else class="table table-hover">
                <tbody>
                    <tr v-for="item in ratings.items">
                        <td :style="{ 
                            color: item.moderated == 0 ? 'red' : 'black',
                            fontStyle: item.moderated == 0 ? 'italic' : 'normal' 
                        }">
                            <span class="fw-bold">{{ item.title }}</span>
                            <span class="float-end fw-bold">
                                <span v-for="star in item.stars">&#9733;</span>
                                <span v-for="star in 5-(item.stars)">&#9734;</span>
                            </span>
                            <div>
                                <span v-html="item.body"></span>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div v-if="product.is_buyed">
                <div class="bg-primary text-light p-2 fw-bold">Értékelés írása</div>
                <div class="row m-1">
                    <div class="col-sm-2 fw-bold">Cím</div>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" v-model="myrating.title"/>
                    </div>
                </div>
                <div class="row m-1">
                    <div class="col-sm-2 fw-bold">Leírás</div>
                    <div class="col-sm-10">
                        <textarea class="form-control" v-model="myrating.body"/>
                    </div>
                </div>
                <div class="row m-1">
                    <div class="col-sm-2 fw-bold">Csillag</div>
                    <div class="col-sm-10">
                        <select class="form-control" v-model="myrating.stars">
                            <option v-for="num in 5" :value="num">{{ num }}</option>
                        </select>
                    </div>
                </div>
                <div>
                    <button class="btn btn-primary" type="button" @click="putRating()" v-show="ratingresult.button">Értékelés elküldése</button>
                    <div class="alert alert-success" role="alert" v-show="ratingresult.success">
                        Értékelés sikeresen elküldve. Jelenleg moderálás alatt!
                    </div>
                    <div class="alert alert-danger" role="alert" v-show="ratingresult.error">
                        Hiba történt az értékelés elküldése során!
                    </div>
                </div>
            </div>
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
                <tbody>
                    <tr v-for="(item, index) in product.prices">
                        <td>{{ index }}</td>
                        <td>{{ item.quantity }} {{ product.unit }}</td>
                        <td>{{ item.discount_ft }}</td>
                    </tr>
                </tbody>
            </table>
            <div class="bg-primary text-light p-2 fw-bold">Termék kosárba helyezése</div>
            <div class="row p-2">
                <div class="col-sm-3 fw-bold">Méret</div>
                <div class="col-sm-3 fw-bold">Mennyiség</div>
                <div class="col-sm-6"></div>
                <div class="col-sm-3">
                    <select class="form-control" v-model="mycart.size_id">
                        <option v-for="(item, index) in product.prices" :value="item.id">{{  index }}</option>
                    </select>
                </div>
                <div class="col-sm-3">
                    <select class="form-control" v-model="mycart.quantity">
                        <option v-for="n in 10" :value="n">{{ n }}</option>
                    </select>
                </div>
                <div class="col-sm-6">
                    <button class="btn btn-primary w-100" @click="putCart()">Kosárba helyezés</button>
                </div>
                <div>
                    <div class="alert alert-success m-2" role="alert" v-show="cartresult.success">
                        Termék sikeresen a kosárba helyezve!
                    </div>
                    <div class="alert alert-danger m-2" role="alert" v-show="cartresult.error">
                        <span v-html="cartresult.message"></span>
                    </div>
                </div>
            </div>
            <div class="bg-primary text-light p-2 fw-bold">Képek</div>
            <div class="row p-2">
                <div class="col-sm-3 col-6" v-for="item in product.images">
                    <div @click="openPopup(item.image)">
                        <img :src="item.thumb" class="img-thumbnail"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="popup_background" v-show="popup.show">
        <div id="popup" class="text-center">
            <div id="popup_close" @click="closePopup()">X</div>
            <img :src="popup.image" class="img-fluid mh-100"/>
        </div>
    </div>
</template>
<script>
// Importálás
import {request} from '../helper'
import {ref, onMounted} from 'vue'
import router from '../route'

// Exportálás
export default {
    setup() {

        // Elemekre történő hivatkozások megadása
        let product_id = router.currentRoute.value.params.id;
        let response = ref(null);
        let product = ref({});
        let ratings = ref({
            items: {},
            total: null,
            stars: null
        });
        let popup = ref({});
        let myrating = ref({
            stars: 5
        });
        let ratingresult = ref({
            button: true
        });
        let mycart = ref({});
        let cartresult = ref({
            button: true
        });

        // Amikor betöltődött az oldal
        onMounted(() => {
            getProduct();
            getRating();
        });

        // Termék adatainak lekérdezése
        const getProduct = async () => {

            try {
                // GET kérés küldése a szervernek
                response = await request('get', '/api/vue/product/'+product_id);

                // Adatok lekérdezése és megjelenítése
                product.value = response.data;
           
            } catch (error) {
                console.log(error);
            }
        }

        // ÉRtékelések lekérdezése
        const getRating = async () => {

            try {

                // GET kérés küldése a szervernek
                response = await request('get', '/api/vue/rating/'+product_id);

                // Adatok lekérdezése és megjelenítése
                ratings.value = response.data;

            } catch (error) {
                console.log(error);
            }
        }

        // Felugró ablak megnyitása
        const openPopup = async (src) => {
            popup.value = { show: true, image: src};
        }

        // Felugró ablak bezárása
        const closePopup = async () => {
            popup.value = { };
        }

        // Értékelés elküldése
        const putRating = async () => {
            try {

                // Termékazonosító megadása
                myrating.value.product_id = product_id;

                // Kérés küldése a szerver felé
                const response = await request('put', '/api/vue/rating', myrating.value);

                // Ha OK = 1 a válasz
                if (response.data.OK == 1) {

                    // Értékelések újratöltése
                    getRating();

                    // Mezők visszaállítása
                    myrating.value = { stars: 5 };

                    // Eredmény mutatása
                    ratingresult.value = { success: true }

                } else {
                    
                    // Hiba mutatása
                    ratingresult.value = { error: true }
                }

                // 3 másodperc múlva az eredmény elrejtése
                setTimeout(function() {
                    ratingresult.value = { button: true }
                }, 3000);


            } catch (error) {
                console.log(error);
            }
        }

        // Termék kosárba helyezése
        const putCart = async () => {

            try {

                // Termék azonosító felvitele
                mycart.value.product_id = product_id;

                // GET kérés küldése a szervernek
                response = await request('put', '/api/vue/cart/', mycart.value);

                // Ha OK = 1 a válasz
                if (response.data.OK == 1) {

                    // Mezők visszaállítása
                    mycart.value = { };

                    // Eredmény mutatása
                    cartresult.value = { success: true }

                } else {

                    // Hiba mutatása
                    cartresult.value = { error: true, message: "Hiba történt a művelet során!" }
                }
                
            } catch (error) {

                // Hibák lekérdezése
                let errors = error.response.data.errors;

                // Hibaszöveg létrehozása ezen hibákból
                let errorMessage = Object.values(errors).join("<br>");

                // Hiba mutatása
                cartresult.value = { error: true, message: errorMessage }

                console.log(error);
            }

            // 3 másodperc múlva az eredmény elrejtése
            setTimeout(function() {
                cartresult.value = {  }

            }, 3000);
        }

        return {
            getProduct,
            getRating,
            openPopup,
            closePopup,
            putRating,
            putCart,
            product,
            popup,
            ratings,
            myrating,
            ratingresult,
            mycart,
            cartresult
        }
    }
}
</script>