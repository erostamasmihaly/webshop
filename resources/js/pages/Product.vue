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
            <ProductFavourite/>
            <ProductSizes :prices="product.prices" :unit="product.unit"/>
            <ProductCart :prices="product.prices"/>
            <ProductImage :images="product.images"/>
        </div>
    </div>
    <ProductPopup :show="popup.show" :image="popup.image"/>
</template>
<script>
// Importálás
import { request } from '../helper_vue'
import { ref, onMounted } from 'vue'
import { popup } from './components/Product/popup';
import router from '../route'
import ProductSizes from './components/Product/ProductSizes.vue'
import ProductData from './components/Product/ProductData.vue'
import ProductCategory from './components/Product/ProductCategory.vue'
import ProductRatingList from './components/Product/ProductRatingList.vue'
import ProductRatingWrite from './components/Product/ProductRatingWrite.vue'
import ProductCart from './components/Product/ProductCart.vue'
import ProductImage from './components/Product/ProductImage.vue'
import ProductPopup from './components/Product/ProductPopup.vue'
import ProductFavourite from './components/Product/ProductFavourite.vue';

// Exportálás
export default {
    components: {
        ProductSizes,
        ProductData,
        ProductCategory,
        ProductRatingList,
        ProductRatingWrite,
        ProductCart,
        ProductImage,
        ProductPopup,
        ProductPopup,
        ProductFavourite
    },
    setup() {
        
        // Elemekre történő hivatkozások megadása
        let product_id = router.currentRoute.value.params.id;
        let response = ref(null);
        let product = ref({
            is_buyed: false
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

        return {
            getProduct,
            product,
            popup
        };
    }
}
</script>