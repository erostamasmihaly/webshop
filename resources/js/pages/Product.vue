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
            <ProductCart :prices="product.prices"/>
            <ProductImage :images="product.images"/>
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
import ProductCart from './components/ProductCart.vue'
import ProductImage from './components/ProductImage.vue'

// Exportálás
export default {
    components: { 
        ProductSizes, 
        ProductData, 
        ProductCategory,
        ProductRatingList,
        ProductRatingWrite,
        ProductCart,
        ProductImage
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
            product
        };
    }
}
</script>