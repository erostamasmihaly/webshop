<template>
    <h1>{{ product.name }}</h1>
    <div class="row">
        <div class="col-sm-6">
            <ProductData :product="product"/>
            <ProductCategory :categories="product.categories"/>
            <ProductRatingList/>
            <ProductRatingWrite :is_buyed="product.is_buyed"/>
        </div>
        <div class="col-sm-6">
            <ProductSizes :prices="product.prices" :unit="product.unit"/>
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
import {request} from '../helper_vue'
import {ref, onMounted} from 'vue'
import router from '../route'
import ProductSizes from './components/ProductSizes.vue'
import ProductData from './components/ProductData.vue'
import ProductCategory from './components/ProductCategory.vue'
import ProductRatingList from './components/ProductRatingList.vue'
import ProductRatingWrite from './components/ProductRatingWrite.vue'

// Exportálás
export default {
    setup() {
        // Elemekre történő hivatkozások megadása
        let product_id = router.currentRoute.value.params.id;
        let response = ref(null);
        let product = ref({
            is_buyed: false
        });
        let popup = ref({});
        let mycart = ref({});
        let cartresult = ref({
            button: true
        });
        // Amikor betöltődött az oldal
        onMounted(() => {
            getProduct();
        });
        // Termék adatainak lekérdezése
        const getProduct = async () => {
            try {
                // GET kérés küldése a szervernek
                response = await request('get', '/api/product/' + product_id);
                // Adatok lekérdezése és megjelenítése
                product.value = response.data;
            }
            catch (error) {
                console.log(error);
            }
        };
        // Felugró ablak megnyitása
        const openPopup = async (src) => {
            popup.value = { show: true, image: src };
        };
        // Felugró ablak bezárása
        const closePopup = async () => {
            popup.value = {};
        };
        // Termék kosárba helyezése
        const putCart = async () => {
            try {
                // Termék azonosító felvitele
                mycart.value.product_id = product_id;
                // GET kérés küldése a szervernek
                response = await request('put', '/api/cart/', mycart.value);
                // Ha OK = 1 a válasz
                if (response.data.OK == 1) {
                    // Mezők visszaállítása
                    mycart.value = {};
                    // Eredmény mutatása
                    cartresult.value = { success: true };
                }
                else {
                    // Hiba mutatása
                    cartresult.value = { error: true, message: "Hiba történt a művelet során!" };
                }
            }
            catch (error) {
                // Hibák lekérdezése
                let errors = error.response.data.errors;
                // Hibaszöveg létrehozása ezen hibákból
                let errorMessage = Object.values(errors).join("<br>");
                // Hiba mutatása
                cartresult.value = { error: true, message: errorMessage };
                console.log(error);
            }
            // 3 másodperc múlva az eredmény elrejtése
            setTimeout(function () {
                cartresult.value = {};
            }, 3000);
        };

        return {
            getProduct,
            openPopup,
            closePopup,
            putCart,
            product,
            popup,
            mycart,
            cartresult
        };
    },
    components: { 
        ProductSizes, 
        ProductData, 
        ProductCategory,
        ProductRatingList,
        ProductRatingWrite
    }
}
</script>