<template>
    <div class="col-sm-4 col-md-2 col-6 text-center" style="cursor: pointer" @click="openProduct(item.id)">
        <p class="fw-bold">{{ item.name }}</p>
        <img :src="item.image" style="max-height: 100px; min-height: 100px;" class="img-thumbnail"/>
        <p>
            {{ item.discount_price }}<br>
            <button class="btn btn-primary">Megtekintés</button>
        </p>
    </div>
</template>
<script>
// Importálás
import router from '../../route'

// Exportálás
export default {
    // Változó definiálása
    props: ['item'],

    // Beállítás
    setup() {
        
        // Termék oldal megnyitása
        const openProduct = async(id) => {
            router.push('/vue/product/'+id);
        }

        // Visszatérés
        return {
            openProduct
        }
    }
}
</script>